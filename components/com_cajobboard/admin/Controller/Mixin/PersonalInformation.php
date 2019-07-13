<?php
/**
 * Admin Personally Identifiable Information (PII) ACL Controller Mixin
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Controller\Mixin;

use \FOF30\Container\Container;
use \Joomla\CMS\Language\Text;
use \Calligraphic\Cajobboard\Admin\Controller\Exception\FeatureToggleFailure;

// no direct access
defined('_JEXEC') or die;

trait PersonalInformation
{
  // PII access control is handled in the controller, with a behaviour for models,
  // and can be used per-field in view templates.

	/**
	 * Runs before executing a task in the controller
	 *
	 * @param   string  $task  The task to execute
	 *
	 * @return  bool
	 */
	public function onBeforeExecute($task)
	{
		/** @var \JUser $user */
    $user = $container->platform->getUser();

		if (!$user->authorise('cajobboards.pii', 'com_cajobboard'))
		{
			throw new \RuntimeException( Text::_('COM_CAJOBBOARD_EXCEPTION_COMMON_NO_ACL_PII'), 403 );
    }

		return true;
	}
}
