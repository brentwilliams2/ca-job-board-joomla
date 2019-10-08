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

use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;

abstract class HelperEditwidgets
{
  /**
	 * Method to create an HTML element tag for a cancel button to use on edit views,
	 * wrapped in an anchor tag to that item's item view
	 *
   * @param   boolean   $itemViewLink   A link to the item view of this item.
   * @param 	string    $prefix         A prefix to prepend to a class attribute, e.g. 'prefix-delete-link' and 'prefix-delete-btn' classes
   * @param 	string    $crud           The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function cancel($itemViewLink, $prefix = null, $crud = null)
	{
    $anchorClass  = self::getAttributeClass('cancel-link', $prefix, $crud);
    $baseBtnClass = self::getAttributeClass('btn', $prefix);
    $btnClass  = self::getAttributeClass('cancel-btn', $prefix, $crud);

    $html  = '<a class=" ' . $anchorClass . '" href="' . $itemViewLink . '">';
    $html .= '<button type="button" class="btn btn-danger btn-primary ' . $baseBtnClass . ' ' . $btnClass . ' pull-right">';
    $html .= Text::_('JCANCEL');
    $html .= '</button>';
    $html .= '</a>';

    return $html;
  }


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
    $class  = self::getAttributeClass('created-on', $prefix, $crud);

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
    $class  = self::getAttributeClass('description', $prefix, $crud);

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
    $class  = self::getAttributeClass('description-intro', $prefix, $crud);

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
	 * Method to create an HTML element tag for an item's 'title' model field,
	 * wrapped in an anchor tag to that item's item view
	 *
   * @param   boolean   $canUserEdit            Whether the user has canEdit ACL privileges
   * @param   int       $itemId                 The primary key value (id) for the item
   * @param   string    $humanViewNameSingular  A human-readable singularlized view name, e.g. 'Job Posting'
   * @param 	string    $prefix                 A prefix to prepend to a class attribute, e.g. 'prefix-delete-link' and 'prefix-delete-btn' classes
   * @param 	string    $crud                   The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function delete($canUserEdit, $itemId, $humanViewNameSingular, $prefix = null, $crud = null)
	{
		if ($canUserEdit)
		{
      $anchorClass  = self::getAttributeClass('delete-link', $prefix, $crud);
      $baseBtnClass = self::getAttributeClass('btn', $prefix);
      $btnClass  = self::getAttributeClass('delete-btn', $prefix, $crud);

      $html  = '<a class=" ' . $anchorClass . '" onClick="removeSubmit(' . $itemId . ')">';
      $html .= '<button type="button" class="btn btn-danger btn-primary ' . $baseBtnClass . ' ' . $btnClass . ' pull-right">';
      $html .= Text::sprintf('COM_CAJOBBOARD_DELETE_BUTTON_LABEL', $humanViewNameSingular);
      $html .= '</button>';
      $html .= '</a>';
    }

    return $canUserEdit ? $html : '';
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
    $class  = self::getAttributeClass('header', $prefix, $crud);
    $viewTransKey = $isEditView ? 'EDIT' : 'ADD';

    $html  = '<h3 class="' . $class . '">';
    $html .= Text::sprintf('COM_CAJOBBOARD_' . $viewTransKey . '_HEADER', $humanViewNameSingular);
    $html .= '</h3>';

    return $html;
  }


  /**
	 * Method to create an HTML element tag for a hidden CSRF field to be embedded in a form
	 *
	 * @return  string
	 */
	public static function hiddenCsrfField()
	{
    $html  = '<div class="cajobboard-form-hidden-fields">';
    $html .= '<input type="hidden" name="' . Factory::getSession()->getFormToken() . '" value="1"/>';
    $html .= '</div>';

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
    $class  = self::getAttributeClass('modified-on', $prefix, $crud);

    $html  = '<span class="' . $class . '">';
    $html .= Text::_('COM_CAJOBBOARD_MODIFIED_ON_BUTTON_LABEL');
    $html .= $modifiedOn;
    $html .= '</span>';

    return $html;
  }


  /**
   * Method to create an HTML element tag for an item's 'title' model field,
	 * wrapped in an anchor tag to that item's item view.
	 *
   * @param 	string 		$prefix   A prefix to prepend to a class attribute, e.g. 'prefix-edit-link' and 'prefix-edit-btn' classes
   * @param 	string    $crud     The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function submit($prefix = null, $crud = null)
	{
    $class  = self::getAttributeClass('submit', $prefix, $crud);

    $html  = '<button class="btn btn-primary ' . $class . ' pull-right" type="submit">';
		$html .= Text::_('JAPPLY');
    $html .= '</button>';

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
    $class  = self::getAttributeClass('text', $prefix, $crud);

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
    $class  = self::getAttributeClass($title, $prefix, $crud);

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


  /**
	 * Method to create an HTML element tag for an item's Author relation's 'name' model field.
	 *
   * @param 	string                  $suffix   The element's suffix to use for a class attribute name, e.g. 'author-avatar' (same as field name)
   * @param 	string                  $prefix   A prefix to prepend to a class attribute, e.g. a 'prefix-created-on-date' class
   * @param 	string                  $crud     The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
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
