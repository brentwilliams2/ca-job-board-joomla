<?php
/**
 * Exception class for empty form field that is NOT NULL with no default in database table
 *
 * @package   Calligraphic Job Board
 * @version   July 2, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * See \Calligraphic\Cajobboard\Admin\DispatcherDispatcher for exception handling logic
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model\Exception;

use \Joomla\CMS\Language\Text;
use \Calligraphic\Cajobboard\Admin\Model\Exception\InvalidField;

// no direct access
defined('_JEXEC') or die;

/**
 * Exception thrown when attempting to save a NOT NULL field without a default value
 */
class EmailNoSendByUser extends InvalidField
{
	public function __construct($message = "", $code = 500, Exception $previous = null)
	{
		if (empty($message))
		{
			$message = Text::_('COM_CAJOBBOARD_EXCEPTION_EMAIL_NO_SEND_BY_USER_DEFAULT_MSSG');
    }

		parent::__construct($message, $code, $previous);
	}
}
