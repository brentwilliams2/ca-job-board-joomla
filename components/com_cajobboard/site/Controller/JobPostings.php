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
use JLog;

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
   * Override default browse task (list view) to remove functionality calling XML forms
   *
   * @return  void
   */
  public function browse()
  {
JLog::add('XYZ Site JobPostings controller called, in browse() method', JLog::DEBUG, 'cajobboard');

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
    //$isAdmin = $user->authorise('core.manage', 'com_cajobboard');

		if ($isAdmin)
		{
			// $jobPostingsModel->user_id(null);
		}
		else
		{
			//$jobPostingsModel->user_id($user->id);
    }

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
}
