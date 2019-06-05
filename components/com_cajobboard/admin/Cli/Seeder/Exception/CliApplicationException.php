<?php
/**
 * Exception class for cli script to populate sample data using FOF "ORM"
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Cli\Seeder\Exception;

// no direct access
defined('_JEXEC') or die;

/**
 * Define a custom exception class
 */
class CliApplicationException extends \Exception
{
  // Redefine the exception so message isn't optional
  public function __construct($message, $code = 0, Exception $previous = null) {
    parent::__construct($message, $code, $previous);
  }
}
