<?php
/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
namespace Calligraphic\Cajobboard\Admin\Model\Mixin;

// no direct access
defined( '_JEXEC' ) or die;

/**
 * Trait for dealing with data stored as JSON-encoded strings
 */
trait JsonData
{
	/**
	 * Converts the loaded JSON string into an array
	 *
	 * @param   string  $value  The JSON string
	 *
	 * @return  array  The data
	 */
	protected function getAttributeForJson($value)
	{
		if (is_array($value))
		{
			return $value;
    }

		if (empty($value))
		{
			return array();
    }

    $value = json_decode($value, true);

		if (empty($value))
		{
			return array();
    }

		return $value;
  }

	/**
	 * Converts an array into a JSON string
	 *
	 * @param   array  $value  The data
	 *
	 * @return  string  The JSON string
	 */
	protected function setAttributeForJson($value)
	{
		if (!is_array($value))
		{
			return $value;
    }

    $value = json_encode($value);

		return $value;
	}
}
