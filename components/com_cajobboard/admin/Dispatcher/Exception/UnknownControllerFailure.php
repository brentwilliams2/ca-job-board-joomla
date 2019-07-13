<?php
/**
 * Exception class for controller class returning false (error status) to dispatcher
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * See \Calligraphic\Cajobboard\Admin\DispatcherDispatcher for exception handling logic
 *
 */

namespace Calligraphic\Cajobboard\Admin\Dispatcher\Exception;

use \Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;

/**
 * Exception thrown when the page cannot be found
 */
class UnknownControllerFailure extends \RuntimeException
{
	public function __construct( $message = "", $code = 500, Exception $previous = null )
	{
		parent::__construct( Text::_('COM_CAJOBBOARD_EXCEPTION_GENERIC'), '500', $previous );
	}
}
