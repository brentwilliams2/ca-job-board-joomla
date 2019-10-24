<?php
/**
 * @package   Calligraphic Job Board
 * @version   May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
namespace Calligraphic\Cajobboard\Admin\Model\Mixin;

use \Calligraphic\Library\Platform\Registry;

// no direct access
defined( '_JEXEC' ) or die;

/**
 * Trait for dealing with data stored as JSON-encoded strings
 */
trait JsonData
{
  /**
	 * Transform JSON to a JRegistry object
   *
   * @param   Registry|string    $json      A JSON-encoded string or Registry object
   * @param   string             $default   Default values in an array, object, or JSON-encoded string
	 *
	 * @return  Registry  Returns a Registry object holding the JSON-encoded data
	 */
  protected function transformJsonToRegistry($json, $default = '{}')
  {
    if ( !is_object($json) && !($json instanceof Registry) )
    {
        $registry = new Registry($default, 'JSON');

        $registry->loadString($json, 'JSON');

        return $registry;
    }

    return $json;
  }


  /**
	 * Transform a JRegistry object to a JSON string
   *
   * @param  Registry|mixed   $registry   A Registry object to transform to a JSON string. Any other value is returned cast to string.
	 *
	 * @return  string  Returns a JSON string of the Registry object
	 */
  protected function transformRegistryToJson($registry)
  {
    // Make sure it a JRegistry object, otherwise return the value
    if ( !($registry instanceof Registry) )
    {
      return (string) $registry;
    }

    // Return the data transformed to JSON
    return $registry->toString('JSON');
  }


  /**
	 * Transform Array to a JRegistry object
   *
   * @param   array     $data      An associative array to convert to JSON
   * @param   string    $default   Default values in an array, object, or JSON-encoded string
	 *
	 * @return  Registry  Returns a JSON string of the array
	 */
  protected function transformArrayToJson(array $data, $default = null)
  {
    if (!$json)
    {
      return json_encode($default, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    return json_encode($json, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
  }
}


/* @TODO: JSON error handling

PHP 7.1:

  json_decode("{");

  json_last_error() === JSON_ERROR_NONE // the result is false

  json_last_error_msg() // The result is "Syntax error"

PHP 7.2:

  use JsonException;

  try
  {
      $json = json_encode("{", JSON_THROW_ON_ERROR);

      return base64_encode($json);
  }
  catch (JsonException $e)
  {
      throw new EncryptException('Could not encrypt the data.', 0, $e);
  }

*/
