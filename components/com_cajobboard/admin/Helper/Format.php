<?php
/**
 * Helper class for formatting data for display
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 *
 */

namespace Calligraphic\Cajobboard\Admin\Helper;

use DateTimeZone;
use JLoader;
use JText;

use Joomla\CMS\Factory;

use FOF30\Container\Container;
use FOF30\Date\Date;
use FOF30\Model\DataModel;

// no direct access
defined('_JEXEC') or die;

/**
 * A helper class for formatting data for display
 */
abstract class Format
{
	/**
	 * Format a date for display.
	 *
	 * The $tzAware parameter defines whether the formatted date will be timezone-aware. If set to false the formatted
	 * date will be rendered in the UTC timezone. If set to true the code will automatically try to use the logged in
	 * user's timezone or, if none is set, the site's default timezone (Server Timezone). If set to a positive integer
	 * the same thing will happen but for the specified user ID instead of the currently logged in user.
	 *
	 * @param   string    $date     The date to format
	 * @param   string    $format   The format string, default is whatever you specified in the component options
	 * @param   bool|int  $tzAware  Should the format be timezone aware? See notes above.
	 *
	 * @return string
	 */
	public static function date($date, $format = null, $tzAware = true)
	{
    $utcTimeZone = new DateTimeZone('UTC');

    $jDate       = new Date($date, $utcTimeZone);

		// Which timezone should I use?
    $tz = null;

		if ($tzAware !== false)
		{
      $userId    = is_bool($tzAware) ? null : (int) $tzAware;

			try
			{
				$tzDefault = Factory::getApplication()->get('offset');
			}
			catch (\Exception $e)
			{
				$tzDefault = 'GMT';
      }

			$user      = Factory::getUser($userId);
			$tz        = $user->getParam('timezone', $tzDefault);
    }

		if (!empty($tz))
		{
			try
			{
				$userTimeZone = new DateTimeZone($tz);
				$jDate->setTimezone($userTimeZone);
			}
			catch(\Exception $e)
			{
				// Nothing. Fall back to UTC.
			}
    }

		if (empty($format))
		{
			$format = self::getContainer()->params->get('dateformat', 'Y-m-d H:i T');
			$format = str_replace('%', '', $format);
    }

		return $jDate->format($format, true);
  }


	/**
	 * Check if the given string is a valid date
	 *
	 * @param   string  $date  Date as string
	 *
	 * @return  bool|Date  False on failure, JDate if successful
	 */
	public static function checkDateFormat($date)
	{
    JLoader::import('joomla.utilities.date');

    $regex = '/^\d{1,4}(\/|-)\d{1,2}(\/|-)\d{2,4}[[:space:]]{0,}(\d{1,2}:\d{1,2}(:\d{1,2}){0,1}){0,1}$/';

		if (!preg_match($regex, $date))
		{
			return false;
    }

		return new Date($date);
  }


	/**
	 * Format a value as money
	 *
	 * @param   float   $value  The money value to format
	 *
	 * @return  string  The HTML of the formatted price
	 */
	public static function formatPrice($value)
	{
		static $currencyPosition = null;
    static $currencySymbol = null;

		if (is_null($currencyPosition))
		{
			$currencyPosition = self::getContainer()->params->get('currencypos', 'before');
			$currencySymbol = self::getContainer()->params->get('currencysymbol', '€');
    }

    $html = '';

		if ($currencyPosition == 'before')
		{
			$html .= $currencySymbol . ' ';
    }

    $html .= sprintf('%2.2f', (float) $value);

		if ($currencyPosition != 'before')
		{
			$html .= ' ' . $currencySymbol;
    }

		return $html;
  }


	/**
	 * Returns the current Calligraphic Job Boards container object
	 *
	 * @return  Container
	 */
	protected static function getContainer()
	{
    static $container = null;

		if (is_null($container))
		{
			$container = Container::getInstance('com_cajobboard');
    }

		return $container;
	}
}
