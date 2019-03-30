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
 * These are based on the Akeeba FEF (front-end framework) helperrs included in FOF with revised HTML output
 */

// Can't namespace since this class is used through Joomla's autoloader and JHtml system

// no direct access
defined('_JEXEC') or die;

use \FOF30\Utils\SelectOptions;

use Calligraphic\Cajobboard\Admin\Helper\CategoryHelper;

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
	 *
	 * @since   0.1
	 */
	public static function alias($slug)
	{
    // @TODO: Implement
    // <span></span>

    return $alias;
  }


 	/**
	 * "Category" widget for browse view, shown under the item title
   *
   * Category name is link to edit that category page
   *
   * @param   string    $cat_id   The category id of this item
	 *
	 * @return  string    HTML string of the text for the item category
	 *
	 * @since   0.1
	 */
	public static function category($cat_id)
	{
    $html = '<div class="small">';
    $html .= JText::_('JCATEGORY');
    $html .= ': ';
    $html .= '<a ';
    $html .= 'class="hasTooltip" ';
    $html .= 'href="/administrator/index.php?option=com_categories&amp;task=category.edit&amp;id=' . $cat_id . '&amp;extension=com_cajobboard" ';
    $html .= 'title="" ';
    $html .= 'data-original-title="' . JText::_('JCATEGORY') . JText::_('JACTION_EDIT') . '"';
    $html .= '>';
    $html .= CategoryHelper::getCategoryTitleById($cat_id);
    $html .= '</a>';
    $html .= '</div>';

		return $html;
  }


	/**
	 * Featured button to add to Published widget
   *
   * @param   bool    $isFeatured   Whether the item is currently set to "featured" or not
   * @param   string  $modelName    The name of the current model
	 *
	 * @return  string
	 *
	 * @since   0.1
	 */
	public static function featured($isFeatured, $modelName, $i)
	{
    $task = $isFeatured ? 'featured' : 'unfeatured';
    $alt = JText::_('JGLOBAL_TOGGLE_FEATURED');
    $icon = $isFeatured ? 'icon-featured' : 'icon-unfeatured';
    $action = $isFeatured ? JText::_('JFEATURED') : JText::_('JUNFEATURED');

    $html = '<a href="javascript:void(0)"';
    // listItemTask( id, task ) in core-uncompressed.js, 'id' is the checkbox id name
    // for the item e.g. 'cb0', 'task' is given to window.submitform() handler
    $html .= 'onclick="return listItemTask(\'cb' . $i . '\', \'' . $modelName . '.featured\')"';
    $html .= 'class="btn btn-micro hasTooltip"';
    $html .= 'title="'. $alt . '"';
    $html .= 'data-original-title="'. $action . '"';
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
	 *
	 * @since   0.1
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
        $label = JText::_('COM_CAJOBBOARD_ALL');
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
   * @param   \JPagination  $paginationObject  The Joomla! pagination object
	 *
	 * @return  string
	 *
	 * @since   0.1
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
	 * @param   mixed    $isPublished   Either boolean or an object with a 'published' property (for b/c, deprecated)
   * @param   string   $modelName     The name of the current model
	 * @param   integer  $i             The index
	 *
	 * @return  string
	 *
	 * @since   1.0
	 */
	public static function published($isPublished, $modelName, $i)
	{
		if (is_object($isPublished))
		{
			$isPublished = $isPublished->published;
		}

    $task = $isPublished ? 'unpublish' : 'publish';
    $alt = $isPublished ? JText::_('JPUBLISHED') : JText::_('JUNPUBLISHED');
    $icon = $isPublished ? 'icon-publish' : 'icon-unpublish';
    $action = $isPublished ? JText::_('JLIB_HTML_UNPUBLISH_ITEM') : JText::_('JLIB_HTML_PUBLISH_ITEM');

    $html  = '<a';
    $html .= 'class="btn btn-micro hasTooltip"';
    $html .= 'href="javascript:void(0);"';
    $html .= 'onclick="return listItemTask(\'cb' . $i . '\', \'' . $modelName . '.publish\')"';
    $html .= 'title="'. $alt . '"';
    $html .= 'data-original-title="' . $action . '"';
    $html .= '>';
    $html .= '<span class="' . $icon . '" aria-hidden="true"></span>';
    $html .= '</a>';

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
	 *
	 * @since   0.1
	 */
	public static function title($title, $text)
	{
    if (!$title)
    {
      $titleArray = explode(' ', $text);
      $title = JText::_('COM_CAJOBBOARD_ANSWER_TITLE_EMPTY') . ' ' . implode(' ', array_slice($titleArray, 0, 7));
    }

    (str_word_count($title) > 15) && $title = implode(' ', array_slice(explode(' ', $title), 0, 15)) . '...';

    // @TODO: wrap in <span></span>

    return $title;
  }
}

