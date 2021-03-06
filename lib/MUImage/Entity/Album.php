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
 * @version Generated by ModuleStudio 0.5.4 (http://modulestudio.de) at Thu Feb 23 22:43:24 CET 2012.
 */

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use DoctrineExtensions\StandardFields\Mapping\Annotation as ZK;

/**
 * Entity class that defines the entity structure and behaviours.
 *
 * This is the concrete entity class for album entities.
 * @ORM\Entity(repositoryClass="MUImage_Entity_Repository_Album")
 * @ORM\Table(name="muimage_album")
 * @ORM\HasLifecycleCallbacks
 */
class MUImage_Entity_Album extends MUImage_Entity_Base_Album
{
	/**
	 * Collect available actions for this entity.
	 */
	protected function prepareItemActions()
	{
		if (!empty($this->_actions)) {
			return;
		}

		$currentType = FormUtil::getPassedValue('type', 'user', 'GETPOST', FILTER_SANITIZE_STRING);
		$currentFunc = FormUtil::getPassedValue('func', 'main', 'GETPOST', FILTER_SANITIZE_STRING);
		$dom = ZLanguage::getModuleDomain('MUImage');
		if ($currentType == 'admin') {
			if (in_array($currentFunc, array('main', 'view'))) {
				/* $this->_actions[] = array(
				 'url' => array('type' => 'user', 'func' => 'display', 'arguments' => array('ot' => 'album', 'id' => $this['id'])),
						'icon' => 'preview',
						'linkTitle' => __('Open preview page', $dom),
						'linkText' => __('Preview', $dom)
				); */
				$this->_actions[] = array(
						'url' => array('type' => 'admin', 'func' => 'display', 'arguments' => array('ot' => 'album', 'id' => $this['id'])),
						'icon' => 'display',
						'linkTitle' => str_replace('"', '', $this['title']),
						'linkText' => __('Details', $dom)
				);
			}

			if (in_array($currentFunc, array('main', 'view', 'display'))) {
				if (SecurityUtil::checkPermission('MUImage::', '.*', ACCESS_EDIT)) {

					$this->_actions[] = array(
							'url' => array('type' => 'admin', 'func' => 'edit', 'arguments' => array('ot' => 'album', 'id' => $this['id'])),
							'icon' => 'edit',
							'linkTitle' => __('Edit', $dom),
							'linkText' => __('Edit', $dom)
					);
					/*  $this->_actions[] = array(
					 'url' => array('type' => 'admin', 'func' => 'edit', 'arguments' => array('ot' => 'album', 'astemplate' => $this['id'])),
							'icon' => 'saveas',
							'linkTitle' => __('Reuse for new item', $dom),
							'linkText' => __('Reuse', $dom)
					); */
				}
				if (SecurityUtil::checkPermission('MUImage::', '.*', ACCESS_DELETE)) {
					$this->_actions[] = array(
							'url' => array('type' => 'admin', 'func' => 'delete', 'arguments' => array('ot' => 'album', 'id' => $this['id'])),
							'icon' => 'delete',
							'linkTitle' => __('Delete', $dom),
							'linkText' => __('Delete', $dom)
					);
				}
			}
			if ($currentFunc == 'display') {
				$this->_actions[] = array(
						'url' => array('type' => 'admin', 'func' => 'view', 'arguments' => array('ot' => 'album')),
						'icon' => 'back',
						'linkTitle' => __('Back to overview', $dom),
						'linkText' => __('Back to overview', $dom)
				);
			}
		}
		if ($currentType == 'user') {
			/* if (in_array($currentFunc, array('main', 'view'))) {
			 $this->_actions[] = array(
			 		'url' => array('type' => 'user', 'func' => 'display', 'arguments' => array('ot' => 'album', 'id' => $this['id'])),
			 		'icon' => 'display',
			 		'linkTitle' => str_replace('"', '', $this['title']),
			 		'linkText' => __('Details', $dom)
			 );
			}*/

			if (in_array($currentFunc, array('main', 'view', 'display'))) {
				if (SecurityUtil::checkPermission('MUImage::', '.*', ACCESS_EDIT)) {
					$this->_actions[] = array(
							'url' => array('type' => 'user', 'func' => 'display', 'arguments' => array('ot' => 'album', 'id' => $this['id'])),
							'icon' => 'display',
							'linkTitle' => str_replace('"', '', $this['title']),
							'linkText' => __('Details', $dom)
					);
					$this->_actions[] = array(
							'url' => array('type' => 'user', 'func' => 'edit', 'arguments' => array('ot' => 'album', 'id' => $this['id'])),
							'icon' => 'edit',
							'linkTitle' => __('Edit', $dom),
							'linkText' => __('Edit', $dom)
					);
					/*  $this->_actions[] = array(
					 'url' => array('type' => 'user', 'func' => 'edit', 'arguments' => array('ot' => 'album', 'astemplate' => $this['id'])),
							'icon' => 'saveas',
							'linkTitle' => __('Reuse for new item', $dom),
							'linkText' => __('Reuse', $dom)
					);*/
				}
				if (SecurityUtil::checkPermission('MUImage::', '.*', ACCESS_DELETE) && MUImage_Util_View::isAdmin() === true) {
					$this->_actions[] = array(
							'url' => array('type' => 'user', 'func' => 'delete', 'arguments' => array('ot' => 'album', 'id' => $this['id'])),
							'icon' => 'delete',
							'linkTitle' => __('Delete', $dom),
							'linkText' => __('Delete', $dom)
					);
				}
			}
			if ($currentFunc == 'display') {
				/*  $this->_actions[] = array(
				 'url' => array('type' => 'user', 'func' => 'view', 'arguments' => array('ot' => 'album')),
						'icon' => 'back',
						'linkTitle' => __('Back to overview', $dom),
						'linkText' => __('Back to overview', $dom)
				);*/
			}
		}
	}

	/**
	 * Post-Process the data after the entity has been constructed by the entity manager.
	 *
	 * @ORM\PostLoad
	 * @see MUImage_Entity_Base_Album::performPostLoadCallback()
	 * @return void.
	 */
	public function postLoadCallback()
	{
		$this->performPostLoadCallback();
	}

	/**
	 * Pre-Process the data prior to an insert operation.
	 *
	 * @ORM\PrePersist
	 * @see MUImage_Entity_Base_Album::performPrePersistCallback()
	 * @return void.
	 */
	public function prePersistCallback()
	{
		$this->performPrePersistCallback();
	}

	/**
	 * Post-Process the data after an insert operation.
	 *
	 * @ORM\PostPersist
	 * @see MUImage_Entity_Base_Album::performPostPersistCallback()
	 * @return void.
	 */
	public function postPersistCallback()
	{
		$this->performPostPersistCallback();
	}

	/**
	 * Pre-Process the data prior a delete operation.
	 *
	 * @ORM\PreRemove
	 * @see MUImage_Entity_Base_Album::performPreRemoveCallback()
	 * @return void.
	 */
	public function preRemoveCallback()
	{
		$this->performPreRemoveCallback();
	}

	/**
	 * Post-Process the data after a delete.
	 *
	 * @ORM\PostRemove
	 * @see MUImage_Entity_Base_Album::performPostRemoveCallback()
	 * @return void
	 */
	public function postRemoveCallback()
	{
		$this->performPostRemoveCallback();
	}

	/**
	 * Pre-Process the data prior to an update operation.
	 *
	 * @ORM\PreUpdate
	 * @see MUImage_Entity_Base_Album::performPreUpdateCallback()
	 * @return void.
	 */
	public function preUpdateCallback()
	{
		$this->performPreUpdateCallback();
	}

	/**
	 * Post-Process the data after an update operation.
	 *
	 * @ORM\PostUpdate
	 * @see MUImage_Entity_Base_Album::performPostUpdateCallback()
	 * @return void.
	 */
	public function postUpdateCallback()
	{
		$this->performPostUpdateCallback();
	}

	/**
	 * Pre-Process the data prior to a save operation.
	 *
	 * @ORM\PrePersist
	 * @ORM\PreUpdate
	 * @see MUImage_Entity_Base_Album::performPreSaveCallback()
	 * @return void.
	 */
	public function preSaveCallback()
	{
		$this->performPreSaveCallback();
	}

	/**
	 * Post-Process the data after a save operation.
	 *
	 * @ORM\PostPersist
	 * @ORM\PostUpdate
	 * @see MUImage_Entity_Base_Album::performPostSaveCallback()
	 * @return void.
	 */
	public function postSaveCallback()
	{
		$this->performPostSaveCallback();
	}

}
