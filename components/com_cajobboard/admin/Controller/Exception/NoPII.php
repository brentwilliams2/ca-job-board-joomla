<?php
/**
 * Exception thrown when user does not have permission to access personally identifying information
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
 * Exception thrown when user does not have permission to access personally identifying information
 */
class NoPII extends \RuntimeException
{
	public function __construct($message = "", $code = 500, Exception $previous = null)
	{
		if (empty($message))
		{
      $message = Text::_('COM_CAJOBBOARD_EXCEPTION_COMMON_NO_ACL_PII');
    }

		parent::__construct($message, $code, $previous);
	}
}
