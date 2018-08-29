<?php
/**
 * Admin Job Posting Model
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Repository;

// no direct access
defined('_JEXEC') or die;

use FOF30\Container\Container;
use FOF30\Model\DataModel;

/**
 * Class to implement repository for Job Posting model
 */
class JobPostingRepository extends DataModel
{
	/**
	 * Make sure $condition is true or throw a RuntimeException with the $message language string
	 *
	 * @param   bool    $condition  The condition which must be true
	 * @param   string  $message    The language key for the message to throw
	 *
	 * @throws  \RuntimeException
	 */
	protected function something($condition, $message)
	{

  }
}