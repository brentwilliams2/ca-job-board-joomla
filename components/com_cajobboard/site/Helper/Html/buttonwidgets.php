<?php
/**
 * Custom Joomla! HTMLHelper class for site view HTML widgets that
 * produce buttons and associated CSRF hidden input fields
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

abstract class helperButtonwidgets
{
  /**
	 * Method to create an HTML button element tag to link to the 'add' form view (add a new item).
	 *
   * @param 	View 	      $view	      The View object.
   * @param 	string      $prefix     A prefix to prepend to a class attribute, e.g. a 'prefix-created-on-date' class
   * @param 	string      $crud       The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function addNew(View $view, $prefix = null, $crud = null)
	{
    $url = $view->getContainer()->template->route('index.php?option=com_cajobboard&view=' . $view->getName() . '&task=add');

    $anchorClass  = Utility::getAttributeClass('add-new', $prefix, $crud);
    $baseBtnClass = Utility::getAttributeClass('btn', $prefix);
    $btnClass  = Utility::getAttributeClass('add-new-btn', $prefix, $crud);

    $html  = '<a class="' . $anchorClass . '" href="' . $url . '">';
    $html .= '<button type="button" class="btn btn-primary btn-sm ' . $baseBtnClass . ' ' . $btnClass . ' pull-right">';
    $html .= Text::_('JTOOLBAR_NEW');
    $html .= '</button>';
    $html .= '</a>';

    return $html;
  }


  /**
	 * Method to create an HTML element tag for a cancel button to use inside edit forms,
   * redirecting to the item view. Does not depend on the <form> control that contains it.
	 *
   * @param   boolean   $itemViewLink   A link to the item view of this item.
   * @param 	string    $prefix         A prefix to prepend to a class attribute, e.g. 'prefix-delete-link' and 'prefix-delete-btn' classes
   * @param 	string    $crud           The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function cancel($itemViewLink, $prefix = null, $crud = null)
	{
    $anchorClass  = Utility::getAttributeClass('cancel-link', $prefix, $crud);
    $baseBtnClass = Utility::getAttributeClass('btn', $prefix);
    $btnClass  = Utility::getAttributeClass('cancel-btn', $prefix, $crud);

    $html  = '<a class=" ' . $anchorClass . '" href="' . $itemViewLink . '">';
    $html .= '<button type="button" class="btn btn-danger btn-primary ' . $baseBtnClass . ' ' . $btnClass . ' pull-right">';
    $html .= Text::_('JCANCEL');
    $html .= '</button>';
    $html .= '</a>';

    return $html;
  }


  /**
	 * Method to create an HTML button element tag to delete an item. Can be used inside or
   * outside of a <form> control.  Depends on deleteSubmit() method in frontend.js file, 
   * and deleteActionCsrfField() in this file being place at bottom of view template.
	 *
   * @param   string    $humanViewNameSingular  A human-readable pluralized view name, e.g. 'Job Posting'
   * @param   boolean   $canUserEdit            Whether the user has canEdit ACL privileges
   * @param   int       $itemId                 The primary key value (id) for the item
   * @param 	string    $prefix                 A prefix to prepend to a class attribute, e.g. 'prefix-delete-link' and 'prefix-delete-btn' classes
   * @param 	string    $crud                   The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
   * @param   boolean   $small                  Whether the button should have a 'btn-xs' or 'btn-primary' class, so this can be used both in browse and form views
	 *
	 * @return  string
	 */
	public static function delete($humanViewNameSingular, $canUserEdit, $itemId, $prefix = null, $crud = null, $small = true)
	{
		if ($canUserEdit)
		{
      $anchorClass  = Utility::getAttributeClass('delete-link', $prefix, $crud);
      $baseBtnClass = Utility::getAttributeClass('btn', $prefix);
      $btnClass  = Utility::getAttributeClass('delete-btn', $prefix, $crud);

      if ($small)
      {
        $size = 'btn-xs';
        $text = Text::sprintf('COM_CAJOBBOARD_DELETE_BUTTON_LABEL', $humanViewNameSingular);
      }
      else
      {
        $size = 'btn-primary';
        $text = Text::_('COM_CAJOBBOARD_DELETE_BUTTON_LABEL_DEFAULT');
      }

      $html  = '<a class=" ' . $anchorClass . '" onClick="deleteSubmit(' . $itemId . ')">';
      $html .= '<button type="button" class="btn btn-danger ' . $size . ' ' . $baseBtnClass . ' ' . $btnClass . ' pull-right">';
      $html .= $text;
      $html .= '</button>';
      $html .= '</a>';
    }

    return $canUserEdit ? $html : '';
  }


  /**
	 * Method to create an HTML element tag for the delete action's CSRF field. Place at bottom of
   * page when a 'delete' button element is used. Depends on deleteSubmit() method in frontend.js file.
	 *
   * @param  string                   $deleteAction   A URL to delete and redirect from this item
   * @param  int                      $itemId         The primary key value (id) for the item
	 *
	 * @return  string
	 */
	public static function deleteActionCsrfField($deleteAction, $itemId)
	{
    $html  = '<form action="' . $deleteAction . '" method="post" name="deleteForm" id="deleteForm-' . $itemId . '">';
    $html .= '<input type="hidden" name="' . Factory::getSession()->getFormToken() . '" value="1"/>';
    $html .= '</form>';

    return $html;
  }


  /**
	 * Method to create an HTML button element tag for an item's 'downvote_count' model field.
	 *
   * @param   int       $downvoteCount 	  The number of downvotes for the model item.
   * @param   boolean   $isGuestUser      Whether the user is logged in
   * @param   int       $itemId           The primary key value (id) for the item
   * @param 	string    $prefix           A prefix to prepend to a class attribute, e.g. a 'prefix-downvotes-btn' class
   * @param 	string    $crud             The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function downvote_count($downvoteCount, $isGuestUser, $itemId, $prefix = null, $crud = null)
	{
    $anchorClass  = Utility::getAttributeClass('downvote-count', $prefix, $crud);
    $baseBtnClass = Utility::getAttributeClass('btn', $prefix);
    $btnClass  = Utility::getAttributeClass('downvote-count-btn', $prefix, $crud);

    $html  = '';

    if (!$isGuestUser)
		{
      $html .= '<a class=" ' . $anchorClass . '" onClick="downvoteAction(' . $itemId . ')">';
    }

		$html .= '<button class="btn btn-primary btn-xs ' . $baseBtnClass . ' '  . $btnClass . ' pull-right" type="button">';
		$html .= Text::_('COM_CAJOBBOARD_DOWNVOTES_BUTTON_LABEL');
		$html .= '<span class="badge">';
		$html .= $downvoteCount;
    $html .= '</span>';
    $html .= '</button>';

    if (!$isGuestUser)
		{
		  $html .= '</a>';
    }

    return $html;
  }


  /**
	 * Method to create an HTML element tag for the downvote action's CSRF field. Place at bottom of page when
   * a 'downvote_count' button element is used. Depends on downvoteAction() method in frontend.js file.
	 *
   * @param  string                   $downvoteAction   A URL to downvote this item
   * @param  int                      $itemId           The primary key value (id) for the item
	 *
	 * @return  string
	 */
	public static function downvoteActionCsrfField($downvoteAction, $itemId)
	{
    $html  = '<form action="' . $downvoteAction . '" method="post" name="downvoteForm" id="downvoteForm-' . $itemId . '">';
    $html .= '<input type="hidden" name="' . Factory::getSession()->getFormToken() . '" value="1"/>';
    $html .= '</form>';

    return $html;
  }


  /**
	 * Method to create an HTML button element tag with a link to the item's
   *  form view for 'edit' tasks. Intended for use outside of form controls.
	 *
   * @param   boolean   $canUserEdit    Whether the user has canEdit ACL privileges
   * @param   string    $editViewLink   A URL to the edit view of this item
   * @param 	string 		$prefix         A prefix to prepend to a class attribute, e.g. 'prefix-edit-link' and 'prefix-edit-btn' classes
   * @param 	string    $crud           The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function edit($humanViewNameSingular, $canUserEdit, $editViewLink, $prefix = null, $crud = null)
	{
		if ($canUserEdit)
		{
      $anchorClass  = Utility::getAttributeClass('edit-link', $prefix, $crud);
      $baseBtnClass = Utility::getAttributeClass('btn', $prefix);
      $btnClass  = Utility::getAttributeClass('edit-btn', $prefix, $crud);

      $html  = '<a class="edit-link ' . $anchorClass . '" href="' . $editViewLink . '">';
      $html .= '<button type="button" class="btn btn-warning btn-xs ' . $baseBtnClass . ' '  . $btnClass . ' pull-right">';
      $html .= Text::_('COM_CAJOBBOARD_EDIT_BUTTON_LABEL');
      $html .= '</button>';
      $html .= '</a>';
    }

    return $canUserEdit ? $html : '';
  }


  /**
	 * Method to create an HTML button element tag to report an item for abuse using the
   * ViewTemplates/Common/Modal/report_item_modal.blade.php template. Intended for use
   * outside of form controls.
	 *
   * @param   string    $humanViewNameSingular  A human-readable pluralized view name, e.g. 'Job Posting'
   * @param 	string 		$prefix                 A prefix to prepend to a class attribute, e.g. 'prefix-edit-link' and 'prefix-edit-btn' classes
   * @param 	string    $crud                   The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function report($humanViewNameSingular, $prefix, $crud = null)
	{
    $sprintfParam = $prefix ? ' ' . ucfirst($prefix) : '';
    $baseBtnClass = Utility::getAttributeClass('btn', $prefix);
    $class  = Utility::getAttributeClass('report-btn', $prefix, $crud);

    $html  = '<button ';
    $html .= 'type="button" ';
    $html .= 'class="btn btn-primary btn-xs ' . $baseBtnClass . ' '  . $class . ' pull-right" ';
    $html .= 'data-toggle="modal" ';
    $html .= 'data-target="#report-item-modal"';
    $html .= '>';
    $html .= Text::sprintf('COM_CAJOBBOARD_REPORT_BUTTON_LABEL', $humanViewNameSingular);
    $html .= '</button>';

    return $html;
  }


  /**
   * Method to create a generic 'submit' button HTML element tag for use inside forms.
	 *
   * @param 	string 		$prefix   A prefix to prepend to a class attribute, e.g. 'prefix-edit-link' and 'prefix-edit-btn' classes
   * @param 	string    $crud     The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function submit($prefix = null, $crud = null)
	{
    $btnClass  = Utility::getAttributeClass('submit', $prefix, $crud);
    $baseBtnClass = Utility::getAttributeClass('btn', $prefix);

    $html  = '<button class="btn btn-primary ' . $baseBtnClass . ' ' . $btnClass . ' pull-right" type="submit">';
		$html .= Text::_('JAPPLY');
    $html .= '</button>';

    return $html;
  }


  /**
	 * Method to create an HTML element tag for a hidden CSRF field. This should be included at the end of all forms.
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
	 * Method to create an HTML element tag for an item's 'upvote_count' model field.
	 *
   * @param   int       $upvoteCount 	  The number of upvotes for this item.
   * @param   boolean   $isGuestUser    Whether the user is logged in
   * @param   int       $itemId         The primary key value (id) for the item
   * @param 	string 		$prefix         A prefix to prepend to a class attribute, e.g. 'prefix-edit-link' and 'prefix-edit-btn' classes
   * @param 	string    $crud           The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function upvote_count($upvoteCount, $isGuestUser, $itemId, $prefix = null, $crud = null)
	{
    $anchorClass  = Utility::getAttributeClass('upvote-count', $prefix, $crud);
    $baseBtnClass = Utility::getAttributeClass('btn', $prefix);
    $btnClass  = Utility::getAttributeClass('upvote-count-btn', $prefix, $crud);

    $html = '';

    if (!$isGuestUser)
		{
      $html .= '<a class=" ' . $anchorClass . '" onClick="downvoteAction(' . $itemId . ')">';
    }

		$html .= '<button class="btn btn-primary btn-xs ' . $baseBtnClass . ' '  . $btnClass . ' pull-right" type="button">';
		$html .= Text::_('COM_CAJOBBOARD_UPVOTES_BUTTON_LABEL');
		$html .= '<span class="badge">';
		$html .= $upvoteCount;
		$html .= '</span>';
    $html .= '</button>';

    if (!$isGuestUser)
		{
      $html .= '</a>';
    }

    return $html;
  }


  /**
	 * Method to create an HTML element tag for the upvote action's CSRF field. Place at bottom of page when
   * a 'upvote_count' button element is used. Depends on upvoteAction() method in frontend.js file.
	 *
   * @param  string                   $deleteAction   A URL to delete and redirect from this item
   * @param  int                      $itemId         The primary key value (id) for the item
	 *
	 * @return  string
	 */
	public static function upvoteActionCsrfField($upvoteAction, $itemId)
	{
    $html  = '<form action="' . $upvoteAction . '" method="post" name="upvoteForm" id="upvoteForm-' . $itemId . '">';
    $html .= '<input type="hidden" name="' . Factory::getSession()->getFormToken() . '" value="1"/>';
    $html .= '</form>';

    return $html;
  }
}