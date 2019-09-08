<?php
/**
 * Exception class for failures attempting to toggle a field's status (true or false) on a model
 *
 * @package   Calligraphic Job Board
 * @version   July 5, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * See \Calligraphic\Cajobboard\Admin\DispatcherDispatcher for exception handling logic
 */

namespace Calligraphic\Cajobboard\Admin\Controller\Exception;

use \Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;

/**
 * Exception thrown on failures attempting to toggle a field's status (true or false) on a model
 */
class ToggleFailure extends \RuntimeException
{
	public function __construct($message = "", $code = 500, Exception $previous = null)
	{
		if (empty($message))
		{
      $message = Text::_('COM_CAJOBBOARD_EXCEPTION_TOGGLE_FAILURE');
    }

		parent::__construct($message, $code, $previous);
	}
}
