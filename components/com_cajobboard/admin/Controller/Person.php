<?php
/**
 * Persons Admin Controller
 *
 * @package   Calligraphic Job Board
 * @version   July 5, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

 namespace Calligraphic\Cajobboard\Admin\Controller;

// no direct access
defined('_JEXEC') or die;

use \FOF30\Container\Container;
use \Calligraphic\Cajobboard\Admin\Controller\BaseController;

class  Person extends BaseController
{
  /* Traits to include in the class */

  use Mixin\ToggleField;          // Method to toggle boolean state fields
  use Mixin\Redirect;             // Utilities for handling redirects in controller classes
  use Mixin\PredefinedTaskList;   // Overrides execute() to provide predefined tasks

	/*
	 * Overridden. Limit the tasks that are allowed to execute.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    $this->modelName = 'Persons';

    $this->addPredefinedTaskList(array(
      'activate',
      'unactivate',
      'block',
      'unblock'
    ));

    parent::__construct($container, $config);
  }


  /**
	 * Activate the selected user(s)
	 *
	 * @return  void
	 */
  public function activate()
  {
    $this->toggleField('activation', true);
  }


  /**
   * Unactivate the selected user(s)
   *
   * @return  void
   */
  public function unactivate()
  {
    $this->toggleField('activation', false);
  }


  /**
	 * Block the selected user(s)
	 *
	 * @return  void
	 */
  public function block()
  {
    $this->toggleField('block', true);
  }


  /**
   * Unblock the selected user(s)
   *
   * @return  void
   */
  public function unblock()
  {
    $this->toggleField('block', false);
  }
}
