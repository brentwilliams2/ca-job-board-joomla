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
  use \Calligraphic\Cajobboard\Admin\Controller\Mixin\ToggleField;          // Method to toggle boolean state fields
  use \Calligraphic\Cajobboard\Admin\Controller\Mixin\Redirect;             // Utilities for handling redirects in controller classes
  use \Calligraphic\Cajobboard\Admin\Controller\Mixin\PredefinedTaskList;   // Overrides execute() to provide predefined tasks

	/*
	 * Overridden. Limit the tasks we're allowed to execute.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
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

    parent::__construct($container, $config);
  }


  /**
	 * Set featured status to
	 *
	 * @return  void
	 */
  public function feature()
  {
    $this->toggleField('featured', true);
  }


  /**
   * Unactivate the selected user(s)
   *
   * @return  void
   */
  public function unfeature()
  {
    $this->toggleField('featured', false);
  }
}
