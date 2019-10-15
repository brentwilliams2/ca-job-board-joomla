<?php
/**
 * Generic exception class for invalid form field data. Extend to enable setting
 * user flash message and redirect in model Validation trait (mixin).
 *
 * @package   Calligraphic Job Board
 * @version   July 2, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * See \Calligraphic\Cajobboard\Admin\DispatcherDispatcher for exception handling logic
 */

namespace Calligraphic\Cajobboard\Admin\Model\Exception;

use \Calligraphic\Cajobboard\Admin\Model\Exception\InvalidField;
use \Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;

class CheckFieldMissing extends \InvalidField
{
	public function __construct($message = "", $code = 500, Exception $previous = null)
	{
		if (empty($message))
		{
			$message = Text::_('COM_CAJOBBOARD_EXCEPTION_MODEL_CHECK_FIELD_MISSING_DEFAULT_MSSG');
    }

		parent::__construct($message, $code, $previous);
	}
}
