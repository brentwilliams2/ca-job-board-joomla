<?php
/**
 * Siteistrator Control Panel Controller
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
use \FOF30\Container\Container;
use \FOF30\Controller\Controller;

// no direct access
defined('_JEXEC') or die;

class ControlPanel extends Controller
{
  use \Calligraphic\Cajobboard\Site\Controller\Mixin\PredefinedTaskList;

	/*
	 * Overridden. Limit the tasks that are allowed to execute.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
		parent::__construct($container, $config);

    $this->setModelName('ControlPanels');

    $this->addPredefinedTaskList(array(

		));
  }
}
