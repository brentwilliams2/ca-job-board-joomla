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

use \FOF30\View\View;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;

abstract class helperCommonwidgets
{
  /**
	 * Method to create an HTML element tag for a button to add a new item (link to 'add' view)
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

    $anchorClass  = self::getAttributeClass('add-new', $prefix, $crud);
    $baseBtnClass = self::getAttributeClass('btn', $prefix);
    $btnClass  = self::getAttributeClass('add-new-btn', $prefix, $crud);

    $html  = '<a class="' . $anchorClass . '" href="' . $url . '">';
    $html .= '<button type="button" class="btn btn-primary btn-sm ' . $baseBtnClass . ' ' . $btnClass . ' pull-right">';
    $html .= Text::_('JTOOLBAR_NEW');
    $html .= '</button>';
    $html .= '</a>';

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
	public static function authorAvatar($author, $prefix = null, $crud = null)
	{
    $class  = self::getAttributeClass('author-avatar', $prefix, $crud);

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
    $class  = self::getAttributeClass('author-last-seen', $prefix, $crud);

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
    $class  = self::getAttributeClass('author-name', $prefix, $crud);

    $html  = '<a class="' . $class . '" href="' . $author->profileLink . '">';
    $html .= $author->name;
    $html .= '</a>';

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
    $class  = self::getAttributeClass('created-on', $prefix, $crud);

		$html  = '<span class="' . $class . '">';
		$html .= Text::_('COM_CAJOBBOARD_CREATED_ON_BUTTON_LABEL') . ' ';
    $html .= $createdOn;
    $html .= '</span>';

    return $html;
  }


  /**
	 * Method to create an HTML element tag for an item's 'title' model field,
	 * wrapped in an anchor tag to that item's item view
	 *
   * @param   string    $humanViewNameSingular  A human-readable pluralized view name, e.g. 'Job Posting'
   * @param   boolean   $canUserEdit            Whether the user has canEdit ACL privileges
   * @param   int       $itemId                 The primary key value (id) for the item
   * @param 	string    $prefix                 A prefix to prepend to a class attribute, e.g. 'prefix-delete-link' and 'prefix-delete-btn' classes
   * @param 	string    $crud                   The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function delete($humanViewNameSingular, $canUserEdit, $itemId, $prefix = null, $crud = null)
	{
		if ($canUserEdit)
		{
      $anchorClass  = self::getAttributeClass('delete-link', $prefix, $crud);
      $baseBtnClass = self::getAttributeClass('btn', $prefix);
      $btnClass  = self::getAttributeClass('delete-btn', $prefix, $crud);

      $html  = '<a class=" ' . $anchorClass . '" onClick="removeSubmit(' . $itemId . ')">';
      $html .= '<button type="button" class="btn btn-danger btn-xs ' . $baseBtnClass . ' ' . $btnClass . ' pull-right">';
      $html .= Text::sprintf('COM_CAJOBBOARD_DELETE_BUTTON_LABEL', $humanViewNameSingular);
      $html .= '</button>';
      $html .= '</a>';
    }

    return $canUserEdit ? $html : '';
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
    $class  = self::getAttributeClass('description', $prefix, $crud);

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
    $class  = self::getAttributeClass('description-intro', $prefix, $crud);

		$html  = '<p class="' . $class . '">';
		$html .= $descriptionIntro;
    $html .= '</p>';

    return $html;
  }


  /**
	 * Method to create an HTML element tag for an item's 'downvote_count' model field.
	 *
   * @param   int       $downvoteCount 	  The number of downvotes for the model item.
   * @param   int       $downvoteLink 	  A link to increment the downvotes for this item.
   * @param 	string    $prefix           A prefix to prepend to a class attribute, e.g. a 'prefix-downvotes-btn' class
   * @param 	string    $crud             The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function downvotes($downvoteCount, $downvoteLink, $prefix = null, $crud = null)
	{
    $baseBtnClass = self::getAttributeClass('btn', $prefix);
    $class  = self::getAttributeClass('downvote-count', $prefix, $crud);

    $html  = '<a href="' . $downvoteLink . '">';
		$html .= '<button class="btn btn-primary btn-xs ' . $baseBtnClass . ' '  . $class . ' pull-right" type="button">';
		$html .= Text::_('COM_CAJOBBOARD_DOWNVOTES_BUTTON_LABEL');
		$html .= '<span class="badge">';
		$html .= $downvoteCount;
    $html .= '</span>';
    $html .= '</button>';
		$html .= '</a>';

    return $html;
	}


  /**
	 * Method to create an HTML element tag for an item's 'title' model field,
	 * wrapped in an anchor tag to that item's item view
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
      $anchorClass  = self::getAttributeClass('edit-link', $prefix, $crud);
      $baseBtnClass = self::getAttributeClass('btn', $prefix);
      $btnClass  = self::getAttributeClass('edit-btn', $prefix, $crud);

      $html  = '<a class="edit-link ' . $anchorClass . '" href="' . $editViewLink . '">';
      $html .= '<button type="button" class="btn btn-warning btn-xs ' . $baseBtnClass . ' '  . $btnClass . ' pull-right">';
      $html .= Text::_('COM_CAJOBBOARD_EDIT_BUTTON_LABEL');
      $html .= '</button>';
      $html .= '</a>';
    }

    return $canUserEdit ? $html : '';
  }


  /**
	 * Method to create an HTML element tag for the remove action's CSRF field
	 *
   * @param  string                   $removeAction   A URL to delete and redirect from this item
   * @param  int                      $itemId         The primary key value (id) for the item
	 *
	 * @return  string
	 */
	public static function removeActionCsrfField($removeAction, $itemId)
	{
    $html  = '<form action="' . $removeAction . '" method="post" name="removeForm" id="removeForm-' . $itemId . '">';
    $html .= '<input type="hidden" name="' . Factory::getSession()->getFormToken() . '" value="1"/>';
    $html .= '</form>';

    return $html;
  }


  /**
	 * Method to create an HTML element tag to report an item for abuse
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
    $baseBtnClass = self::getAttributeClass('btn', $prefix);
    $class  = self::getAttributeClass('report-btn', $prefix, $crud);

    $html  = '<button ';
    $html .= 'type="button" ';
    $html .= 'class="btn btn-primary btn-xs ' . $baseBtnClass . ' '  . $class . ' pull-right" ';
    $html .= 'data-toggle="modal" ';
    $html .= 'data-target="#report-answer"';
    $html .= '>';
    $html .= Text::sprintf('COM_CAJOBBOARD_REPORT_BUTTON_LABEL', $humanViewNameSingular);
    $html .= '</button>';

    return $html;
  }


	/**
	 * Method to create an HTML element tag for an item's 'text' model field.
	 *
   * @param   string    $text     The text of the item, already sanitized.
   * @param 	string 		$prefix   A prefix to prepend to a class attribute, e.g. 'prefix-edit-link' and 'prefix-edit-btn' classes
   * @param 	string    $crud     The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function text($text, $prefix = null, $crud = null)
	{
    $class  = self::getAttributeClass('text', $prefix, $crud);

		$html  = '<p class="' . $class . '">';
		$html .= $text;
    $html .= '</p>';

    return $html;
  }


  /**
	 * Method to create an HTML element tag for an item's 'title' model field,
	 * wrapped in an anchor tag to that item's item view.
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
    $class  = self::getAttributeClass('title', $prefix, $crud);

    $html  = '<h4>';
		$html .= '<a class="' . $class . '" href="' . $itemViewLink . '">';
		$html .= $title;
    $html .= '</a>';
    $html .= '</h4>';

    return $html;
  }


  /**
	 * Method to create an HTML element tag for an item's 'upvote_count' model field.
	 *
   * @param   int       $upvoteCount 	  The number of upvotes for this item.
   * @param   int       $upvoteLink 	  A link to increment the upvotes for this item.
   * @param 	string 		$prefix         A prefix to prepend to a class attribute, e.g. 'prefix-edit-link' and 'prefix-edit-btn' classes
   * @param 	string    $crud           The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function upvotes($upvoteCount, $upvoteLink, $prefix = null, $crud = null)
	{
    $baseBtnClass = self::getAttributeClass('btn', $prefix);
    $class  = self::getAttributeClass('upvote-count', $prefix, $crud);

    $html  = '<a href="' . $upvoteLink . '">';
		$html .= '<button class="btn btn-primary btn-xs ' . $baseBtnClass . ' '  . $class . ' pull-right" type="button">';
		$html .= Text::_('COM_CAJOBBOARD_UPVOTES_BUTTON_LABEL');
		$html .= '<span class="badge">';
		$html .= $upvoteCount;
		$html .= '</span>';
    $html .= '</button>';
    $html .= '</a>';

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