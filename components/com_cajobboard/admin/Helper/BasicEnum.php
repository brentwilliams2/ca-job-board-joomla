<?php
/**
 * Basic ENUM class to use instead of SplEnum standard
 * class, which is missing in base PHP installation
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Helper;

use ReflectionClass;

// no direct access
defined('_JEXEC') or die;

abstract class BasicEnum
{
  /*
  * Cache of the results from reflection calls, keyed by class name
  *
  * @var
  */
  private static $constCacheArray = NULL;


  /*
  * Class Construction, private to prevent instantiation of class
  */
  private function __construct() {}

  /*
  * Use reflection to get the class constants for the calling class, and cache that value
  *
  * @returns  Array   An associative array of class constants and their values
  */
  private static function getConstants()
  {
    if (self::$constCacheArray == NULL)
    {
      self::$constCacheArray = [];
    }

    $calledClass = get_called_class();

    if (!array_key_exists($calledClass, self::$constCacheArray))
    {
      $reflect = new ReflectionClass($calledClass);

      self::$constCacheArray[$calledClass] = $reflect->getConstants();
    }

    return self::$constCacheArray[$calledClass];
  }


  /*
  * Check if a given ENUM name is a class constant for the calling class
  *
  * @param    string  $name     The ENUM value to check
  * @param    bool    $strict   Whether to perform a case-sensitive match of the ENUM value to class constant properties, defaults to false
  *
  * @returns  bool    Whether the ENUM name exists in the calling class or not
  */
  public static function isValidName($name, $strict = false)
  {
    $constants = self::getConstants();

    if ($strict)
    {
        return array_key_exists($name, $constants);
    }

    $keys = array_map('strtolower', array_keys($constants));

    return in_array(strtolower($name), $keys);
  }


  /*
  * Check if a given integer value is a valid value for a defined class constant in the calling class
  *
  * @param    string  $name     The value to check
  *
  * @returns  bool    Whether the value is valid for a class constant property in the calling class or not
  */
  public static function isValidValue($value)
  {
    $values = array_values(self::getConstants());

    return in_array($value, $values, $strict = true);
  }


  /*
  * Returns all ENUM consts with values as an array for the calling class. For SplEnum compatability
  *
  * $params   bool    $default    For compatability with SplEnum
  *
  * @returns  Array   An array of ENUM class constant properties and their values
  */
  public static function getConstList($default = false)
  {
    $constants = self::getConstants();

    if ($default)
    {
      $constants["__default"] = false;
    }

    return $constants;
  }
}
