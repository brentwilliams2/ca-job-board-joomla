<?php
/**
 * Admin Video Objects Aspect Ratios Enum Helper
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
use \Calligraphic\Cajobboard\Admin\Helper\Exception\EnumException;
use \Joomla\CMS\Language\Text;

/*
 * ENUM class for system media object aspect ratios. Each value corresponds to a directory
 * in Joomla!'s site /media/com_cajobboard/{category name}/ folder (note that category
 * and model names are the same so the model name can be denormalized after lowercasing)
 */
abstract class VideoObjectAspectRatioEnum extends BasicEnum
{
  /**
   * Facebook Feed, Twitter: 720 x 720px. Instagram (?): 600 x 600 px
   */
  const CAROUSEL = 'CAROUSEL';


  /**
   * 1080p: 1920 x 1080px (Youtube), 720p: 1280×720px (Youtube, Twitter, Facebook Feed)
   */
  const WIDE_LANDSCAPE = 'WIDE_LANDSCAPE';


  /**
   * Facebook Feed, Twitter: 720 x 1280px
   */
  const WIDE_PORTRAIT = 'WIDE_PORTRAIT';


  /**
   * 480p: 640 x 480px
   */
  const STANDARD_LANDSCAPE = 'STANDARD_LANDSCAPE';


  /**
   * Many
   */
  const STANDARD_PORTRAIT = 'STANDARD_PORTRAIT';


  /**
   * Facebook Feed. Instagram (?): 600 by 750 px
   */
  const MEDIUM_PORTRAIT = 'MEDIUM_PORTRAIT';


  /**
   * 9/21 aspect ratio for Facebook
   */
  const ANAMORPHIC_PORTRAIT = 'ANAMORPHIC_PORTRAIT';


  /**
   * Fall-through for undefined aspect ratios
   */
  const OTHER = 'OTHER';


  /**
   * Get the height value for a given aspect ratio name
   *
   * @param   string  $aspect   The aspect ratio name, e.g. 'STANDARD_LANDSCAPE'
   *
   * @return  int   The height
   */
  public static function getHeight($aspect)
  {
    return self::getMetaProperty($aspect, 'height');
  }


  /**
   * Get the width value for a given aspect ratio name
   *
   * @param   string  $aspect   The aspect ratio name, e.g. 'STANDARD_LANDSCAPE'
   *
   * @return  int   The width
   */
  public static function getWidth($aspect)
  {
    return self::getMetaProperty($aspect, 'width');
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
    return self::getMetaProperty($aspect, 'ratio');
  }


  /**
   * Get the supported social media channels (e.g. Facebook) for a given aspect ratio
   *
   * @param   string  $aspect   The aspect ratio name, e.g. 'STANDARD_LANDSCAPE'
   *
   * @return  array   An array of supported social media channels
   */
  public static function getChannels($aspect)
  {
    return self::getMetaProperty($aspect, 'channel');
  }


  /**
   * Check if a given social media channel (e.g. Facebook) supports an aspect ratio
   *
   * @param   string  $aspect   The aspect ratio name, e.g. 'STANDARD_LANDSCAPE'
   * @param   string  $channel  The social media channel
   *
   * @return boolean  Whether the aspect ratio is supported for the social media channel
   */
  public static function isChannelSupported($aspect, $channel)
  {
    return $channel == self::getMetaProperty($aspect, 'channel');
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
   * Twitter:   60 fps or less; dimensions between 32 x 32 and 1280 x 1024; file size <= 512 MB;
   *            duration between 0.5 and 140 seconds; aspect ratio between 1:3 and 3:1
   *
   * Facebook:  minimum width 600px; .mp4 or .mov w/ h.264; max 30 fps; up to 240 mins, up to 4 gb
   *
   * Linkedin:  between 10 and 60 fps; aspect ratio 1:2.4 or 2.4:1; dimensions between 256×144 and
   *            4096×2304; size between 75kb and 5gb; duration between 3 secs and 10 mins; video
   *            AVI, MPEG-1, MPEG-4, MKV, QuickTime, WebM, H264/AVC, MP4, VP8, VP9, WMV2, and WMV3;
   *            audio AAC, MP3, and Vorbis
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
      throw new EnumException( Text::_('COM_CAJOBBOARD_EXCEPTION_ENUM_VIDEO_OBJECT_ASPECT_RATIOS_INVALID_CONSTANT') );
    }

    switch ($aspect)
    {
      case 'ANAMORPHIC_PORTRAIT':
        $metadata = array('widthAspect' => 9,  'heightAspect' => 21, 'aspectRatio' => 9 / 21, 'channel' => array('Facebook') );
        break;

      case 'CAROUSEL':
        $metadata = array('widthAspect' => 1,  'heightAspect' => 1,  'aspectRatio' => 1 / 1, 'channel' => array('Facebook', 'Instagram', 'Twitter') );
        break;

      case 'MEDIUM_PORTRAIT':
        $metadata = array('widthAspect' => 4,  'heightAspect' => 5,  'aspectRatio' => 4 / 5, 'channel' => array('Facebook', 'Instagram') );
        break;

      case 'STANDARD_LANDSCAPE':
        $metadata = array('widthAspect' => 4,  'heightAspect' => 3,  'aspectRatio' => 4 / 3, 'channel' => array('Youtube') );
        break;

      case 'STANDARD_PORTRAIT':
        $metadata = array('widthAspect' => 3,  'heightAspect' => 4,  'aspectRatio' => 3 / 4, 'channel' => array('Youtube') );
        break;

      case 'WIDE_LANDSCAPE':
        $metadata = array('widthAspect' => 16, 'heightAspect' => 9,  'aspectRatio' => 16 / 9, 'channel' => array('Youtube', 'Facebook', 'Instagram') );
        break;

      case 'WIDE_PORTRAIT':
        $metadata = array('widthAspect' => 9,  'heightAspect' => 16, 'aspectRatio' => 9 / 16, 'channel' => array('Facebook') );
        break;

      case 'OTHER':
        $metadata = array('widthAspect' => 0,  'heightAspect' => 0, 'aspectRatio' => 0, 'channel' => array() );
    }

    if ( !array_key_exists($property, $metadata) )
    {
      throw new EnumException( Text::_('COM_CAJOBBOARD_EXCEPTION_ENUM_VIDEO_OBJECT_ASPECT_RATIOS_INVALID_METADATA_PROPERTY') );
    }

    return $metadata[$property];
  }
}
