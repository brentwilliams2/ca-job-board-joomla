<?php
/**
 * Answers Admin Base Class for Controllers
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Controller;

// Framework classes
use \FOF30\Container\Container;
use \FOF30\Controller\DataController;

// no direct access
defined('_JEXEC') or die;

class BaseController extends DataController
{
  use \Calligraphic\Cajobboard\Admin\Controller\Mixin\Redirect;             // Utilities for handling redirects in controller classes
  use \Calligraphic\Cajobboard\Admin\Controller\Mixin\PredefinedTaskList;   // Overrides execute() to provide predefined tasks
  use \Calligraphic\Cajobboard\Admin\Controller\Mixin\SetFieldOnModels;     // Method to handle XHR or Joomla! admin button bulk updates to a model property, e.g. 'upvote_count'

	/*
	 * Overridden. Limit the tasks we're allowed to execute.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);

    $this->addPredefinedTaskList( array(
      'add',
      'apply',
      'archive',
      'browse',
      'cancel',
      'edit',
      'feature',
      'publish',
      'read',
      'remove',
      'save',
      'savenew',
      'trash',
      'unfeature',
      'unpublish'
    ));
  }
}
