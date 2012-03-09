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
