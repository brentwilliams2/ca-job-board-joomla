<?php
/**
 * Exception class for no root record in a hierarchical table when new record created
 *
 * @package   Calligraphic Job Board
 * @version   October 16, 2019
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
 * Exception thrown when requesting a task that is not allowed for a controller
 */
class NoRootRecord extends \RuntimeException
{
	public function __construct($message = "", $code = 500, Exception $previous = null)
	{
		if (empty($message))
		{
      $message = Text::_('COM_CAJOBBOARD_EXCEPTION_NO_ROOT_RECORD_DEFAULT');
    }

		parent::__construct($message, $code, $previous);
	}
}