<?php
/**
 * Site Subscriptions Controller
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
use \Calligraphic\Cajobboard\Site\Controller\BaseController;
use \FOF30\Container\Container;

// no direct access
defined('_JEXEC') or die;

class Subscription extends BaseController
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

    $this->setModelName('Subscriptions');

		// $this->resetPredefinedTaskList();

		$this->addPredefinedTaskList(array(

		));
  }
}
