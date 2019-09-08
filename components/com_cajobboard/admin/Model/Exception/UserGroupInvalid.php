<?php
/**
 * Exception class for errors saving a user, using Joomla!'s core routines
 *
 * @package   Calligraphic Job Board
 * @version   July 14, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * See \Calligraphic\Cajobboard\Admin\DispatcherDispatcher for exception handling logic
 */

namespace Calligraphic\Cajobboard\Admin\Model\Exception;

use \Joomla\CMS\Language\Text;
use \Calligraphic\Cajobboard\Admin\Model\Exception\InvalidField;

// no direct access
defined('_JEXEC') or die;

class UserGroupInvalid extends \RuntimeException
{
	public function __construct($message = "", $code = 500, Exception $previous = null)
	{
		if (empty($message))
		{
			$message = Text::_('COM_CAJOBBOARD_EXCEPTION_USER_GROUP_NOT_FOUND_DEFAULT_MSSG');
    }

		parent::__construct($message, $code, $previous);
	}
}
