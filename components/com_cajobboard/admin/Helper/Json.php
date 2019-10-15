<?php
/**
 * Helper class for JSON
 *
 * @package   Calligraphic Job Board
 * @version   June 1, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design, Copyright (C) 2005 - 2019 Open Source Matters, Inc.
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Helper;

// no direct access
defined('_JEXEC') or die;

/**
 * Utility class for handling JSON
 *
 * @since  0.0.1
 */
abstract class Json
{
  // @TODO: used in Cli/Seeder/PopulateSampleData.php, but not \Admin\Model\Mixin\JsonData, where else are we handling JSON?
  /**
   * Since PHP has poor handling for JSON errors on decode, this utility gives a more human-readable description of the error
   *
   * @return  string    A human-readable description of the JSON decode error
   */
  public static function getJsonErrorDesc()
  {
    switch (json_last_error()) {

      case JSON_ERROR_NONE:
        return 'No errors';
        break;

      case JSON_ERROR_DEPTH:
        return 'Maximum stack depth exceeded';
        break;

      case JSON_ERROR_STATE_MISMATCH:
        return 'Underflow or the modes mismatch';
        break;

      case JSON_ERROR_CTRL_CHAR:
        return 'Unexpected control character found';
        break;

      case JSON_ERROR_SYNTAX:
        return 'Syntax error, malformed JSON';
        break;

      case JSON_ERROR_UTF8:
        return 'Malformed UTF-8 characters, possibly incorrectly encoded';
        break;

      default:
        return 'Unknown error';
        break;
    }
  }
}
