<?php
/**
 * References Site Controller
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

 namespace Calligraphic\Cajobboard\Site\Controller;

// no direct access
defined('_JEXEC') or die;

use \FOF30\Container\Container;
use \Calligraphic\Cajobboard\Site\Controller\BaseController;

class Reference extends BaseController
{
	/*
	 * Overridden. Limit the tasks that are allowed to execute.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    $this->modelName = 'References';

		// $this->resetPredefinedTaskList();

		$this->addPredefinedTaskList(array(
      'sendReferenceRequest'
		));

    parent::__construct($container, $config);
  }


  /**
	 * Send a reference request,
	 */
  public function sendReferenceRequest($request)
  {
    /*
      @TODO: needs a state flag field for whether a request was sent and not received yet, then updated when
             received - an enabled flag, like "3" for "pending"?
    */
  }


  /**
	 *
	 */
  public function buildUrlQuery($object)
  {
    /*
      @TODO: Use a URL that has the username embedded as a query string to give to former employers as a link
            to create a review, so the form doesn't have to deal with selecting the user.
            Make sure the correct link is sent through the email system.
    */
  }
}
