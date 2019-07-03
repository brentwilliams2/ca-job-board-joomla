<?php
/**
 * Exception class for empty form field that is NOT NULL with no default in database table
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model\Exception;

use \Joomla\CMS\Language\Text;
use \Calligraphic\Cajobboard\Admin\Model\Exception\InvalidFieldException;

// no direct access
defined('_JEXEC') or die;

/**
 * Exception thrown when attempting to save a NOT NULL field without a default value
 */
class EmptyFieldException extends InvalidFieldException
{
	public function __construct($message = "", $code = 500, Exception $previous = null)
	{
		if (empty($message))
		{
			$message = Text::_('COM_CAJOBBOARD_NOT_NULL_MODEL_FIELD_EMPTY_EXCEPTION_DEFAULT_MSSG');
    }

		parent::__construct($message, $code, $previous);
	}
}
