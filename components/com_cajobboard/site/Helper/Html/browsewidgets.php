<?php
/**
 * Custom Joomla! HTMLHelper class for site browse view HTML widgets
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Usage in Blade templates:
 *     @jhtml('helper.browsewidgets.methodName', parameter1, ...)
 *
 * These are based on the Akeeba FEF (front-end framework) helpers included in FOF with revised HTML output
 */

// Can't namespace since this class is used through Joomla's autoloader and JHtml system, and class
// names have to be lower-cased and follow a naming convention for the JLoader scheme to work.

// no direct access
defined('_JEXEC') or die;

use \Calligraphic\Cajobboard\Site\Helper\Html\Utility;
use \Joomla\CMS\Language\Text;

abstract class helperBrowsewidgets
{
	/**
	 * Method to create an HTML element tag for a browse view item's 'text' model field.
	 *
   * @param   string    $text     The text of the item, already sanitized.
   * @param 	string 		$prefix   A prefix to prepend to a class attribute, e.g. 'prefix-edit-link' and 'prefix-edit-btn' classes
   * @param 	string    $crud     The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function text($text, $prefix = null, $crud = null)
	{
    $class  = Utility::getAttributeClass('text', $prefix, $crud);

		$html  = '<p class="' . $class . '">';
		$html .= $text;
    $html .= '</p>';

    return $html;
  }


  /**
	 * Method to create an HTML element tag for a browse view item's 'title' model field, wrapped in an anchor tag to that item's item view.
	 *
   * @param   string    $title          The title of the item, already sanitized.
	 * @param 	string 		$itemViewLink		The URL to the item's item view.
   * @param 	string 		$prefix         A prefix to prepend to a class attribute, e.g. 'prefix-edit-link' and 'prefix-edit-btn' classes
   * @param 	string    $crud           The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function title($title, $itemViewLink, $prefix = null, $crud = null)
	{
    $class  = Utility::getAttributeClass('title', $prefix, $crud);

    $html  = '<h4>';
		$html .= '<a class="' . $class . '" href="' . $itemViewLink . '">';
		$html .= $title;
    $html .= '</a>';
    $html .= '</h4>';

    return $html;
  }
}
