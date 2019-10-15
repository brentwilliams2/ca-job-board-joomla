<?php
/**
 * Custom Joomla! HTMLHelper class for admin browse view controls
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
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

use \Calligraphic\Cajobboard\Admin\Helper\Category;
use \Calligraphic\Cajobboard\Admin\Helper\Exception\RelationNotSetException;
use \FOF30\Utils\FEFHelper\BrowseView;
use \FOF30\Utils\SelectOptions;
use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Pagination\Pagination;

require_once JPATH_COMPONENT_ADMINISTRATOR . '/Helper/Html/commonwidgets.php';
require_once JPATH_LIBRARIES . '/fof30/Utils/FEFHelper/browse.php';

abstract class HelperBrowseWidgets
{
  /**
	 * Method to create an HTML table header column tag for sorting by the 'access' model field, e.g. "public".
	 *
	 * @param   int   $widthPct   The width of the table header column
	 *
	 * @return  string
	 */
	public static function accessHeader($widthPct)
	{
    $html  = '<th width="' . $widthPct . '%" class="center header-access">';
    $html .= BrowseView::sortgrid('access', 'JFIELD_ACCESS_LABEL');
    $html .= '</th>';

    return $html;
  }


  /**
	 * Method to create an HTML table element tag for the 'access' model field, e.g. "public".
	 *
	 * @param   int   $widthPct   The width of the element's table column
   * @param   \FOF30\Model\DataModel  $item The instance item model
	 *
	 * @return  string
	 */
	public static function accessField($widthPct, $item)
	{
    $html  = '<td width="' . $widthPct . '%" class="center row-access">';
    $html .= HelperCommonWidgets::access($item->access);
    $html .= '</td>';

    return $html;
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
	 * Method to create an HTML table header column tag for sorting by the hits model field.
	 *
	 * @param   int     $widthPct   The width of the table header column
   * @param   string  $viewName   The name of the view to build a translation key with, e.g. 'ANSWERS'
	 *
	 * @return  string
	 */
	public static function authorNameHeader($widthPct, $viewName = 'DEFAULT')
	{
    $translationKey = 'COM_CAJOBBOARD_' . $viewName . '_TITLE';

    $html  = '<th width="' . $widthPct . '%" class="center header-author-name">';
    $html .= BrowseView::sortgrid('created_by', $translationKey);
    $html .= '</th>';

    return $html;
  }


  /**
	 * Method to create an HTML table element tag for the Author model magic field (relation).
	 *
	 * @param   int   $widthPct   The width of the element's table column
   * @param   \FOF30\Model\DataModel  $item The instance item model
	 *
	 * @return  string
	 */
	public static function authorNameField($widthPct, $item)
	{
    if (!isset($item->Author) || !is_subclass_of($item->Author, '\FOF30\Model\DataModel') )
    {
      throw new RelationNotSetException();
    }

    $html  = '<td width="' . $widthPct . '%" class="row-author">';
    $html .= $item->Author->name;
    $html .= '</td>';

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
	 * Method to create an HTML table header column tag for sorting by the 'created_on' model field.
	 *
	 * @param   int   $widthPct   The width of the table header column
	 *
	 * @return  string
	 */
	public static function createdOnHeader($widthPct)
	{
    $html  = '<th width="' . $widthPct . '%" class="center header-created">';
    $html .= BrowseView::sortgrid('created_on', 'JGLOBAL_FIELD_CREATED_LABEL');
    $html .= '</th>';

    return $html;
  }


  /**
	 * Method to create an HTML table element tag for the 'created_on' model field.
	 *
	 * @param   int   $widthPct   The width of the element's table column
   * @param   \FOF30\Model\DataModel  $item The instance item model
	 *
	 * @return  string
	 */
	public static function createdOnField($widthPct, $item)
	{
    $html  = '<td width="' . $widthPct . '%" class="center row-created">';
    $html .= $item->getContainer()->Format->date($item->created_on);
    $html .= '</td>';

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
	 * Method to create an HTML table header column tag for sorting by the 'hits' model field.
	 *
	 * @param   int   $widthPct   The width of the table header column
	 *
	 * @return  string
	 */
	public static function hitsHeader($widthPct)
	{
    $html  = '<th width="' . $widthPct . '%" class="center header-hits">';
    $html .= BrowseView::sortgrid('hits', 'JGLOBAL_HITS');
    $html .= '</th>';

    return $html;
  }


  /**
	 * Method to create an HTML table element tag for the 'access' model field, e.g. "public".
	 *
	 * @param   int   $widthPct   The width of the element's table column
   * @param   \FOF30\Model\DataModel  $item The instance item model
	 *
	 * @return  string
	 */
	public static function hitsField($widthPct, $item)
	{
    $html  = '<td width="' . $widthPct . '%" class="center row-hits">';
    $html .= HelperCommonWidgets::hits($item->hits);
    $html .= '</td>';

    return $html;
  }


  /**
	 * Method to create an HTML table header column tag for sorting by the 'language' model field.
	 *
	 * @param   int   $widthPct   The width of the table header column
	 *
	 * @return  string
	 */
	public static function languageHeader($widthPct)
	{
    $html  = '<th width="' . $widthPct . '%" class="center header-language">';
    $html .= BrowseView::sortgrid('language', 'JFIELD_LANGUAGE_LABEL');
    $html .= '</th>';

    return $html;
  }


  /**
	 * Method to create an HTML table element tag for the 'language' model field.
	 *
	 * @param   int   $widthPct   The width of the element's table column
   * @param   \FOF30\Model\DataModel  $item The instance item model
	 *
	 * @return  string
	 */
	public static function languageField($widthPct, $item)
	{
    $html  = '<td width="' . $widthPct . '%" class="center row-language">';
    $html .= self::language($item->language);
    $html .= '</td>';

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
	 * Method to create an HTML table header column tag for the 'ordering' model field,
   * allows drag-and-drop reordering.
	 *
	 * @param   int   $widthPct   The width of the table header column
	 *
	 * @return  string
	 */
	public static function orderingHeader($widthPct)
	{
    $html  = '<th width="' . $widthPct . '%" class="nowrap center header-reorder hidden-phone">';
    $html .= FEFHelperBrowse::orderfield('ordering', 'icon-menu-2');
    $html .= '</th>';

    return $html;
  }


  /**
	 * Method to create an HTML table element tag for the 'access' model field, e.g. "public".
	 *
	 * @param   int   $widthPct   The width of the element's table column
   * @param   \FOF30\Model\DataModel  $item The instance item model
	 *
	 * @return  string
	 */
	public static function orderingField($widthPct, $item)
	{
    $html  = '<td width="' . $widthPct . '%" class="center row-reorder">';
    $html .= FEFHelperBrowse::order($item->ordering, 'sortable-handler tip-top hasTooltip', 'icon-menu', 'icon-menu');
    $html .= '</td>';

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
	 * Method to create an HTML table header column tag for sorting on whether records
   * are published, unpublished, or both by the 'published' model field.
	 *
	 * @param   int   $widthPct   The width of the table header column
	 *
	 * @return  string
	 */
	public static function publishedHeader($widthPct)
	{
    $html  = '<th width="' . $widthPct . '%" class="center header-published">';
    $html .= BrowseView::sortgrid('enabled', 'JSTATUS');
    $html .= '</th>';

    return $html;
  }


  /**
	 * Method to create an HTML table element tag for the 'access' model field, e.g. "public".
	 *
	 * @param   int                     $widthPct   The width of the element's table column
   * @param   \FOF30\Model\DataModel  $item       The instance item model
   * @param   int                     $i          Current iterator value
	 *
	 * @return  string
	 */
	public static function publishedField($widthPct, $item, $i)
	{
    $html  = '<td width="' . $widthPct . '%" class="center row-published">';
    $html .= '<div class="btn-group">';
    $html .= self::published($item->enabled, $i);
    $html .= self::featured($item->featured, $i);
    $html .= self::publishedDropdown($item->enabled, $item->name, $i);
    $html .= '</div>';
    $html .= '</td>';

    return $html;
  }


  /**
	 * Method to create a clickable icon to change the state of an item
	 *
	 * @param   mixed    $status  Publish status: -2 for trashed and marked for deletion, -1 for archived, 0 for unpublished, and 1 for published.
	 * @param   integer  $i       The index of this item in the browse view list
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
	 * Method to create an HTML table header column tag for a "select all" checkbox
   * to apply Toolbar actions to all records.
	 *
	 * @param   int   $widthPct   The width of the table header column
	 *
	 * @return  string
	 */
	public static function selectAllHeader($widthPct)
	{
    $html  = '<th width="' . $widthPct . '%" class="center header-select">';
    $html .= FEFHelperBrowse::checkall('Select');
    $html .= '</th>';

    return $html;
  }


  /**
	 * Method to create an HTML table element tag for the 'access' model field, e.g. "public".
	 *
	 * @param   int                     $widthPct   The width of the element's table column
   * @param   \FOF30\Model\DataModel  $item       The instance item model
   * @param   integer                 $i          The index of this item in the browse view list
	 *
	 * @return  string
	 */
	public static function selectAllField($widthPct, $item, $i)
	{
    $html  = '<td width="' . $widthPct . '%" class="center row-select">';
    $html .= FEFHelperBrowse::id($i, $item->getId());
    $html .= '</td>';

    return $html;
  }


  /**
	 * Method to create an HTML table header column tag for sorting by the 'name' (aliased to 'title') model field.
	 *
	 * @param   int     $widthPct   The width of the table header column
   * @param   string  $viewName   The name of the view to build a translation key with, e.g. 'ANSWER'
	 *
	 * @return  string
	 */
	public static function titleHeader($widthPct, $viewName = 'DEFAULT')
	{
    $translationKey = 'COM_CAJOBBOARD_' . strtoupper($viewName) . '_TITLE_LABEL';

    $html  = '<th width="' . $widthPct . '%" class="header-title">';
    $html .= BrowseView::sortgrid('name', $translationKey);
    $html .= '</th>';

    return $html;
  }


  /**
	 * Method to create an HTML table element tag for the 'access' model field, e.g. "public".
	 *
	 * @param   int   $widthPct   The width of the element's table column
   * @param   \FOF30\Model\DataModel  $item The instance item model
	 *
	 * @return  string
	 */
	public static function titleField($widthPct, $item)
	{
  
    $route = 'index.php?option=com_cajobboard&view=' . $item->getName() . '&task=edit&id=[ITEM:ID]';
    $parsedRoute = BrowseView::parseFieldTags($route, $item);
    $sefURL = $item->getContainer()->template->route($parsedRoute);

    $html  = '<td width="' . $widthPct . '%" class="row-title">';
    $html .= '<div>';
    $html .= '<a href="' . $sefURL . '">';
    $html .= self::title($item->name, $item->text);
    $html .= '</a>';
    $html .= self::alias($item->slug);
    $html .= '</div>';
    $html .= self::category($item->cat_id);
    $html .= '</td>';

    return $html;
  }


	/**
	 * Title (name) widget
   *
   * If the answer title is left empty, backfill it from the first seven words of the text
   * of the answer. Show an ellipse ("...") at the end if text is longer than seven words
   *
   * @param   string   $title     The raw title text to be formatted
   * @param   string   $text      The text field to backfill an empty title with
	 *
	 * @return  string
	 */
	public static function title($title, $text)
	{
    if (!$title)
    {
      $titleArray = explode(' ', $text);
      $title = Text::_('COM_CAJOBBOARD_TITLE_EMPTY') . ' ' . implode(' ', array_slice($titleArray, 0, 7));
    }

    (str_word_count($title) > 15) && $title = implode(' ', array_slice(explode(' ', $title), 0, 15)) . '...';

    // @TODO: wrap in <span></span>

    return $title;
  }
}
