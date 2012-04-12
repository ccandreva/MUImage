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
 * Generic item list content plugin base class
 */
class MUImage_ContentType_OneItem extends Content_AbstractContentType
{
    private $objectType;
    private $id;
    private $template;

    public function getModule()
    {
        return 'MUImage';
    }

    public function getName()
    {
        return 'OneItem';
    }

    public function getTitle()
    {
        $dom = ZLanguage::getModuleDomain('MUImage');
        return __('MUImage picture', $dom);
    }

    public function getDescription()
    {
        $dom = ZLanguage::getModuleDomain('MUImage');
        return __('Display One MUImage Picture.', $dom);
    }

    public function loadData(&$data)
    {

        if (!isset($data['template'])) {
            $data['template'] = 'oneitem_' . ucwords($this->objectType) . '_display.tpl';
        }
        
        $this->objectType = 'picture';      
        $this->id = $data['id'];
        $this->template = $data['template'];

    }

    public function display()
    {
        $dom = ZLanguage::getModuleDomain('MUImage');
        ModUtil::initOOModule('MUImage');

        $serviceManager = ServiceUtil::getManager();
        $entityManager = $serviceManager->getService('doctrine.entitymanager');
        $repository = $entityManager->getRepository('MUImage_Entity_' . ucfirst($this->objectType));

        // get objects from database
        $selectionArgs = array(
            'ot' => 'picture',
            'id' => $this->id);
        
        $entity = ModUtil::apiFunc('MUImage', 'selection', 'getEntity', $selectionArgs);

        //$this->view->setCaching(true);

        $data = array('objectType' => $this->objectType, 'id' => $this->id, 'template' => $this->template);

        // assign block vars and fetched data
        $this->view->assign('vars', $data)
                   ->assign('objectType', $this->objectType)
                   ->assign('item', $entity)
                   ->assign($repository->getAdditionalTemplateParameters('contentType'));

        $output = '';
        if (!empty($this->template) && $this->view->template_exists('contenttype/' . $this->template)) {
            $output = $this->view->fetch('contenttype/' . $this->template);
        }
        $templateForObjectType = str_replace('oneitem_', 'oneitem_' . ucwords($this->objectType) . '_', $this->template);
        if ($this->view->template_exists('contenttype/' . $templateForObjectType)) {
            $output = $this->view->fetch('contenttype/' . $templateForObjectType);
        } elseif ($this->view->template_exists('contenttype/' . $this->template)) {
            $output = $this->view->fetch('contenttype/' . $this->template);
        } else {
            $output = $this->view->fetch('contenttype/oneitem_Picture_display.tpl');
        }

        return $output;
    }

    public function displayEditing()
    {
        return $this->display();
    }

    public function getDefaultData()
    {
        return array('objectType' => 'picture',
                     'id' => null,
                     'template' => 'oneitem_display.tpl');
    }

    public function startEditing()
    {
        $dom = ZLanguage::getModuleDomain('MUImage');
        array_push($this->view->plugins_dir, 'modules/MUImage/templates/plugins');
    }
}
