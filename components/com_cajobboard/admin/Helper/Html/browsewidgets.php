<?php
/**
 * Custom Joomla! HTMLHelper class for admin browse view controls
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Usage in Blade templates:
 *     @jhtml('helper.browseWidgets.methodName', parameter1, ...)
 *
 * These are based on the Akeeba FEF (front-end framework) helpers included in FOF with revised HTML output
 */

// Can't namespace since this class is used through Joomla's autoloader and JHtml system

// no direct access
defined('_JEXEC') or die;

use \FOF30\Utils\SelectOptions;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Pagination\Pagination;

use Calligraphic\Cajobboard\Admin\Helper\Category;

abstract class HelperBrowseWidgets
{
  	/**
	 * Slug (alias) widget
   *
   * Show an ellipse ("...") at the end if text is longer than seven words
   *
   * @param   string   $slug   The SEF slug (alias) for the record
	 *
	 * @return  string
	 */
	public static function alias($slug)
	{
    $html  = '<span class="admin-browse-alias">';
    $html .= '(';
    $html .= Text::_('JFIELD_ALIAS_LABEL');
    $html .= ': ';
    $html .= $slug;
    $html .= ')';
    $html .= '</span>';

    return $html;
  }


 	/**
	 * "Category" widget for browse view, shown under the item title
   *
   * Category name is link to edit that category page
   *
   * @param   string    $cat_id   The category id of this item
	 *
	 * @return  string    HTML string of the text for the item category
	 */
	public static function category($cat_id)
	{
    $html  = '<div class="small">';
    $html .= Text::_('JCATEGORY');
    $html .= ': ';
    $html .= '<a ';
    $html .= 'class="hasTooltip" ';
    $html .= 'href="/administrator/index.php?option=com_categories&amp;task=category.edit&amp;id=' . $cat_id . '&amp;extension=com_cajobboard" ';
    $html .= 'title="" ';
    $html .= 'data-original-title="' . Text::_('JCATEGORY') . Text::_('JACTION_EDIT') . '"';
    $html .= '>';
    $html .= Category::getCategoryTitleById($cat_id);
    $html .= '</a>';
    $html .= '</div>';

		return $html;
  }


	/**
	 * Featured button to add to Published widget
   *
   * @param   bool    $isFeatured   Whether the item is currently set to "featured" or not
   * @param   int     $i            The index of this item in the browse view list
	 *
	 * @return  string
	 */
	public static function featured($isFeatured, $i)
	{
    // $task is FSM showing subsequent task, not current task
    $task = $isFeatured ? 'unfeature' : 'feature';

    $alt = Text::_('JGLOBAL_TOGGLE_FEATURED');
    $icon = $isFeatured ? 'icon-featured' : 'icon-unfeatured';

    $html = '<a href="javascript:void(0)"';
    // listItemTask( id, task ) in core-uncompressed.js, 'id' is the checkbox id name
    // for the item e.g. 'cb0', 'task' is given to window.submitform() handler
    $html .= 'onclick="return listItemTask(\'cb' . $i . '\', \'' . $task . '\')"';
    $html .= 'class="btn btn-micro hasTooltip"';
    $html .= 'title="'. $alt . '"';
    $html .= '>';
    $html .= '<span class="' . $icon . '" aria-hidden="true"></span>';
    $html .= '</a>';

		return $html;
  }


  /**
	 * "Language" widget for browse view
   *
   * @param   string  $language  The language string, e.g. 'en-GB' or '*' for all languages
	 *
	 * @return  string
	 */
	public static function language($language)
	{
    $languageOptions = SelectOptions::getOptions('languages');

    foreach ($languageOptions as $languageOption)
    {
      // FOF getOptions() method returns both objects and arrays
      if (is_array($languageOption))
      {
        $languageOption = (object) $languageOption;
      }

      // 'value' property is the short form of language name, e.g. en-GB
      if ($languageOption->value === '*' && $language === '*')
      {
        $label = Text::_('COM_CAJOBBOARD_ALL');
      }
      elseif ($languageOption->value === $language)
      {
        // this is long form of language name, e.g. 'Español (España)'
        $label = $languageOption->text;
      }
    }
    $html = '<label for="languages">' . $label . '</label>';

		return $html;
  }


  /**
	 * "Pagination" widget for browse view footer
   *
   * @param   Pagination  $paginationObject  The Joomla! pagination object
	 *
	 * @return  string
	 */
	public static function pagination($paginationObject)
	{
    if ($paginationObject)
    {
      return $paginationObject->getListFooter();
    }

		return null;
  }


  /**
	 * Method to create a clickable icon to change the state of an item
	 *
	 * @param   mixed    $status        Publish status: -2 for trashed and marked for deletion, -1 for archived, 0 for unpublished, and 1 for published.
	 * @param   integer  $i             The index of this item in the browse view list
	 *
	 * @return  string
	 */
	public static function published($status, $i)
	{
    switch ($status) {
      // $task is FSM showing subsequent task, not current task
      case 1: // published
          $task = 'unpublish';
          $alt = Text::_('JPUBLISHED');
          $icon = 'icon-publish';
          break;

      case 0: // unpublished
          $task = 'publish';
          $alt = Text::_('JUNPUBLISHED');
          $icon = 'icon-unpublish';
          break;

      case -1: // archived
          $task = 'archive';
          $alt = Text::_('JTOOLBAR_ARCHIVE');
          $icon = 'icon-archive';
          break;

      case -2: // trashed
          $task = 'trash';
          $alt = Text::_('JTRASH');
          $icon = 'icon-trash';
          break;
      default:
        throw new \InvalidArgumentException('In browserwidgets::published, the value of the enabled field for a record in ' . $modelName . ' is not valid');
    }

    $html  = '<a ';
    $html .= 'class="btn btn-micro hasTooltip"';
    $html .= 'href="javascript:void(0);"';
    $html .= 'onclick="return listItemTask(\'cb' . $i . '\', \'' . $task . '\')"';
    $html .= 'title="'. $alt . '"';
    $html .= '>';
    $html .= '<span class="' . $icon . '" aria-hidden="true"></span>';
    $html .= '</a>';

		return $html;
  }


  /**
	 * Method to create a clickable icon to change the state of an item
	 *
	 * @param   mixed    $status        Publish status: -2 for trashed and marked for deletion, -1 for archived, 0 for unpublished, and 1 for published.
	 * @param   integer  $i             The index of this item in the browse view list
	 *
	 * @return  string
	 */
	public static function publishedDropdown($status, $name, $i)
	{
    $status = (int) $status;

    if ($status != 1)
    {
      $html  = HTMLHelper::_('actionsdropdown.publish', 'cb' . $i, '');
    }

    if ($status)
    {
      $html  = HTMLHelper::_('actionsdropdown.unpublish', 'cb' . $i, '');
    }

    if ($status != -1)
    {
      $html .= HTMLHelper::_('actionsdropdown.archive', 'cb' . $i, '');
    }

    if ($status != -2)
    {
      $html .= HTMLHelper::_('actionsdropdown.trash',   'cb' . $i, '');
    }

    $html .= HTMLHelper::_('actionsdropdown.render', $name);

		return $html;
  }


	/**
	 * Title (name) widget
   *
   * If the answer title is left empty, backfill it from the first seven words of the text
   * of the answer. Show an ellipse ("...") at the end if text is longer than seven words
   *
   * @param   string   $title   The raw title text to be formatted
   * @param   string   $text    The text field to backfill an empty title with
	 *
	 * @return  string
	 */
	public static function title($title, $text)
	{
    if (!$title)
    {
      $titleArray = explode(' ', $text);
      $title = Text::_('COM_CAJOBBOARD_ANSWER_TITLE_EMPTY') . ' ' . implode(' ', array_slice($titleArray, 0, 7));
    }

    (str_word_count($title) > 15) && $title = implode(' ', array_slice(explode(' ', $title), 0, 15)) . '...';

    // @TODO: wrap in <span></span>

    return $title;
  }


	/**
	 * Activated button for the Persons admin page
   *
   * @param   bool    $isActivated  Whether the user is currently activated
   * @param   int     $i            The index of this item in the browse view list
	 *
	 * @return  string
	 */
   public static function activated($isActivated, $i)
   {
     // $task is FSM showing subsequent task, not current task
     $task = $isActivated ? 'unactivate' : 'activate';
 
     $alt = Text::_('COM_CAJOBBOARD_TOGGLE_USER_ACTIVATED');
     $icon = $isActivated ? 'checkmark-2' : 'not-ok';
 
     $html = '<a href="javascript:void(0)"';
     // listItemTask( id, task ) in core-uncompressed.js, 'id' is the checkbox id name
     // for the item e.g. 'cb0', 'task' is given to window.submitform() handler
     $html .= 'onclick="return listItemTask(\'cb' . $i . '\', \'' . $task . '\')"';
     $html .= 'class="btn btn-micro hasTooltip"';
     $html .= 'title="'. $alt . '"';
     $html .= '>';
     $html .= '<span class="' . $icon . '" aria-hidden="true"></span>';
     $html .= '</a>';
 
     return $html;
   }


	/**
	 * Blocked button for the Persons admin page
   *
   * @param   bool    $isBlocked    Whether the user is currently blocked
   * @param   int     $i            The index of this item in the browse view list
	 *
	 * @return  string
	 */
   public static function blocked($isBlocked, $i)
   {
     // $task is FSM showing subsequent task, not current task
     $task = $isBlocked ? 'unblock' : 'block';
 
     $alt = Text::_('COM_CAJOBBOARD_TOGGLE_USER_BLOCKED');
     $icon = $isBlocked ? 'checkmark-2' : 'not-ok';
 
     $html = '<a href="javascript:void(0)"';
     // listItemTask( id, task ) in core-uncompressed.js, 'id' is the checkbox id name
     // for the item e.g. 'cb0', 'task' is given to window.submitform() handler
     $html .= 'onclick="return listItemTask(\'cb' . $i . '\', \'' . $task . '\')"';
     $html .= 'class="btn btn-micro hasTooltip"';
     $html .= 'title="'. $alt . '"';
     $html .= '>';
     $html .= '<span class="' . $icon . '" aria-hidden="true"></span>';
     $html .= '</a>';
 
     return $html;
   }
}

