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
 * @version Generated by ModuleStudio 0.5.4 (http://modulestudio.de) at Fri Feb 17 18:57:24 CET 2012.
 */

/**
 * The muimageContingent modifier creates the out put about the contingent of a user
 *
 * @return string contingent of Main Ablums, Sub Albums and Pictures
 */
function smarty_modifier_muimageContingent()
{	
	return MUImage_Util_View::contingent();
}
