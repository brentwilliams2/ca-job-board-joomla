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
use \FOF30\Controller\DataController;
use \FOF30\View\Exception\AccessForbidden;

// no direct access
defined('_JEXEC') or die;

class BaseController extends DataController
{
  use \Calligraphic\Cajobboard\Admin\Controller\Mixin\Ordering;

	/*
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);
  }


  /**
	 * Override default DataModel ordering by primary key for browse views
	 *
	 * @return  void
	 */
  protected function onBeforeBrowse()
  {
    $this->setOrdering();
  }


  /**
	 * Override default DataModel ordering by primary key for browse views
	 *
	 * @return  void
	 */
  protected function onBeforeSave()
  {
    $this->setOrdering();
  }


  // Overridden, access checking in FOF30 DataController triggerEvent() method seems broken
  protected function checkACL($area)
  {
    // Access control checks on Controller's execute() method don't make sense
    if ('@Execute' == $area)
    {
      return true;
    }

    // Models which use item-level asset tracking don't work with read tasks
    if ( 'read' == $this->getTask() )
    {
      return true;
    }

    return parent::checkACL($area);
  }
}
