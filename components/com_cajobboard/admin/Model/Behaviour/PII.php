<?php
/**
 * Model behaviour to restrict access for Personally Identifiable Information (PII)
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
namespace Calligraphic\Cajobboard\Admin\Model\Behaviour;

use \FOF30\Event\Observer;
use \FOF30\Model\DataModel;
use \Joomla\CMS\Application\ApplicationHelper;
use \Joomla\CMS\Language\Text;

// no direct access
defined( '_JEXEC' ) or die;

/**
 * FOF model behavior class to set the publish_up field on new items.
 */
class PII extends Observer
{
	/**
	 * Runs before executing a task in the controller
	 *
	 * @param   string  $task  The task to execute
	 *
	 * @return  bool
	 */
	public function onBeforeExecute(DataModel $model, $task)
	{
		/** @var Container $container */
    $container = $model->getContainer();

		// Only apply the check in the backend. In the frontend I have different kinds of access control.
		if (!$container->platform->isBackend())
		{
			return true;
    }

		/** @var \JUser $user */
    $user = $container->platform->getUser();

		if (!$user->authorise('cajobboard.pii', 'com_cajobboard'))
		{
			throw new \RuntimeException( Text::_('NO_ACL_PII_ERROR'), 403 );
    }

		return true;
	}
}
