<?php
/**
 * Custom Joomla! HTMLHelper class for site view Common HTML widgets
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Usage in Blade templates:
 *     @jhtml('helper.commonwidgets.methodName', parameter1, ...)
 *
 * These are based on the Akeeba FEF (front-end framework) helpers included in FOF with revised HTML output
 */

// Can't namespace since this class is used through Joomla's autoloader and JHtml system, and class
// names have to be lower-cased and follow a naming convention for the JLoader scheme to work.

// no direct access
defined('_JEXEC') or die;

use \Calligraphic\Cajobboard\Site\Helper\Html\Utility;
use \FOF30\View\View;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;

abstract class helperCommonwidgets
{
  /**
	 * Method to create an HTML element tag for an item's Author relation's 'name' model field.
	 *
   * @param 	\Joomla\CMS\User\User 	$author		The Author instance relation properties value object.
   * @param 	string                  $prefix   A prefix to prepend to a class attribute, e.g. a 'prefix-created-on-date' class
   * @param 	string                  $crud     The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function authorAvatar($author, $prefix = null, $crud = null)
	{
    $class  = Utility::getAttributeClass('author-avatar', $prefix, $crud);

    $html  = '<a class="' . $class . '" href="' . $author->profileLink . '">';
    $html .= '<img src="' . $author->avatarUri . '" alt="Avatar" class="img-thumbnail" height="24" width="24">';
    $html .= '</a>';

    return $html;
  }


  /**
	 * Method to create an HTML element tag for an item's Author relation's 'last_seen' model field.
	 *
   * @param 	\Joomla\CMS\User\User 	$author		The Author instance relation properties value object.
   * @param 	string                  $prefix   A prefix to prepend to a class attribute, e.g. a 'prefix-created-on-date' class
   * @param 	string                  $crud     The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function authorLastSeen($author, $prefix = null, $crud = null)
	{
    $class  = Utility::getAttributeClass('author-last-seen', $prefix, $crud);

    $html  = '<span class="' . $class . '">';
    $html .= $author->lastSeen;
    $html .= '</span>';

    return $html;
  }


	/**
	 * Method to create an HTML element tag for an item's Author relation's 'name' model field.
	 *
	 * @param 	\Joomla\CMS\User\User 	$author		The Author instance relation properties value object.
   * @param 	string                  $prefix   A prefix to prepend to a class attribute, e.g. a 'prefix-created-on-date' class
   * @param 	string                  $crud     The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function authorName($author, $prefix = null, $crud = null)
	{
    $class  = Utility::getAttributeClass('author-name', $prefix, $crud);

    $html  = '<a class="' . $class . '" href="' . $author->profileLink . '">';
    $html .= $author->name;
    $html .= '</a>';

    return $html;
	}


	/**
	 * Method to create an HTML element tag for an item's 'category' model field.
	 *
   * @param   string    $category   The category name of the item, already sanitized.
   * @param 	string 		$prefix   	A prefix to prepend to a class attribute, e.g. 'prefix-edit-link' and 'prefix-edit-btn' classes
   * @param 	string    $crud     	The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function bespokeCategory($category, $prefix = null, $crud = null)
	{
    $class  = Utility::getAttributeClass('category', $prefix, $crud);

		$html  = '<p class="' . $class . '">';
		$html .= Text::_($category);
    $html .= '</p>';

    return $html;
  }


  /**
	 * Method to create an HTML element tag from an item's $createdOn local variable.
	 *
	 * @param 	string    $createdOn		A formatted string built from the 'created_on' model field.
   * @param 	string    $prefix       A prefix to prepend to a class attribute, e.g. a 'prefix-created-on-date' class
   * @param 	string    $crud         The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function createdOn($createdOn, $prefix = null, $crud = null)
	{
    $class  = Utility::getAttributeClass('created-on', $prefix, $crud);

		$html  = '<span class="' . $class . '">';
		$html .= Text::_('COM_CAJOBBOARD_CREATED_ON_BUTTON_LABEL') . ' ';
    $html .= $createdOn;
    $html .= '</span>';

    return $html;
  }


	/**
	 * Method to create an HTML element tag for an item's 'description' model field.
	 *
   * @param   string    $description    The description text of the item, already sanitized.
   * @param 	string 		$prefix         A prefix to prepend to a class attribute, e.g. 'prefix-edit-link' and 'prefix-edit-btn' classes
   * @param 	string    $crud           The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function description($description, $prefix = null, $crud = null)
	{
    $class  = Utility::getAttributeClass('description', $prefix, $crud);

		$html  = '<p class="' . $class . '">';
		$html .= $description;
    $html .= '</p>';

    return $html;
  }


	/**
	 * Method to create an HTML element tag for an item's 'text' model field.
	 *
   * @param   string    $descriptionIntro   The text of the item, already sanitized.
   * @param 	string 		$prefix             A prefix to prepend to a class attribute, e.g. 'prefix-edit-link' and 'prefix-edit-btn' classes
   * @param 	string    $crud               The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function description_intro($descriptionIntro, $prefix = null, $crud = null)
	{
    $class  = Utility::getAttributeClass('description-intro', $prefix, $crud);

		$html  = '<p class="' . $class . '">';
		$html .= $descriptionIntro;
    $html .= '</p>';

    return $html;
	}


	/**
	 * Method to create an HTML element tag for an item's 'url' model field.
	 *
   * @param   string    $url   		The url of the item, already sanitized.
   * @param 	string 		$prefix   A prefix to prepend to a class attribute, e.g. 'prefix-edit-link' and 'prefix-edit-btn' classes
   * @param 	string    $crud    	The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function url($url, $prefix = null, $crud = null)
	{
    $class  = Utility::getAttributeClass('url', $prefix, $crud);

		$html  = '<p class="' . $class . '">';
		$html .= $url;
    $html .= '</p>';

    return $html;
  }


	/**
   * Method to return standard class attributes for an HTML element based on a given prefix, suffic, and task name.
   * This is a wrapper to allow the Utility static method to be used with Joomla!'s JHtml system, which can't handle namespaced classes.
	 *
   * @param 	string    $suffix   The element's suffix to use for a class attribute name, e.g. 'author-avatar' (same as field name)
   * @param 	string    $prefix   A prefix to prepend to a class attribute, e.g. a 'prefix-created-on-date' class
   * @param 	string    $crud     The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function getAttributeClass($suffix, $prefix = null, $crud = null)
	{
    return Utility::getAttributeClass($suffix, $prefix, $crud);
  }
}