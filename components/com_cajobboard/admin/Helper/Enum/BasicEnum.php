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

use \Joomla\CMS\Language\Text;
use \ReflectionClass;

// no direct access
defined('_JEXEC') or die;

abstract class BasicEnum
{
 /**
  * Cache of the results from reflection calls, keyed by class name.
  *
  * @static   array|null    $constCacheArray    An array with the structure, e.g.:
  *             $constCacheArray['ActionStatusEnum'] = array('ACTIVE' => 'ACTIVE', ...);
  *           where the array keys are the enum constant names, and the array value is the constant value.
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

    $callingClass = get_called_class();

    $reflect = new ReflectionClass($callingClass);

    $shortenedCallingClass = $reflect->getShortName();

    if (!array_key_exists($shortenedCallingClass, self::$constCacheArray))
    {
      self::$constCacheArray[$shortenedCallingClass] = $reflect->getConstants();
    }

    return self::$constCacheArray[$shortenedCallingClass];
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


  /**
   * Get an underscored, all-caps key to use for the enum class in building a translation key
   *
   * @return string  Returns a translation key fragment based on the enum class
   */
  public static function getEnumClassTranslationKey()
  {
    $callingClass = get_called_class();

    $reflect = new ReflectionClass($callingClass);

    $shortenedCallingClass = $reflect->getShortName();

    // Enum class names follow convention, e.g. ActionStatusEnum
    $camelCaseClassName = str_replace('Enum', '', $shortenedCallingClass);

    // e.g. 'ACTION_STATUS'
    return strtoupper( preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $camelCaseClassName) );
  }


  /**
   * Get human-readable enum class constant names using translation keys
   *
   * @return array  Returns an associative array of human-readable enum constant names and their constant values
   */
  public static function getHumanReadableConstants()
  {
    $enumConstantsArray = self::getConstants();

    $newEnumArray = array();

    $enumClassTranslationKey = self::getEnumClassTranslationKey();

    foreach ($enumConstantsArray as $enumConstantName => $value)
    {
      // e.g. COM_CAJOBBOARD_ENUM_ACTION_STATUS_ACTIVE, where 'ACTION_STATUS' is the name of the enum and 'ACTIVE' is an enum constant
      $humanReadableName = Text::_('COM_CAJOBBOARD_ENUM_' . $enumClassTranslationKey . '_' . $enumConstantName);

      $newEnumArray[$humanReadableName] = $value;
    }

    return $newEnumArray;
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
}
