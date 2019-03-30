<?php
/**
 * Common custom Joomla! HTMLHelper class for admin edit view controls
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Usage in Blade templates:
 *     @jhtml('helper.commonWidgets.methodName', parameter1, ...)
 *
 * These are based on the Akeeba FEF (front-end framework) helperrs included in FOF with revised HTML output
 */

// Can't namespace since this class is used through Joomla's autoloader and JHtml system

// no direct access
defined('_JEXEC') or die;

use \FOF30\Utils\SelectOptions;

abstract class HelperCommonWidgets
{
	/**
	 * Hits counter widget
   *
   * @param   int   How many counts this item has
	 *
	 * @return  string
	 *
	 * @since   0.1
	 */
	public static function hits($count)
	{
    $html  = '<span class="badge badge-info">';
    $html .= $count;
    $html .= '</span>';

		return $html;
  }


	/**
	 * Access (e.g. "Public") widget
   *
   * @param   int  $level  What access level is set for this item
	 *
	 * @return  string
	 *
	 * @since   0.1
	 */
	public static function access($level)
	{
    $accessLevels = SelectOptions::getOptions('access');

    foreach ($accessLevels as $accessLevel)
    {
      if ($accessLevel->value === $level)
      {
        $levelName = $accessLevel->text;
        break;
      }
    }

    if (!$levelName)
    {
      throw new Exception("Can't match an access level name to the numeric level in Helper/commonwidgets.php::access method");
    }

    $html = '<label for="access">' . $levelName . '</label>';

		return $html;
  }
}

