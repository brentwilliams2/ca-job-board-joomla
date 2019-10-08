<?php
/**
 * Custom Joomla! HTMLHelper class for site item view HTML widgets
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Usage in Blade templates:
 *     @jhtml('helper.itemwidgets.methodName', parameter1, ...)
 *
 * These are based on the Akeeba FEF (front-end framework) helpers included in FOF with revised HTML output
 */

// Can't namespace since this class is used through Joomla's autoloader and JHtml system, and class
// names have to be lower-cased and follow a naming convention for the JLoader scheme to work.

// no direct access
defined('_JEXEC') or die;

use \Joomla\CMS\Language\Text;

abstract class helperItemwidgets
{
  /**
	 * Method to create an HTML element tag for an item's 'title' model field,
	 * wrapped in an anchor tag to that item's item view.
	 *
   * @param   string    $title          The title of the item, already sanitized.
   * @param 	string 		$prefix         A prefix to prepend to a class attribute, e.g. 'prefix-edit-link' and 'prefix-edit-btn' classes
   * @param 	string    $crud           The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function title($title, $prefix = null, $crud = null)
	{
    $class  = self::getAttributeClass('title', $prefix, $crud);

    $html  = '<h4 class="' . $class . '">';
		$html .= $title;
    $html .= '</h4>';

    return $html;
  }


  /**
	 * Method to create an HTML element tag for an item's Author relation's 'name' model field.
	 *
   * @param 	string    $suffix   The element's suffix to use for a class attribute name, e.g. 'author-avatar' (same as field name)
   * @param 	string    $prefix   A prefix to prepend to a class attribute, e.g. a 'prefix-created-on-date' class
   * @param 	string    $crud     The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function getAttributeClass($suffix, $prefix = null, $crud = null)
	{
    $class  = $crud ? $crud . ' ' : '';
    $class .= 'common-' . $suffix;
    $class .= $prefix ? ' ' . $prefix . '-' . $suffix : '';

    return $class;
  }
}