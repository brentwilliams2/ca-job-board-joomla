<?php
/**
 * Site Job Posting Controller
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
use JLog;

// Component classes
use Calligraphic\Cajobboard\Admin\Controller\Mixin;

// no direct access
defined('_JEXEC') or die;

class JobPosting extends DataController
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
  }

  /**
   * Override default browse task (list view) to remove functionality calling XML forms
   *
   * @return  void
   */
  public function browse()
  {
		// Determine if user logged in
    $user = $this->container->platform->getUser();

		// If we have a guest user, guess their location
		if ($user->guest)
		{
      // @TODO: geolocation code
    }

		// Does the user have core.manage access?
    //$isAdmin = $user->authorise('core.manage', 'com_cajobboard');

    // Do something special if a privileged user
		//if ($isAdmin)

    if (empty($this->layout))
    {
      $this->layout = 'default';
    }

    // Display the view
    $this->display(in_array('browse', $this->cacheableTasks), $this->cacheParams);
  }

	/**
	 * Single record read. The id set in the request is passed to the model and
	 * then the item layout is used to render the result.
	 *
	 * @return  void
	 *
	 * @throws ItemNotFound When the item is not found
	 */
	public function read()
	{
		// Load the model
		/** @var DataModel $model */
		$model = $this->getModel()->savestate(false);

		// If there is no record loaded, try loading a record based on the id passed in the input object
		if (!$model->getId())
		{
			$ids = $this->getIDsFromRequest($model, true);

			if ($model->getId() != reset($ids))
			{
				$key = strtoupper($this->container->componentName . '_ERR_' . $model->getName() . '_NOTFOUND');
				throw new ItemNotFound(\JText::_($key), 404);
			}
		}

		// Set the layout to item, if it's not set in the URL
		if (empty($this->layout))
		{
			$this->layout = 'item';
		}
		elseif ($this->layout == 'default')
		{
			$this->layout = 'item';
		}

		// Display the view
		$this->display(in_array('read', $this->cacheableTasks), $this->cacheParams);
	}

  /**
	 *
	 * @return  bool
	 */
	public function onBeforeAdd()
	{
    // @TODO: redirect guest users before they see an add form

		return true;
  }

	/**
	* Save a job for a user
	*
	* @return  bool
	*/
	public function saveJob()
	{
    // @TODO: save job id to save join table (saved jobs)

    /* Return something like this:
      {
        "status": "error", // or "success"
        "message": "Job doesn't exist"
      }
    */
    JLog::add('JobPosting controller, saveJob() method called', JLog::DEBUG, 'cajobboard');

		return true;
  }


	/**
	* Send a job to user's email
	*
	* @return  bool
	*/
	public function sendJobToEmail()
	{
    // @TODO: send the job to email

    /* Return something like this:
      {
        "status": "error", // or "success"
        "message": "Job doesn't exist"
      }
    */
    JLog::add('JobPosting controller, sendJobToEmail() method called', JLog::DEBUG, 'cajobboard');

		return true;
  }


	/**
	* Report a job for TOS violations
	*
	* @return  bool
	*/
	public function reportJob()
	{
    // @TODO: message administrators of the report

    /* Return something like this:
      {
        "status": "error", // or "success"
        "message": "Job doesn't exist"
      }
    */
    JLog::add('JobPosting controller, reportJob() method called', JLog::DEBUG, 'cajobboard');

		return true;
  }


	/**
	* Runs before executing a task in the controller, overriden to keep from ACL check
  * with no area set. Seems like bug inController triggerEvent() method
	*
	* @param   string  $task  The task to execute
	*
	* @return  bool
	*/
	public function onBeforeExecute($task)
	{
    // Do any ACL? This runs for *any* task, even public ones
		return true;
  }

	/**
	* Runs before executing a task in the controller, overriden to keep from ACL check
  * with no area set. Seems like bug inController triggerEvent() method
	*
	* @param   string  $task  The task to execute
	*
	* @return  bool
	*/
	public function onBeforeRead()
	{
    // Do any ACL? This runs for *any* task, even public ones
    JLog::add('Job Posting Controller, onBeforeRead()', JLog::DEBUG, 'cajobboard');
		return true;
  }

	/**
	* Overriden to keep public views having ACL checks ran (should just use Joomla! access control).
	*
	* @param   string  $area  The task being checked for ACL
	*
	* @return  bool
	*/
  protected function checkACL($area)
  {
     return ($area == 'read') ? true : parent::checkACL($area);
  }
}
