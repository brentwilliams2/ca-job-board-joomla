<?php
 /**
 * Multi Family Insiders Template Search Module Helper
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC, (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;

/**
 * Finder module helper.
 *
 * @since  1.0
 */
class ModFinderHelper
{
	/**
	 * Method to get hidden input fields for a get form so that control variables
	 * are not lost upon form submission.
	 *
	 * @param   string   $route      The route to the page. [optional]
	 * @param   integer  $paramItem  The menu item ID. (@since 3.1) [optional]
	 *
	 * @return  string  A string of hidden input form fields
	 *
	 * @since   1.0
	 */
	public static function getGetFields($route = null, $paramItem = 0)
	{
		// Determine if there is an item id before routing.
		$needId = !JUri::getInstance($route)->getVar('Itemid');

    $fields = array();

    $uri = JUri::getInstance(JRoute::_($route));

		$uri->delVar('q');

		// Create hidden input elements for each part of the URI.
		foreach ($uri->getQuery(true) as $n => $v)
		{
			$fields[] = '<input type="hidden" name="' . $n . '" value="' . $v . '" />';
		}

		// Add a field for Itemid if we need one.
		if ($needId)
		{
      $id       = $paramItem ?: JFactory::getApplication()->input->get('Itemid', '0', 'int');

			$fields[] = '<input type="hidden" name="Itemid" value="' . $id . '" />';
		}

		return implode('', $fields);
	}


	/**
	 * Get Smart Search query object.
	 *
	 * @param   \Joomla\Registry\Registry  $params  Module parameters.
	 *
	 * @return  FinderIndexerQuery object
	 *
	 * @since   1.0
	 */
	public static function getQuery($params)
	{
    $app     = JFactory::getApplication();

    $input   = $app->input;

    $request = $input->request;

		$filter  = JFilterInput::getInstance();

		// Get the static taxonomy filters.
    $options = array();

    $options['filter'] = ($request->get('f', 0, 'int') !== 0) ? $request->get('f', '', 'int') : $params->get('searchfilter');

		$options['filter'] = $filter->clean($options['filter'], 'int');

		// Get the dynamic taxonomy filters.
    $options['filters'] = $request->get('t', '', 'array');

    $options['filters'] = $filter->clean($options['filters'], 'array');

		$options['filters'] = ArrayHelper::toInteger($options['filters']);

		// Instantiate a query object.
		return new FinderIndexerQuery($options);
	}
}