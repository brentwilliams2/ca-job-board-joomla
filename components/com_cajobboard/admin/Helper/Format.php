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

use \DateTimeZone;
use \FOF30\Container\Container;
use \FOF30\Date\Date;
use \JLoader;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;

/**
 * A helper class for formatting data for display
 */
class Format
{
  /**
   * A reference to the application container
   *
   * @property Container
   */
  protected $container;


  /**
   * Where the currency symbol is positioned relative to the amount, valid values are 'before' and 'after
   *
   * @property string
   */
  protected $currencyPosition;


  /**
   * What currency symbol to use
   *
   * @property string
   */
  protected $currencySymbol;


  /**
   * The dateformat to use for this object, e.g. 'm-d-Y'
   *
   * @property string
   */
  protected $dateFormat;


  /**
	 * @param   Container   $container    The application container
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct ($container)
	{
    $this->container = $container;

    $this->currencyPosition = $this->container->platform->getConfigOption('currencypos', 'before');

    $this->currencySymbol = $this->container->platform->getConfigOption('currencysymbol', '$');


		if (empty($format))
		{
			$this->dateFormat = $this->container->platform->getConfigOption('dateformat', 'm-d-Y');
    }
  }


	/**
	 * Format a date for display.
	 *
	 * The $tzAware parameter defines whether the formatted date will be timezone-aware. If set to false the formatted
	 * date will be rendered in the UTC timezone. If set to true the code will automatically try to use the logged in
	 * user's timezone or, if none is set, the site's default timezone (Server Timezone). If set to a positive integer
	 * the same thing will happen but for the specified user ID instead of the currently logged in user.
	 *
	 * @param   string    $date     The date to format
	 * @param   string    $format   The format string, default is whatever you specified in the component
   *                              options, see https://www.php.net/manual/en/function.date.php
	 * @param   bool|int  $tzAware  Should the format be timezone aware? See notes above.
	 *
	 * @return string
	 */
	public function date($date, $format = null, $tzAware = true)
	{
    $utcTimeZone = new DateTimeZone('UTC');

    $dateObject = new Date($date, $utcTimeZone);

		// Which timezone should I use?
    $tz = null;

		if ($tzAware !== false)
		{
      if ($tzAware === true)
      {
        $user = $this->container->platform->getUser();
      }
      else
      {
        $user = $this->container->platform->getUser($tzAware);
      }

  		$tzDefault = $this->container->platform->getConfigOption('offset', 'GMT');

			$tz = $user->getParam('timezone', $tzDefault);
    }

		if (!empty($tz))
		{
			try
			{
        $userTimeZone = new DateTimeZone($tz);

				$dateObject->setTimezone($userTimeZone);
			}
			catch(\Exception $e)
			{
				// Nothing. Fall back to UTC.
			}
    }

    return $dateObject->format($this->dateFormat, true);
  }


	/**
	 * Check if the given string is a valid date
	 *
	 * @param   string  $date  Date as string
	 *
	 * @return  bool|Date  False on failure, JDate if successful
	 */
	public function checkDateFormat($date)
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
	public function formatPrice($value)
	{
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
   * Format date strings to "1 day ago", etc.
   *
   * @param    $dateCreated  Date/time the object was created
   * @param    $dateModified Date/time the object was last modified
   *
   * @return   string  Formatted time
   */
  public function convertToTimeAgoString($dateCreated, $dateModified = null)
  {
    // difference between current time and the database (MySQL format) item's created or modified time (whichever is later)
    $diff = time() - strtotime( $dateModified ? $dateModified : $dateCreated );

    if( $diff < 60 ) // it happened now
      return Text::_('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_NOW');

    elseif( $diff >= 60 && $diff < 120 ) // it happened 1 minute ago
      return Text::_('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_MINUTE');

    elseif( $diff < 3600 ) // it happened n minutes ago
      return Text::sprintf('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_MINUTES', round($diff / 60));

    elseif( $diff >= 3600 && $diff < 7200 ) // it happened 1 hour ago
      return Text::_('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_HOUR');

    elseif( $diff < 3600 * 24 ) // it happened n hours ago
      return Text::sprintf('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_HOURS', round($diff / 3600));

    elseif( $diff < 3600 * 24 * 2 ) // it happened yesterday
      return Text::_('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_YESTERDAY');

    elseif( $diff < 3600 * 24 * 30 ) // it happened n days ago
      return Text::sprintf('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_DAYS', round($diff / (3600 * 24)));

    elseif( $diff >= 3600 * 24 * 30 * 2 && $diff >= 3600 * 24 * 30 * 3 ) // it happened 1 month ago
      return Text::_('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_MONTH');

    elseif( $diff < 3600 * 24 * 30 * 12 ) // it happened n months ago
      return Text::sprintf('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_MONTHS', round($diff / (3600 * 24 * 30)));

    else // it happened a long time ago
      return Text::_('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_LONG');
  }


  /**
   * Format the "Created on" date strings to "Tuesday, April 4 2019, 12:18 pm", etc.
   *
   * @param    Date  $date   The date/time object to use for output
   *
   * @return   string  Formatted time
   */
  public function getCreatedOnText($date)
  {
    // handle new records with database engine constant for time stamp
    if ('CURRENT_TIMESTAMP' == $date)
    {
      $now = new Date();

      $date = (string) $now;
    }

    return $this->date($date, 'l, F n o, g:i a');
  }
}
