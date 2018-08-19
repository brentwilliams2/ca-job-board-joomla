<?php
/**
 * Administrator Person Controller
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


// no direct access
defined('_JEXEC') or die;

class Person extends DataController
{
	/*
	 * Overridden. Limit the tasks we're allowed to execute.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    $this->modelName = 'Persons';

    $this->predefinedTaskList = ['browse', 'read', 'edit', 'save'];

    parent::__construct($container, $config);
  }

	/*
	 * Override browse task.
	 */
	protected function browse()
	{
  }

	/*
	 * Override read task.
	 */
	protected function read()
	{
  }

  /*
   * Override edit task.
   */
	protected function edit()
	{
    $user_id = $this->input->getInt('user_id', 0);

		// @TODO Call core com_users routine to save a user, and call plugin tasks
	}

	/*
	 * Override save task. Saves the incoming data and then returns to the Browse task.
	 *
	 * @return bool
	 */
	protected function save()
	{
    $user_id = $this->input->getInt('user_id', 0);

		// @TODO Call core com_users routine to save a user, and call plugin tasks
  }
}




