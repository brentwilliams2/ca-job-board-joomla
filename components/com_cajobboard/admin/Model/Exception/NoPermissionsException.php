<?php
/**
 * No Permissions exception class
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model\Exception;

// no direct access
defined('_JEXEC') or die;

/**
 * Exception thrown when the user doesn't have permission to perform a model action
 */
class NoPermissionsException extends \RuntimeException
{
	public function __construct($message = "", $code = 403, Exception $previous = null)
	{
		if (empty($message))
		{
			$message = \JText::_('COM_CAJOBBOARD_EXCEPTION_NO_PERMS');
		}
		parent::__construct($message, $code, $previous);
	}
}
