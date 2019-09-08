<?php
/**
 * Answers Site Base Class for Controllers
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
use \Calligraphic\Library\Platform\DataController;

// no direct access
defined('_JEXEC') or die;

// @TODO: extend from FOF30 DataController when debugging no longer needed

class BaseController extends DataController
{
  use \Calligraphic\Cajobboard\Admin\Controller\Mixin\Permissions;
  use \Calligraphic\Cajobboard\Admin\Controller\Mixin\Redirect;

  // Overrides execute() to provide predefined tasks
  use \Calligraphic\Cajobboard\Admin\Controller\Mixin\PredefinedTaskList;

	/*
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);
  }
}
