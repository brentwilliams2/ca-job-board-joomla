<?php
/**
 * Social Shares Module for Multi Family Insiders Bootstrap V3 Template Helper
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC, (c) 2019 Steven Palmer All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

// no direct access
defined('_JEXEC') or die;

use Joomla\String\StringHelper;
use Joomla\Utilities\ArrayHelper;
use \Joomla\CMS\Factory;
use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Component\ComponentHelper;
use \Joomla\CMS\MVC\\Model\BaseDatabaseModel;
use \Joomla\CMS\Access\Access;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Router\Route;

jimport('joomla.filesystem.file');

$com_path = JPATH_SITE . '/components/com_content/';

JLoader::register('ContentHelperRoute', $com_path . 'helpers/route.php');

JModelLegacy::addIncludePath($com_path . 'models', 'ContentModel');

class ModMfiTemplateSocialShareHelper
{
	/**
	 * Get a list of the latest articles from the article model
	 *
	 * @param   \Joomla\Registry\Registry  &$params  object holding the models parameters
	 *
	 * @return  mixed
	 */
  public static function getList(&$params)
  {
		$app = Factory::getApplication();

		// Get an instance of the generic articles model
		$model = BaseDatabaseModel::getInstance('Articles', 'ContentModel', array('ignore_request' => true));

		// Set application parameters in model
		$appParams = Factory::getApplication()->getParams();
		$model->setState('params', $appParams);

		// Set the filters based on the module params
		$model->setState('list.start', (int) $params->get('skip', 0));

    $model->setState('list.limit', (int) $params->get('count', 5) + (int) $params->get('link_count', 5));

		$model->setState('filter.published', 1);

    // This module does not use tags data
    $model->setState('load_tags', true);

		$model->setState('list.select', 'a.fulltext, a.id, a.title, a.alias, a.introtext, a.state, a.catid, a.created, a.created_by, a.created_by_alias,' .
			' a.modified, a.modified_by, a.publish_up, a.publish_down, a.images, a.urls, a.attribs, a.metadata, a.metakey, a.metadesc, a.access,' .
			' a.hits, a.featured, a.language' );

		// Access filter
    $access = !ComponentHelper::getParams('com_content')->get('show_noauth');

    $authorised = Access::getAuthorisedViewLevels(Factory::getUser()->get('id'));

		$model->setState('filter.access', $access);

		// Category filter
		$model->setState('filter.category_id', $params->get('catid', array()));

		// Filter by language
		$model->setState('filter.language', $app->getLanguageFilter());

    // Filer by tag
    $model->setState('filter.tag', $params->get('tag'), array());

		// Set ordering
    $ordering = $params->get('ordering', 'a.publish_up');

		$model->setState('list.ordering', $ordering);

		if (trim($ordering) == 'rand()')
		{
			$model->setState('list.direction', '');
		}
		else
		{
			$direction = $params->get('direction', 1) ? 'DESC' : 'ASC';
			$model->setState('list.direction', $direction);
		}

		// Retrieve Content
		$items = $model->getItems();

		foreach ($items as &$item)
		{
			$item->readmore = strlen(trim($item->fulltext));
			$item->slug = $item->id . ':' . $item->alias;
			$item->catslug = $item->catid . ':' . $item->category_alias;

			if ($access || in_array($item->access, $authorised))
			{
				// We know that user has the privilege to view the article
				$item->link = Route::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid));
        $item->catLink = Route::_(ContentHelperRoute::getCategoryRoute($item->catid));
				$item->linkText = Text::_('MOD_CWNEWS_READMORE');
			}
			else
			{
				$item->link = Route::_('index.php?option=com_users&view=login');
				$item->linkText = Text::_('MOD_CWNEWS_READMORE_REGISTER');
			}
		}

		return $items;
	}

  /**
   * Check if we have any links to display
   *
   * @param $list
   * @param $params
   * @return bool
   */
  public static function checkForLinks($list, $params)
  {
    $test = false;
    $list = array_filter($list);

    if (empty($list)) {
      return $test;
    }
    $currentArticles = count($list);

    if ($currentArticles > $params->get('count', 5)) {
      $test = true;
    }
    return $test;
  }

  /**
   * Updating old type choices to current
   *
   * @param $currentType
   * @return array
   */
  public static function checkType($currentType)
  {
    $changed = false;
    $type = null;

    //List of obsolete types
    $obsolete = array('0', '1');

    if (in_array($currentType, $obsolete))
    {
      switch ($currentType) {
        case '0':
          $type = 'image_intro';
          $changed = true;
          break;
        case '1':
          $type = 'image_fulltext';
          $changed = true;
          break;
      }
    }

    $newType = [
      'changed' => $changed,
      'type' => $type
    ];

    return $newType;
  }

  /**
   * Function to extract an image from an article
   *
   * @param $item
   * @param string $type
   * @return array
   */
  public static function getImage($item, $type = 'image_intro')
  {
    $imagePath = $imageAlt = $imageCaption = '';

    $image = json_decode($item->images);

    switch ($type)
    {
      case 'image_intro':
        $imagePath = $image->image_intro;
        $imageAlt = $image->image_intro_alt;
        $imageCaption = $image->image_intro_caption;
        break;

      case 'image_fulltext':
        $imagePath = $image->image_fulltext;
        $imageAlt = $image->image_fulltext_alt;
        $imageCaption = $image->image_fulltext_caption;
        break;
    }

    $imageParams = [
      'image_path' => $imagePath,
      'image_alt' => $imageAlt,
      'image_caption' => $imageCaption
    ];

    return $imageParams;
  }
}
