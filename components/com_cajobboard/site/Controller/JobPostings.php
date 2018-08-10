<?php
/**
 * Site Job Posting Model
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Controller;

// Framework classes
use FOF30\Container\Container;
use FOF30\Controller\DataController;
use FOF30\View\Exception\AccessForbidden;

// Component classes
use Calligraphic\Cajobboard\Admin\Controller\Mixin;

// no direct access
defined('_JEXEC') or die;

class JobPostings extends DataController
{
	/**
	 * Overridden. Limit the tasks we're allowed to execute.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);

    $this->predefinedTaskList = ['browse', 'read', 'save', 'apply'];

		// $this->cacheableTasks = ['read', 'browse'];
  }

	/**
	 * Runs before the browse task.
	 */
	protected function onBeforeBrowse()
	{
		// Determine if user logged in
    $user = $this->container->platform->getUser();

		// If we have a guest user, guess their location
		if ($user->guest)
		{
      // @TODO: geolocation code
    }

    // Do something special if a privileged user
    // $jobPostingsModel = $this->getModel();

		// Does the user have core.manage access?
    $isAdmin = $user->authorise('core.manage', 'com_cajobboard');

		if ($isAdmin)
		{
			// $jobPostingsModel->user_id(null);
		}
		else
		{
			//$jobPostingsModel->user_id($user->id);
    }
  }

	/**
	 * Runs before the read task.
	 */
	protected function onBeforeRead()
	{
    // @TODO:
  }

	/**
	 * Performs auth checks before saving subscription data
	 *
	 * @return bool
	 */
	protected function onBeforeSave()
	{
    $user = $this->container->platform->getUser();

		// Guest user, go away!
		if ($user->guest)
		{
			return false;
		}

		return true;
  }

  /**
	 * Performs auth checks before saving subscription data
	 *
	 * @return bool
	 */
	public function save()
	{
		// CSRF prevention
		if ($this->csrfProtection)
		{
			$this->csrfProtection();
    }

    // how to redirect:
		// $this->setRedirect(\JRoute::_('index.php?option=com_akeebasubs&view=Subscription&id=' . $subId, false), $msg, $msgType);
  }

	/**
	 * Registers page-identifying parameters to the application object. This is used by the Joomla! caching system to
	 * get the unique identifier of a page and decide its caching status (cached, not cached, cache expired).
	 *
	 * @param array $urlparams
	 */
	protected function registerUrlParams($urlparams = array())
	{
    // Called from onBeforeRead task in akeeba Subscriptions controller
    $app = \JFactory::getApplication();

    $registeredurlparams = null;

		if (!empty($app->registeredurlparams))
		{
			$registeredurlparams = $app->registeredurlparams;
		}
		else
		{
			$registeredurlparams = new \stdClass;
    }

		foreach ($urlparams as $key => $value)
		{
			// Add your safe url parameters with variable type as value {@see JFilterInput::clean()}.
			$registeredurlparams->$key = $value;
    }

		$app->registeredurlparams = $registeredurlparams;
	}
}
