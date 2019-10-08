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

class Person extends BaseController
{
	/*
	 * Overridden. Limit the tasks that are allowed to execute.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);

    $this->setModelName('Persons');

		// $this->resetPredefinedTaskList();

    $this->addPredefinedTaskList(array(
      'activate',
      'unactivate',
      'block',
      'unblock'
    ));
  }


  /**
	 * Activate the selected user(s)
	 *
	 * @return  void
	 */
  public function activate()
  {
    $this->setFieldOnModels('activation', true);
  }


  /**
   * Unactivate the selected user(s)
   *
   * @return  void
   */
  public function unactivate()
  {
    $this->setFieldOnModels('activation', false);
  }


  /**
	 * Block the selected user(s)
	 *
	 * @return  void
	 */
  public function block()
  {
    $this->setFieldOnModels('block', true);
  }


  /**
   * Unblock the selected user(s)
   *
   * @return  void
   */
  public function unblock()
  {
    $this->setFieldOnModels('block', false);
  }
}
