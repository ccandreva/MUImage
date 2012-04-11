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
 * @version Generated by ModuleStudio 0.5.4 (http://modulestudio.de) at Sat Feb 18 18:42:39 CET 2012.
 */

/**
 * Utility implementation class for view helper methods.
 */
class MUImage_Util_View extends MUImage_Util_Base_View
{
	
	/**
	 * 
	 * Returning the albums
	 */
	
	public static function getAlbums() {
		
		$repository = MUImage_Util_View::getAlbumRepository();
		$albums = $repository->selectWhere();
		
		return $albums;
	} 
	
	/**
	 * 
	 * Counting of total pictures
	 */
    public static function countPictures() {
    	
    	$view = new Zikula_Request_Http();
    	$id = (int) $view->getGet()->filter('id', 0, FILTER_SANITIZE_STRING);
    	if ($id != 0) {
    		
    		$where = 'tbl.album_id = \'' . DataUtil::formatForStore($id) . '\'';
    		
    		$repository = MUImage_Util_View::getPictureRepository();
    	    $count = $repository->selectCount();
    	}
    	return $count;
    }
    
    /**
     * 
     * Counting of total albums
     */
    public static function countAlbums() {
    	
    	$view = new Zikula_Request_Http();
    	$id = (int) $view->getGet()->filter('id', 0, FILTER_SANITIZE_STRING);
    	if ($id != 0) {
    		
    		$where = 'tbl.album_id = \'' . DataUtil::formatForStore($id) . '\'';
    		
    		$repository = MUImage_Util_View::getAlbumRepository();
    	    $count = $repository->selectCount();
    	}
    	return $count;
    }
    
    /**
	*
	 This method is for getting a repository for pictures
	*
	*/
    
    public static function getPictureRepository() {
    
     $serviceManager = ServiceUtil::getManager();
     $entityManager = $serviceManager->getService('doctrine.entitymanager');
     $repository = $entityManager->getRepository('MUImage_Entity_Picture');
    
     return $repository;
    }
    
    /**
	*
	 This method is for getting a repository for albums
	*
	*/
    
    public static function getAlbumRepository() {
    
     $serviceManager = ServiceUtil::getManager();
     $entityManager = $serviceManager->getService('doctrine.entitymanager');
     $repository = $entityManager->getRepository('MUImage_Entity_Album');
    
     return $repository;
    }   
}
