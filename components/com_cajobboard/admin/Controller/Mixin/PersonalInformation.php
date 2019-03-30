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

// @TODO: Akeeba Subs usings the PII in the following controllers:
//
//  Subscription
//  SubscriptionStatistics
//  SubscriptionRefresh
//
//  Subscribe controller calls validators:
//  Subscribe/Validation/Price
//  Subscribe/Validation/PersonalInformation
//
//  User
//  Reports
//  Invoices

namespace Calligraphic\Cajobboard\Admin\Controller\Mixin;

use \FOF30\Container\Container;

// no direct access
defined('_JEXEC') or die;

trait PersonalInformation
{
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

		// Only apply the check in the backend. In the frontend I have different kinds of access control.
		if (!$container->platform->isBackend())
		{
			return true;
    }

		/** @var \JUser $user */
    $user = $container->platform->getUser();

    // @TODO: Need to add this ACL permission
		if (!$user->authorise('cajobboards.pii', 'com_cajobboard'))
		{
			throw new \RuntimeException(\JText::_('COM_CAJOBBOARD_COMMON_NO_ACL_PII'), 403);
		}
		return true;
	}
}
