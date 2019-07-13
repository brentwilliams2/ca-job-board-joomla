<?php
/**
 * Exception class for title fields that will be truncated in search engine results
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

use \Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;

class SearchEngineUnfriendlyTitleField extends \RuntimeException
{
	public function __construct($message = "", $code = 500, Exception $previous = null)
	{
		if (empty($message))
		{
			$message = Text::_('COM_CAJOBBOARD_EXCEPTION_MODEL_FIELD_TITLE_IS_SEARCH_ENGINE_UNFRIENDLY_DEFAULT');
    }

		parent::__construct($message, $code, $previous);
	}
}
