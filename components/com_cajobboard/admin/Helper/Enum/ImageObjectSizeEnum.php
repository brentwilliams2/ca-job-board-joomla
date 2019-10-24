<?php
/**
 * Admin Image Objects Sizes Enumeration
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
 * ENUM class for system image object sizes. Each value corresponds to a directory
 * in Joomla!'s site /media/com_cajobboard/{enum name}/ folder
 */
abstract class ImageObjectSizeEnum extends BasicEnum
{
  const ORIGINAL = 'ORIGINAL';
  const THUMB = 'THUMB';
  const SMALL = 'SMALL';
  const MEDIUM = 'MEDIUM';
  const LARGE = 'LARGE';


  /**
   * Get available sizes as an array
   *
   * @return array   Returns an associative array of image object sizes and the name's numeric enum value
   */
  public static function getImageObjectSizesNamesAndValues()
  {
    return self::getConstants();
  }


  /**
   * Get the directory in Joomla!'s media/images/user_uploads directory where file resizes are stored
   *
   * @param   string  $size     The size name, e.g. 'THUMB'
   *
   * @return  mixed   The value for the size name
   */
  public static function getMetaProperty($size)
  {
    if ( !self::isValidConstant($size) )
    {
      throw new EnumException( Text::_('COM_CAJOBBOARD_EXCEPTION_ENUM_IMAGE_OBJECT_SIZE_INVALID_CONSTANT') );
    }

    switch ($size)
    {
      case 'ORIGINAL':
        return 'original';

      case 'THUMB':
        return 'thumb';

      case 'SMALL':
        return 'small';

      case 'MEDIUM':
        return 'medium';

      case 'LARGE':
        return 'large';
    }

    if ( !array_key_exists($property, $metadata) )
    {
      throw new EnumException( Text::_('COM_CAJOBBOARD_EXCEPTION_ENUM_VIDEO_OBJECT_ASPECT_RATIO_INVALID_METADATA_PROPERTY') );
    }

    return $metadata[$property];
  }
}
