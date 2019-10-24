<?php
/**
 * Admin Image Objects Aspect Ratios Enum Helper
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

abstract class ImageObjectAspectRatioEnum extends BasicEnum
{
  const CAMERA_LANDSCAPE = 'CAMERA_LANDSCAPE';
  const CAMERA_PORTRAIT = 'CAMERA_PORTRAIT';
  const MEDIUM_LANDSCAPE = 'MEDIUM_LANDSCAPE';
  const MEDIUM_PORTRAIT = 'MEDIUM_PORTRAIT';
  const OTHER = 'OTHER';
  const SQUARE = 'SQUARE';
  const STANDARD_LANDSCAPE = 'STANDARD_LANDSCAPE';
  const STANDARD_PORTRAIT = 'STANDARD_PORTRAIT';
  const WIDE_LANDSCAPE = 'WIDE_LANDSCAPE';


  /**
   * Get the height value for a given aspect ratio name
   *
   * @param   string  $aspect   The aspect ratio name, e.g. 'STANDARD_LANDSCAPE'
   *
   * @return  int   The height
   */
  public static function getHeightAspect($aspect)
  {
    return self::getMetaProperty($aspect, 'heightAspect');
  }


  /**
   * Get the width value for a given aspect ratio name
   *
   * @param   string  $aspect   The aspect ratio name, e.g. 'STANDARD_LANDSCAPE'
   *
   * @return  int   The width
   */
  public static function getWidthAspect($aspect)
  {
    return self::getMetaProperty($aspect, 'widthAspect');
  }


  /**
   * Get the aspect ratio value for a given aspect ratio name
   *
   * @param   string  $aspect   The aspect ratio name, e.g. 'STANDARD_LANDSCAPE'
   *
   * @return int  The aspect ratio
   */
  public static function getAspectRatio($aspect)
  {
    return self::getMetaProperty($aspect, 'aspectRatio');
  }


  /**
   * Get available aspect ratios as an array
   *
   * @return array  Returns an associative array of aspect ratio names
   */
  public static function getAspectRatioNames()
  {
    return self::getConstants();
  }


  /**
   * Get a meta-property value based on the aspect ratio name
   *
   * @param   string      $aspect     The aspect ratio name, e.g. 'STANDARD_LANDSCAPE'
   * @param   string      $property   The meta-property to get a value for
   *
   * @return  mixed   The property value for the aspect ratio name
   */
  public static function getMetaProperty($aspect, $property)
  {
    if ( !self::isValidConstant($aspect) )
    {
      throw new EnumException( Text::_('COM_CAJOBBOARD_EXCEPTION_ENUM_IMAGE_OBJECT_ASPECT_RATIO_INVALID_CONSTANT') );
    }

    switch ($aspect)
    {
      case 'MEDIUM_LANDSCAPE':
        $metadata = array('widthAspect' => 5,  'heightAspect' => 4, 'aspectRatio' => 5 / 4);
        break;

      case 'MEDIUM_PORTRAIT':
        $metadata = array('widthAspect' => 4,  'heightAspect' => 5, 'aspectRatio' => 4 / 5);
        break;

      case 'OTHER':
        $metadata = array('widthAspect' => 0,  'heightAspect' => 0,  'aspectRatio' => 0, 'channel' => array() );
        break;

      case 'SQUARE':
        $metadata = array('widthAspect' => 1,  'heightAspect' => 1, 'aspectRatio' => 1 / 1);
        break;

      case 'STANDARD_LANDSCAPE':
        $metadata = array('widthAspect' => 4,  'heightAspect' => 3, 'aspectRatio' => 4 / 3);
        break;

      case 'STANDARD_PORTRAIT':
        $metadata = array('widthAspect' => 3,  'heightAspect' => 4, 'aspectRatio' => 3 / 4);
        break;

      case 'WIDE_LANDSCAPE':
        $metadata = array('widthAspect' => 16, 'heightAspect' => 9, 'aspectRatio' => 16 / 9);
        break;

      case 'CAMERA_PORTRAIT':
        $metadata = array('widthAspect' => 2,  'heightAspect' => 3, 'aspectRatio' => 2 / 3);
        break;

      case 'CAMERA_LANDSCAPE':
        $metadata = array('widthAspect' => 3, 'heightAspect' => 2, 'aspectRatio' => 3 / 2);
        break;
    }

    if ( !array_key_exists($property, $metadata) )
    {
      throw new EnumException( Text::_('COM_CAJOBBOARD_EXCEPTION_ENUM_IMAGE_OBJECT_ASPECT_RATIO_INVALID_METADATA_PROPERTY') );
    }

    return $metadata[$property];
  }
}
