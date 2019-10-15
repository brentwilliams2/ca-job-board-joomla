<?php
/**
 * Custom Joomla! HTMLHelper class for site edit view HTML widgets
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Usage in Blade templates:
 *     @jhtml('helper.editwidgets.methodName', parameter1, ...)
 *
 * These are based on the Akeeba FEF (front-end framework) helpers included in FOF with revised HTML output
 */

// Can't namespace since this class is used through Joomla's autoloader and JHtml system, and class
// names have to be lower-cased and follow a naming convention for the JLoader scheme to work.

use \Calligraphic\Cajobboard\Site\Helper\Html\Utility;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;

abstract class HelperEditwidgets
{
  /**
   * Method to create an HTML element tag for an item's 'title' model field,
	 * wrapped in an anchor tag to that item's item view.
	 *
   * @param   string    $createdOn      The date the item was created.
   * @param 	string 		$prefix         A prefix to prepend to a class attribute, e.g. 'prefix-edit-link' and 'prefix-edit-btn' classes
   * @param 	string    $crud           The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function createdOn($createdOn, $prefix = null, $crud = null)
	{
    $class  = Utility::getAttributeClass('created-on', $prefix, $crud);

    $html  = '<span class="' . $class . '">';
		$html .= Text::_('COM_CAJOBBOARD_CREATED_ON_BUTTON_LABEL');
    $html .= '</span>';

    return $html;
  }


  /**
   * Method to create an HTML element tag to edit an item's 'description' model field
	 *
   * @param   string    $description              The description text of the item, already sanitized.
   * @param   string    $descriptionPlaceholder   Place-holder text to use if on an 'add' view
   * @param   string    $humanViewNameSingular    A human-readable singularlized view name, e.g. 'Job Posting'
   * @param 	string 		$prefix                   A prefix to prepend to a class attribute, e.g. 'prefix-edit-link' and 'prefix-edit-btn' classes
   * @param 	string    $crud                     The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function description($description, $descriptionPlaceholder, $humanViewNameSingular, $prefix = null, $crud = null)
	{
    $class  = Utility::getAttributeClass('description', $prefix, $crud);

    $html  = '<div class="' . $class . '">';
    $html .= '<h4>';
    $html .= '<label for="description">';
    $html .= Text::sprintf('COM_CAJOBBOARD_DESCRIPTION_EDIT_LABEL', $humanViewNameSingular);
    $html .= '</label>';
    $html .= '</h4>';
    $html .= '<textarea name="description" id="' . $prefix . '-description" class="form-control" rows="8" placeholder="' . $descriptionPlaceholder . '">';
    $html .= $description;
    $html .= '</textarea>';
    $html .= '</div>';

    return $html;
  }


  /**
   * Method to create an HTML element tag to edit an item's 'description_intro' model field
	 *
   * @param   string    $description              The description intro text of the item, already sanitized.
   * @param   string    $descriptionPlaceholder   Place-holder description intro text to use if on an 'add' view
   * @param   string    $humanViewNameSingular    A human-readable singularlized view name, e.g. 'Job Posting'
   * @param 	string 		$prefix                   A prefix to prepend to a class attribute, e.g. 'prefix-edit-link' and 'prefix-edit-btn' classes
   * @param 	string    $crud                     The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function description_intro($descriptionIntro, $descriptionIntroPlaceholder, $humanViewNameSingular, $prefix = null, $crud = null)
	{
    $class  = Utility::getAttributeClass('description-intro', $prefix, $crud);

    $html  = '<div class="' . $class . '">';
    $html .= '<h4>';
    $html .= '<label for="description_intro">';
    $html .= Text::sprintf('COM_CAJOBBOARD_DESCRIPTION_INTRO_EDIT_LABEL', $humanViewNameSingular);
    $html .= '</label>';
    $html .= '</h4>';
    $html .= '<textarea name="description_intro" id="' . $prefix . '-description_intro" class="form-control" rows="8" placeholder="' . $descriptionIntroPlaceholder . '">';
    $html .= $descriptionIntro;
    $html .= '</textarea>';
    $html .= '</div>';

    return $html;
  }


  /**
   * Method to create an HTML element tag for the edit view page title (header).
	 * Builds translation keys in the 
	 *
   * @param   string    $isEditView             Whether the current task is 'edit'
   * @param   string    $humanViewNameSingular  A human-readable singularlized view name, e.g. 'Job Posting'
   * @param 	string 		$prefix                 A prefix to prepend to a class attribute, e.g. 'prefix-edit-link' and 'prefix-edit-btn' classes.
   * @param 	string    $crud                   The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'.
	 *
	 * @return  string
	 */
	public static function header($isEditView, $humanViewNameSingular, $prefix = null, $crud = null)
	{
    $class  = Utility::getAttributeClass('header', $prefix, $crud);
    $viewTransKey = $isEditView ? 'EDIT' : 'ADD';

    $html  = '<h3 class="' . $class . '">';
    $html .= Text::sprintf('COM_CAJOBBOARD_' . $viewTransKey . '_HEADER', $humanViewNameSingular);
    $html .= '</h3>';

    return $html;
  }


  /**
   * Method to create an HTML element tag for an item's 'title' model field,
	 * wrapped in an anchor tag to that item's item view.
	 *
   * @param   string    $modifiedOn     The last modified date of the item.
   * @param 	string 		$prefix         A prefix to prepend to a class attribute, e.g. 'prefix-edit-link' and 'prefix-edit-btn' classes
   * @param 	string    $crud           The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function modifiedOn($modifiedOn, $prefix = null, $crud = null)
	{
    $class  = Utility::getAttributeClass('modified-on', $prefix, $crud);

    $html  = '<span class="' . $class . '">';
    $html .= Text::_('COM_CAJOBBOARD_MODIFIED_ON_BUTTON_LABEL');
    $html .= $modifiedOn;
    $html .= '</span>';

    return $html;
  }


  /**
   * Method to create an HTML element tag to edit an item's 'title' model field
	 *
   * @param   string    $text                   The text of the item, already sanitized.
   * @param   string    $textPlaceholder        Place-holder text to use if on an 'add' view
   * @param   string    $humanViewNameSingular  A human-readable singularlized view name, e.g. 'Job Posting'
   * @param 	string 		$prefix                 A prefix to prepend to a class attribute, e.g. 'prefix-edit-link' and 'prefix-edit-btn' classes
   * @param 	string    $crud                   The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function text($text, $textPlaceholder, $humanViewNameSingular, $prefix = null, $crud = null)
	{
    $class  = Utility::getAttributeClass('text', $prefix, $crud);

    $html  = '<div class="' . $class . '">';
    $html .= '<h4>';
    $html .= '<label for="text">';
    $html .= Text::sprintf('COM_CAJOBBOARD_TEXT_EDIT_LABEL', $humanViewNameSingular);
    $html .= '</label>';
    $html .= '</h4>';
    $html .= '<textarea name="text" id="' . $prefix . '-text" class="form-control" rows="8" placeholder="' . $textPlaceholder . '">';
    $html .= $text;
    $html .= '</textarea>';
    $html .= '</div>';

    return $html;
  }


  /**
   * Method to create an HTML element tag to edit an item's 'title' model field
	 *
   * @param   string    $title                  The title of the item, already sanitized.
   * @param   string    $titlePlaceholder       Place-holder text to use for the title if on an 'add' view
   * @param   string    $humanViewNameSingular  A human-readable singularlized view name, e.g. 'Job Posting'
   * @param 	string 		$prefix                 A prefix to prepend to a class attribute, e.g. 'prefix-edit-link' and 'prefix-edit-btn' classes
   * @param 	string    $crud                   The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function title($title, $titlePlaceholder, $humanViewNameSingular, $prefix = null, $crud = null)
	{
    $class  = Utility::getAttributeClass($title, $prefix, $crud);

    $html  = '<div class="' . $class . '">';
    $html .= '<h4>';
    $html .= '<label for="name">';
    $html .= Text::sprintf('COM_CAJOBBOARD_TITLE_EDIT_LABEL', $humanViewNameSingular);
    $html .= '</label>';
    $html .= '</h4>';
    $html .= '<input type="text" class="form-control" name="name" id="' . $prefix . '-title-input" value="' . $title . '" placeholder="' . $titlePlaceholder . '"/>';
    $html .= '</div>';

    return $html;
  }
}
