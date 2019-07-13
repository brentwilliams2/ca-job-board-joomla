<?php
/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
namespace Calligraphic\Cajobboard\Admin\Model\Mixin;

use \Joomla\Registry\Registry;

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
   * @param   string    $json   A JSON-encoded string
	 *
	 * @return  Registry  Returns a Registry object holding the JSON-encoded data
	 */
  protected function transformJsonToRegistry($json)
  {
    // Make sure it's not a JRegistry already
    if (is_object($json) && ($json instanceof Registry))
    {
        return $json;
    }

    return new Registry($json, 'JSON');
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
}
