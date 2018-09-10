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

    $this->predefinedTaskList = ['browse', 'read'];
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
}
