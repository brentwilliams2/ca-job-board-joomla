<?php
/**
 * Admin Days of Week Enumerated List, using a bitmask to specify individual days
 * e.g. you can specify "monday through friday" with this enum
 *
 * @package   Calligraphic Job Board
 * @version   September 1, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Helper\Enum;

// no direct access
defined( '_JEXEC' ) or die;

use \Calligraphic\Cajobboard\Admin\Helper\Enum\BasicEnum;
use \Calligraphic\Cajobboard\Admin\Helper\Exception\EnumException;
use \Joomla\CMS\Language\Text;

/*
 * https://schema.org/DayOfWeek
 */
abstract class DaysOfWeekEnum extends BasicEnum
{
  const MONDAY = 2;
  const TUESDAY = 4;
  const WEDNESDAY = 8;
  const THURSDAY = 16;
  const FRIDAY = 32;
  const SATURDAY = 64;
  const SUNDAY = 128;
  const WEEKDAYS = 62;
  const WEEKENDS = 192;
  const PUBLIC_HOLIDAYS = 1024;

  /**
   * Method to convert a bitmap of days of the week into an array with the days of week
   *
   * @param   int   $bitmaskToDecode    A bitmask value encoding one or more days, e.g. '24' for Wednesday and Thursday
   */
  public static function getDaysNamesAndValues($bitmaskToDecode)
  {
    $days = array();

    $daysMap = self::getConstants();

    foreach ($daysMap as $dayName => $bitmask)
    {
      if ($bitmask & $bitmaskToDecode)
      {
        array_push($days, $dayName);
      }
    }

    return $days;
  }


  /**
   * Get human-readable days of week as an array
   *
   * @param   int   $bitmaskToDecode    A bitmask value encoding one or more days, e.g. '24' for Wednesday and Thursday
   *
   * @return array  Returns an associative array of human-readable day names and the name's numeric enum value
   */
  public static function getHumanReadableDaysNamesAndValues($bitmaskToDecode)
  {
    $daysArray = self::getDaysNamesAndValues($bitmaskToDecode);

    $newDaysArray = array();

    foreach ($daysArray as $name => $value)
    {
      $humanReadableName = Text::_('COM_CAJOBBOARD_ENUM_DAYS_OF_WEEK_' . $name);

      $newDaysArray[$humanReadableName] = $value;
    }

    return $newDaysArray;
  }


  /**
   * Method to convert an array of enum names of days of the week to a bitmask
   *
   * @param array $daysAsNamesArray   An array of days names, e.g. array('SATURDAY', 'SUNDAY')
   */
  public static function getDaysOfWeekBitmaskByNames($daysAsNamesArray)
  {
    $bitmask = 0;

    // @TODO: need logic to remove day names when they overlap with the "Weekdays" or "Weekends" values, e.g. having both "Monday" and "Weekdays" in the array

    foreach ($daysAsNamesArray as $day)
    {
      if ( !self::isValidConstant($day) )
      {
        throw new EnumException( Text::sprintf('COM_CAJOBBOARD_EXCEPTION_ENUM_DAYS_OF_WEEK_INVALID_CONSTANT' . $day) );
      }

      $bitmask += self::$day;
    }

    return $bitmask;
  }


  /**
   * Method to convert an array of numeric days values to a bitmask
   *
   * @param array $daysAsValuesArray   An array of days values, e.g. array(8, 16)
   */
  public static function getDaysOfWeekBitmaskByValues($daysAsValuesArray)
  {
    // @TODO: need logic to remove day names when they overlap with the "Weekdays" or "Weekends" values, e.g. having both "Monday" and "Weekdays" in the array

    return array_sum($daysAsValuesArray);
  }
}


