<?php
/**
 * Over-ridden Joomla! Framework Registry class
 *
 * @package   Calligraphic Job Board
 * @version   September 11, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Library\Platform;

defined('_JEXEC') or die;

/**
 * Registry class
 *
 * @since  1.0
 */
class Registry extends \Joomla\Registry\Registry implements \JsonSerializable, \ArrayAccess, \IteratorAggregate, \Countable
{
  /**
   * Returns whether or not data has been previously loaded into the registry
   *
   * @return boolean
   */
	public function isInitialized()
	{
    return $this->initialized;
  }
}