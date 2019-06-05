<?php
/**
 * Answers Admin Base Class for Controllers
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
use \FOF30\Controller\DataController;
use \FOF30\View\Exception\AccessForbidden;

// no direct access
defined('_JEXEC') or die;

class BaseController extends DataController
{
  use Mixin\Feature;
  use Mixin\Redirect;

  // Overrides execute() to provide predefined tasks
  use Mixin\PredefinedTaskList;

	/*
	 * Overridden. Limit the tasks we're allowed to execute.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);

    $this->addPredefinedTaskList([
      'browse',  'read',  'edit', 'add',
      'apply',   'save',  'cancel', 'savenew',
      'archive', 'trash', 'remove',
      'feature', 'unfeature',
      'publish', 'unpublish'
    ]);
  }
}
