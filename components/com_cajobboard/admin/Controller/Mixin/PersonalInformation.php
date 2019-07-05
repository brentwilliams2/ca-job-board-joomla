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

// no direct access
defined('_JEXEC') or die;

trait PersonalInformation
{
  // @TODO: Need to decide exactly where PII access control will be handled. We have a behaviour for models,
  //        and also can use it per-field in view emplates.

	/**
	 * Runs before executing a task in the controller
	 *
	 * @param   string  $task  The task to execute
	 *
	 * @return  bool
	 */
	public function onBeforeExecute($task)
	{
		/** @var Container $container */
    $container = $this->container;

		/** @var \JUser $user */
    $user = $container->platform->getUser();

		if (!$user->authorise('cajobboards.pii', 'com_cajobboard'))
		{
			throw new \RuntimeException(\JText::_('COM_CAJOBBOARD_COMMON_NO_ACL_PII'), 403);
		}
		return true;
	}
}
