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
	 * @param   string  $method  The task to execute
	 *
	 * @return  mixed  The controller task result
	 */
	public function execute($method)
	{
    // Make sure the task is in the predefined list set on the controller
		if (!in_array($method, $this->predefinedTaskList) && $method != 'default')
		{
      throw new TaskNotAllowed( Text::sprintf( 'COM_CAJOBBOARD_EXCEPTION_TASK_NOT_IN_LIST', $method ) );
    }

		return parent::execute($method);
  }


	/**
	 * Sets the predefined task list and registers the first task in the list as the Controller's
   * default task. Merges tasks from each call so that child Controller classes can simply add
   * tasks to a default set, call resetPredefinedTaskList() to start fresh in child classes
   *
	 * @param   array  $methodList  The task list to register.
	 */
	protected function addPredefinedTaskList(array $predefinedTaskList)
	{
		// Sanity check
		if ( empty($predefinedTaskList) )
		{
			return;
		}

		/** @var 	array 	$publicMethodList 	The taskList is built using reflection of all public methods in the Controller constructor, with the method name as the array values. */
		$publicMethodList = $this->getTasks();

		// Ensure each predefined task name has a similar controller method available.
		// Skip for 'default' as Controller has special handling for default case.
		foreach ($predefinedTaskList as $predefinedTask)
		{
			if ( !in_array($predefinedTask, $publicMethodList) && $predefinedTask != 'default' )
			{
				throw new \Exception(
					Text::sprintf(
						'Logic error in PredefinedTaskList: the %s task is in the predefined task list, but has no associated controller public method. For site controller class %s.',
						$predefinedTask,
						$this->getName()
					)
				);
			}
		}

		// merge existing tasks with new tasks
		$this->predefinedTaskList = array_merge($this->predefinedTaskList, $predefinedTaskList);
  }


	/**
	 * Reset the predefined task list
	 */
	protected function resetPredefinedTaskList()
	{
    $this->predefinedTaskList = array();
	}
}
