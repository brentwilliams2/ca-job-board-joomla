<?php
/**
 * Access Forbidden dispatcher exception class
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
 * Exception thrown when the access to the requested resource is forbidden under the current execution context
 */
class AccessForbidden extends \RuntimeException
{
	public function __construct( $message = "", $code = 403, Exception $previous = null )
	{
		if (empty($message))
		{
			$message = Text::_('COM_CAJOBBOARD_EXCEPTION_ACCESS_FORBIDDEN');
		}
		parent::__construct( $message, $code, $previous );
	}
}
