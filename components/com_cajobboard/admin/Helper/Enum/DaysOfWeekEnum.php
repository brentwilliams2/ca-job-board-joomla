<?php
/**
 * Admin Days of Week Enumerated List
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Helper\Enum;

// no direct access
defined( '_JEXEC' ) or die;

use \Calligraphic\Cajobboard\Admin\Helper\Enum\BasicEnum;

/*
 * https://schema.org/DayOfWeek
 */
abstract class DaysOfWeekEnum extends BasicEnum
{
  const Monday = 2;
  const Tuesday = 4;
  const Wednesday = 8;
  const Thursday = 16;
  const Friday = 32;
  const Saturday = 64;
  const Sunday = 128;
  const Weekdays = 62;
  const Weekends = 192;
  const PublicHolidays = 1024;

  /*
   * Method to convert a bitmap of days of the week into an array with the
   */
  public static function getDaysAsArray($bitmaskToDecode)
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

  /*
   * Method to convert an array of enum names of days of the week to a bitmask
   */
  public static function getBitmaskByNames($daysAsNamesArray)
  {
    $bitmask = 0;

    // @TODO: need logic to remove day names when they overlap with the "Weekdays" or "Weekends" values, e.g. having both "Monday" and "Weekdays" in the array

    foreach ($daysAsNamesArray as $day)
    {
      if ( !self::isValidName($day) )
      {
        throw new \Exception('Name of day passed to getBitmaskByNames is not valid, given: ' . $day);
      }

      $bitmask += self::$day;
    }

    return $bitmask;
  }


  /*
   * Method to convert an array of numeric days values to a bitmask
   */
  public static function getBitmaskByValues($daysAsValuesArray)
  {
    // @TODO: need logic to remove day names when they overlap with the "Weekdays" or "Weekends" values, e.g. having both "Monday" and "Weekdays" in the array

    return array_sum($daysAsValuesArray);
  }
}


