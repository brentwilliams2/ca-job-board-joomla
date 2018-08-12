<?php
/**
 * Administrator Job Posting Controller
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Controller;

// Framework classes
use FOF30\Container\Container;
use FOF30\Controller\DataController;
use FOF30\View\Exception\AccessForbidden;

// Component classes
use Calligraphic\Cajobboard\Admin\Model\Users;

// no direct access
defined('_JEXEC') or die;

class JobPosting extends DataController
{
	/*
	 * Overridden. Limit the tasks we're allowed to execute.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);
  }

	/*
	 * Runs before the browse task.
	 */
	protected function onBeforeBrowse()
	{
  }

	/*
	 * Runs before the read task.
	 */
	protected function onBeforeRead()
	{
  }

  /*
   *
   */
	protected function onBeforeEdit()
	{
    $user_id = $this->input->getInt('user_id', 0);

		// Try to load a User record based on the Joomla! user ID
		if ($user_id)
		{
			/** @var Users $model */
      $model = $this->getModel()->savestate(false);

      $item = $model->user_id($user_id)->firstOrNew();

      $model->bind($item->getData());

			// If the User record was not found, ???
			if (!$model->getId())
			{
        $url = 'index.php?option=com_cajobboard&view=User';
        $this->setRedirect($url);
				$this->redirect();
			}
		}
	}

	/*
	 * Performs auth checks before saving subscription data
	 *
	 * @return bool
	 */
	protected function onBeforeSave()
	{
  }
}




