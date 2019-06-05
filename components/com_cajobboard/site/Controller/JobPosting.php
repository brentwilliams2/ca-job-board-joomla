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
use Calligraphic\Cajobboard\Site\Controller\BaseController;

// no direct access
defined('_JEXEC') or die;

class JobPosting extends BaseController
{
	/**
	* Overridden. Limit the tasks we're allowed to execute.
	*
	* @param   Container $container
	* @param   array     $config
	*/
	public function __construct(Container $container, array $config = array())
	{
    $this->modelName = 'JobPostings';

    $this->predefinedTaskList = ['browse', 'read', 'edit', 'add', 'save', 'remove'];

    parent::__construct($container, $config);
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
	* Send a job to user's email
	*
	* @return  bool
	*/
	public function sendJobToEmail()
	{
    // @TODO: send the job to email

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

		return true;
  }
}
