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
 *
 * Usage:
 *
 *   abstract class MyEnum extends BasicEnum
 *   {
 *     // Note that it's convenient for enum_value to match anEnum, unless doing something like a
 *     // bitmask. That way you can use constant($varWithConstantName) to get the constant name back.
 *     const anEnum = 'enum_value';
 *   }
 *
 *   $isValid = MyEnum::isValidConstant($value);
 *
 *   $equals = MyEnum::anEnum == $value;
 */

namespace Calligraphic\Cajobboard\Admin\Helper\Enum;

use \ReflectionClass;

// no direct access
defined('_JEXEC') or die;

abstract class BasicEnum
{
 /**
  * Cache of the results from reflection calls, keyed by class name
  *
  * @var
  */
  private static $constCacheArray = NULL;


 /**
  * Class Construction, private to prevent instantiation of class
  */
  private function __construct() {}


 /**
  * Use reflection to get the class constants for the calling class, and cache that value
  *
  * @returns  Array   An associative array of class constants and their values
  */
  public static function getConstants()
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


 /**
  * Check if a given ENUM name is a class constant for the calling class
  *
  * @param    string  $name     The ENUM value to check
  * @param    bool    $strict   Whether to perform a case-sensitive match of the ENUM value to class constant properties, defaults to false
  *
  * @returns  bool    Whether the ENUM name exists in the calling class or not
  */
  public static function isValidConstant($name, $strict = false)
  {
    $constantsArray = self::getConstants();

    if ($strict)
    {
        return array_key_exists($name, $constantsArray);
    }

    $keys = array_map('strtolower', array_keys($constantsArray));

    return in_array(strtolower($name), $keys);
  }


 /**
  * Check if a given ENUM name's integer value is valid
  *
  * @param    string  $value    The ENUM value to check
  *
  * @returns  bool    Whether the ENUM name exists in the calling class or not
  */
  public static function isValidEnumValue($value)
  {
    $constantsArray = self::getConstants();

    return in_array($value, $constantsArray, true);
  }


 /**
  * Get the value that is associated with a constant name
  *
  * @returns  int   Returns the value of the constant
  */
  public static function getValueForConstant($constant)
  {
    $constantsArray = self::getConstants();

    return $constantsArray[$constant];
  }


 /**
  * Get the constant name that is associated with a value
  *
  * @returns  string  Returns the name of the constant
  */
  public static function getConstantForValue($value)
  {
    $constantsArray = self::getConstants();

    return array_search($value, $constantsArray);
  }
}
