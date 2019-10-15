<?php
/**
 * Exception class for items that do not have a default category and no category set on record data
 *
 * @package   Calligraphic Job Board
 * @version   October 9, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Model\Exception;

use \Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;

/**
 * Define a custom exception class
 */
class NoDefaultCategory extends \Exception
{
	public function __construct($message = "", $code = 500, Exception $previous = null)
	{
		if (empty($message))
		{
			$message = Text::_('COM_CAJOBBOARD_EXCEPTION_NO_DEFAULT_CATEGORY_DEFAULT_MSSG');
    }

		parent::__construct($message, $code, $previous);
	}
}
