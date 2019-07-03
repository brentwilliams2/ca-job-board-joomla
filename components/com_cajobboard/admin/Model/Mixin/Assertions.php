<?php
/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model\Mixin;

// no direct access
defined('_JEXEC') or die;

use \Joomla\CMS\Language\Text;

/**
 * Trait for check() method assertions
 */
trait Assertions
{
	/**
	 * Make sure $condition is true or throw a RuntimeException with the $message language string
	 *
	 * @param   bool    $condition  The condition which must be true
	 * @param   string  $message    The language key for the message to throw
	 *
	 * @throws  \RuntimeException
	 */
	protected function assert($condition, $message)
	{
		if (!$condition)
		{
			throw new \RuntimeException(Text::_($message));
		}
  }

	/**
	 * Assert that $value is not empty or throw a RuntimeException with the $message language string
	 *
	 * @param   mixed   $value    The value to check
	 * @param   string  $message  The language key for the message to throw
	 *
	 * @throws  \RuntimeException
	 */
	protected function assertNotEmpty($value, $message)
	{
		$this->assert(!empty($value), $message);
  }

	/**
	 * Assert that $value is set to one of $validValues or throw a RuntimeException with the $message language string
	 *
	 * @param   mixed   $value        The value to check
	 * @param   array   $validValues  An array of valid values for $value
	 * @param   string  $message      The language key for the message to throw
	 *
	 * @throws  \RuntimeException
	 */
	protected function assertInArray($value, array $validValues, $message)
	{
		$this->assert(in_array($value, $validValues), $message);
	}
}
