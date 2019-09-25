<?php
/**
 * Helper class for managing categories in the Job Board
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design, Copyright (C) 2005 - 2019 Open Source Matters, Inc.
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Helper;

// no direct access
defined('_JEXEC') or die;

use \Joomla\CMS\Factory;
use Joomla\Utilities\ArrayHelper;
use TheSeer\Tokenizer\Exception;

abstract class Category
{
  /**
   * Cached array of the category item objects.
   *
   * @var    array
   * @since  0.0.1
   */
  protected static $categories = array();


  /**
   * Cached array mapping category id's to names
   *
   * @var    array
   * @since  0.0.1
   */
  protected static $categoryMapIdToName = array();


  /**
   * Returns a category title, formatted with dashes to show level in category hierarchy
   *
   * @param   Object   $category  A POPO object with the properties 'id', 'title', 'level', and 'language' for the category
   *
   * @return  string              The category title indented with hyphens if it is lower level than root categories
   *
   * @since   0.0.1
   */
  public static function getIndentedCategoryTitle($category)
  {
    $repeat = ($category->level - 1 >= 0) ? $category->level - 1 : 0;

    $title = str_repeat('- ', $repeat) . ucfirst($category->title);

    if ($category->language !== '*')
    {
      $title .= ' (' . $category->language . ')';
    }

    return $title;
  }


  /**
   * Returns a category's 'title' field value by primary key (id)
   *
   * @param   int   $categoryId   The primary key (id) of the category
   *
   * @return  string   The category title indented with hyphens if it is lower level than root categories
   */
  public static function getCategoryTitleById($categoryId)
  {
    if (empty(self::$categoryMapIdToName))
    {
      // array, each element is an object: $category->id, $category->title, $category->language, $category->level
      $categories = self::getCategories();

      foreach ($categories as $category)
      {
        self::$categoryMapIdToName[$category->id] = $category->title;
      }
    }

    return self::$categoryMapIdToName[$categoryId];
  }


  /**
   * Returns a category's primary key (id) field value by 'title' field value
   *
   * @param   string   $categoryTitle   The category title indented with hyphens if it is lower level than root categories
   *
   * @return  int   The primary key (id) of the category
   */
  public static function getCategoryIdByTitle($categoryTitle)
  {
    // array, each element is an object: $category->id, $category->title, $category->language, $category->level
    $categories = self::getCategories();

    $id = null;

    foreach($categories as $category)
    {
      if ($categoryTitle == $category->title)
      {
        $id = $category->id;
        break;
      }
    }

    return $id;
  }


  /**
   * Sets the 'selected' flag to the default category for a view job board category
   * if this is a new item, or returns the category id of the selected category
   *
   * @param   Object   $categories  An array of category POPO objects with the properties 'id', 'title', 'level', and 'language' for each category
   * @param   string   $cat_id      The category id of this item
   * @param   string   $view        The name of the view, for setting a category on new records. Should be plural e.g. 'Answers'
   *
   * @return  int      The category id that should have the 'selected' flag added to its HTML: <option value="" selected>
   *
   * @since   0.0.1
   */
  public static function selectedHelper(&$categories, $cat_id, $view='uncategorised')
  {
    foreach ($categories as $category)
    {
      if ($category->id == $cat_id)
      {
        return $category->id;
      }

      if (strtolower($category->title) == strtolower($view))
      {
        $uncategorisedId = $category->id;
      }
    }

    if(!$uncategorisedId)
    {
      throw new Exception("The default Calligraphic Job Board category \(\"$view\"\) is missing from Joomla's #__categories table. It should have been added on installation of this component.");
    }

    return $uncategorisedId;
  }


  /**
   * Returns an array of categories for the given extension.
   *
   * @param   Array   $config     An array of configuration options. Options:
   *                              filter.published => array(0, 1) // default is to return unpublished and published categories
   *                              -2 for trashed and marked for deletion, -1 for archived, 0 for unpublished, and 1 for published.
   *                              filter.language => '*', filter.language => array('*')
   *                              filter.access => 1, for filtering based on "Public" view level permission
   *
   * @return  array               $category->id, $category->title, $category->language, $category->level
   *
   * @since   0.0.1
   */
  public static function getCategories($config = array('filter.published' => array(0, 1)))
  {
    $hash = md5(serialize($config));

    if (!isset(static::$categories[$hash]))
    {
      $config = (array) $config;

      $db     = Factory::getDbo();
      $user   = Factory::getUser();

      $groups = implode(',', $user->getAuthorisedViewLevels());

      $query = $db->getQuery(true)
        ->select  ('categories.id, categories.title, categories.level, categories.language')
        ->from    ('#__categories AS categories')
        ->where   ('categories.parent_id > 0');

      // Filter on the extension.
      $query->where('extension = ' . $db->quote('com_cajobboard'));

      // Filter on user access level
      $query->where('categories.access IN (' . $groups . ')');

      // Filter on the published state
      if (isset($config['filter.published']) && is_array($config['filter.published']))
      {
        $config['filter.published'] = ArrayHelper::toInteger($config['filter.published']);

        $query->where('categories.published IN (' . implode(',', $config['filter.published']) . ')');
      }

      // Filter on the language if set in config
      if (isset($config['filter.language']))
      {
        if (is_string($config['filter.language']))
        {
          $query->where('categories.language = ' . $db->quote($config['filter.language']));
        }
        elseif (is_array($config['filter.language']))
        {
          foreach ($config['filter.language'] as &$language)
          {
            $language = $db->quote($language);
          }
          $query->where('categories.language IN (' . implode(',', $config['filter.language']) . ')');
        }
      }

      // Filter on the access if set in config
      if (isset($config['filter.access']))
      {
        if (is_string($config['filter.access']))
        {
          $query->where('categories.access = ' . $db->quote($config['filter.access']));
        }
        elseif (is_array($config['filter.access']))
        {
          foreach ($config['filter.access'] as &$access)
          {
            $access = $db->quote($access);
          }
          $query->where('categories.access IN (' . implode(',', $config['filter.access']) . ')');
        }
      }

      $query->order('categories.lft');

      $db->setQuery($query);

      // Assemble the list options.
      static::$categories[$hash] = $db->loadObjectList();
    }

    return static::$categories[$hash];
  }
}

