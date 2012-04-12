<?php
/**
 * MUImage.
 *
 * @copyright Michael Ueberschaer
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @package MUImage
 * @author Michael Ueberschaer <kontakt@webdesign-in-bremen.com>.
 * @link http://www.webdesign-in-bremen.com
 * @link http://zikula.org
 * @version Generated by ModuleStudio 0.5.4 (http://modulestudio.de) at Fri Jan 27 19:27:23 CET 2012.
 */

/**
 * Generic item list block base class
 */
class MUImage_Block_OneItem extends Zikula_Controller_AbstractBlock
{
    /**
     * Initialise the block
     */
    public function init()
    {
        SecurityUtil::registerPermissionSchema('MUImage:OneItemBlock:', 'Block title::');
    }

    /**
     * Get information on the block
     *
     * @return       array       The block information
     */
    public function info()
    {
        $requirementMessage = '';
        // check if the module is available at all
        if (!ModUtil::available('MUImage')) {
            $requirementMessage .= $this->__('Notice: This block will not be displayed until you activate the MUImage module.');
        }

        return array('module'           => 'MUImage',
                     'text_type'        => $this->__('One Item'),
                     'text_type_long'   => $this->__('Show one item of MUImage by id.'),
                     'allow_multiple'   => true,
                     'form_content'     => false,
                     'form_refresh'     => false,
                     'show_preview'     => true,
                     'admin_tableless'  => true,
                     'requirement'      => $requirementMessage);
    }

    /**
     * Display the block
     *
     * @param        array       $blockinfo a blockinfo structure
     * @return       output      the rendered block
     */
    public function display($blockinfo)
    {
        // only show block content if the user has the required permissions
        if (!SecurityUtil::checkPermission('MUImage:OneItemBlock:', "$blockinfo[title]::", ACCESS_OVERVIEW)) {
            return false;
        }

        // check if the module is available at all
        if (!ModUtil::available('MUImage')) {
            return false;
        }

        // get current block content
        $vars = BlockUtil::varsFromContent($blockinfo['content']);
        $vars['bid'] = $blockinfo['bid'];

        // set default values for all params which are not properly set
        if (!isset($vars['objectType']) || empty($vars['objectType'])) {
            $vars['objectType'] = 'movie';
        }
        if (!isset($vars['id']) || empty($vars['id'])) {
            $vars['id'] = null;
        }
        if (!isset($vars['showtitle']) || empty($vars['showtitle'])) {
            $vars['showtitle'] = 0;
        }        
        if (!isset($vars['template'])) {
            $vars['template'] = 'oneitem_' . ucwords($vars['objectType']) . '_display.tpl';
        }
        ModUtil::initOOModule('MUImage');

        if (!isset($vars['objectType']) || !in_array($vars['objectType'], MUImage_Util_Controller::getObjectTypes('block'))) {
            $vars['objectType'] = MUImage_Util_Controller::getDefaultObjectType('block');
        }

        $objectType = $vars['objectType'];

        $serviceManager = ServiceUtil::getManager();
        $entityManager = $serviceManager->getService('doctrine.entitymanager');
        $repository = $entityManager->getRepository('MUImage_Entity_' . ucfirst($objectType));


        // get objects from database
        $selectionArgs = array(
            'ot' => $objectType,
            'id' => $vars['id'],
        );
        
        $entity = ModUtil::apiFunc('MUImage', 'selection', 'getEntity', $selectionArgs);

        //$this->view->setCaching(true);

        // assign block vars and fetched data
        $this->view->assign('vars', $vars)
                   ->assign('objectType', $objectType)
                   ->assign('item', $entity)
                   ->assign($repository->getAdditionalTemplateParameters('block'));

        if ($vars['showtitle'] == 1) {
            // set a block title
            if (empty($blockinfo['title'])) {
                $blockinfo['title'] = $this->__('One MUImage Item');
            }
        }

        $output = '';
        $templateForObjectType = str_replace('oneitem_', 'oneitem_' . ucwords($objectType) . '_', $vars['template']);
        if ($this->view->template_exists('contenttype/' . $templateForObjectType)) {
            $output = $this->view->fetch('contenttype/' . $templateForObjectType);
        } elseif ($this->view->template_exists('contenttype/' . $vars['template'])) {
            $output = $this->view->fetch('contenttype/' . $vars['template']);
        } elseif ($this->view->template_exists('block/' . $templateForObjectType)) {
            $output = $this->view->fetch('block/' . $templateForObjectType);
        } elseif ($this->view->template_exists('block/' . $vars['template'])) {
            $output = $this->view->fetch('block/' . $vars['template']);
        } else {
            $output = $this->view->fetch('block/oneitem.tpl');
        }

        $blockinfo['content'] = $output;

        // return the block to the theme
        return BlockUtil::themeBlock($blockinfo);
    }

    /**
     * Modify block settings
     *
     * @param        array       $blockinfo a blockinfo structure
     * @return       output      the block form
     */
    public function modify($blockinfo)
    {
        // Get current content
        $vars = BlockUtil::varsFromContent($blockinfo['content']);

        // set default values for all params which are not properly set
        if (!isset($vars['objectType']) || empty($vars['objectType'])) {
            $vars['objectType'] = 'movie';
        }
        if (!isset($vars['id']) || $vars['id'] == '') {
            $vars['id'] = 0;
        }
        if (!isset($vars['showtitle']) || $vars['showtitle'] == '') {
            $vars['showtitle'] = 0;
        }
        if (!isset($vars['template'])) {
            $vars['template'] = 'oneitem_' . $vars['objectType'] . '_display.tpl';
        }

        $this->view->setCaching(false);

        // assign the approriate values
        $this->view->assign($vars);

        // clear the block cache
        $this->view->clear_cache('block/oneitem_display.tpl');
        $this->view->clear_cache('block/oneitem_' . ucwords($vars['objectType']) . '_display.tpl');
        $this->view->clear_cache('block/oneitem_display_description.tpl');
        $this->view->clear_cache('block/oneitem_' . ucwords($vars['objectType']) . '_display_description.tpl');

        // Return the output that has been generated by this function
        return $this->view->fetch('block/oneitem_modify.tpl');
    }

    /**
     * Update block settings
     *
     * @param        array       $blockinfo a blockinfo structure
     * @return       $blockinfo  the modified blockinfo structure
     */
    public function update($blockinfo)
    {
        // Get current content
        $vars = BlockUtil::varsFromContent($blockinfo['content']);

        $vars['objectType'] = $this->request->getPost()->filter('objecttype', 'movie', FILTER_SANITIZE_STRING);
        $vars['id'] = (int) $this->request->getPost()->filter('id', 0, FILTER_SANITIZE_STRING);
        $vars['showtitle'] = (int) $this->request->getPost()->filter('showtitle', 0, FILTER_SANITIZE_STRING);
        $vars['template'] = $this->request->getPost()->get('template', '');

        if (!in_array($vars['objectType'], MUImage_Util_Controller::getObjectTypes('block'))) {
            $vars['objectType'] = MUImage_Util_Controller::getDefaultObjectType('block');
        }

        // write back the new contents
        $blockinfo['content'] = BlockUtil::varsToContent($vars);

        // clear the block cache
        $this->view->clear_cache('block/oneitem_display.tpl');
        $this->view->clear_cache('block/oneitem_' . ucwords($vars['objectType']) . '_display.tpl');
        $this->view->clear_cache('block/oneitem_display_description.tpl');
        $this->view->clear_cache('block/oneitem_' . ucwords($vars['objectType']) . '_display_description.tpl');

        return $blockinfo;
    }

}
