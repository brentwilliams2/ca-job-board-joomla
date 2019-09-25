<?php
/**
 * Predefined Tasks List Controller Mixin
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Controller\Mixin;

use \Joomla\CMS\Language\Text;
use \Calligraphic\Cajobboard\Admin\Controller\Exception\TaskNotAllowed;

// no direct access
defined('_JEXEC') or die;

/**
 * Force a Controller to allow access to specific tasks only, no matter which tasks are already defined in this
 * Controller.
 */
trait PredefinedTaskList
{
	/**
	 * A list of predefined tasks. Trying to access any other task will result in the first task of this list being
	 * executed instead.
	 *
	 * @var array
	 */
  protected $predefinedTaskList = array();


	/**
	 * Overrides the execute method to implement the predefined task list feature
	 *
	 * @param   string  $task  The task to execute
	 *
	 * @return  mixed  The controller task result
	 */
	public function execute($task)
	{
    // Make sure the task is in the predefined list set on the controller
		if (!in_array($task, $this->predefinedTaskList) && $task != 'default')
		{
      throw new TaskNotAllowed( Text::sprintf( 'COM_CAJOBBOARD_EXCEPTION_TASK_NOT_IN_LIST', $task ) );
    }

		return parent::execute($task);
  }


	/**
	 * Sets the predefined task list and registers the first task in the list as the Controller's
   * default task. Merges tasks from each call so that child Controller classes can simply add
   * tasks to a default set, call resetPredefinedTaskList() to start fresh in child classes
   *
	 * @param   array  $taskList  The task list to register
	 */
	public function addPredefinedTaskList(array $taskList)
	{
    // merge existing tasks with new tasks
    $tasks = array_merge($this->predefinedTaskList, $taskList);

		// First, unregister all known tasks which are not in the taskList
    $allTasks = $this->getTasks();

		foreach ($allTasks as $task)
		{
			if (in_array($task, $tasks))
			{
				continue;
      }

			$this->unregisterTask($task);
    }

		// Set the predefined task list
    $this->predefinedTaskList = $tasks;

		// Set the default task
		$this->registerDefaultTask(reset($this->predefinedTaskList));
  }


	/**
	 * Reset the predefined task list
	 */
	public function resetPredefinedTaskList()
	{
    $this->predefinedTaskList = array();
  }
}

