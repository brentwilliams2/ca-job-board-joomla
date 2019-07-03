<?php
/**
 * Invalid Argument exception, extended with translated message
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\View\Exception;

use Exception;

// no direct access
defined('_JEXEC') or die;

/**
 * Exception thrown when we get an argument of the wrong type
 */
class InvalidArgument extends \InvalidArgumentException
{
	public function __construct($path, $code = 500, Exception $previous = null)
	{
    $message = \JText::sprintf('COM_CAJOBBOARD_VIEW_EXCEPTION_INVALID_ARGUMENT', $path);

		parent::__construct($message, $code, $previous);
	}
}
