<?php
/**
 * MFI Template Search Module
 *
 * Get count of all module positions to avoid calling methods on null objects
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC, (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

use \Joomla\CMS\Helper\ModuleHelper;

// no direct access
defined('_JEXEC') or die;

\JLoader::register('FinderHelperRoute', JPATH_SITE . '/components/com_finder/helpers/route.php');
\JLoader::register('ModFinderHelper', __DIR__ . '/helper.php');

if (!defined('FINDER_PATH_INDEXER'))
{
	define('FINDER_PATH_INDEXER', JPATH_ADMINISTRATOR . '/components/com_finder/helpers/indexer');
}

\JLoader::register('FinderIndexerQuery', FINDER_PATH_INDEXER . '/query.php');

// Get the route.
$route = FinderHelperRoute::getSearchRoute($params->get('searchfilter', null));

// Get Smart Search query object.
$query = ModFinderHelper::getQuery($params);

require ModuleHelper::getLayoutPath('mod_mfi_template_finder', $params->get('layout', 'default'));
