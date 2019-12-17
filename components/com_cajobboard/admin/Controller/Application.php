<?php
/**
 * Administrator Application Controller
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
use \FOF30\Container\Container;
use \Calligraphic\Cajobboard\Admin\Controller\BaseController;

// no direct access
defined('_JEXEC') or die;

class Application extends BaseController
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

    $this->setModelName('Applications');

		// $this->resetPredefinedTaskList();

    $this->addPredefinedTaskList(array(

		));
  }
}
