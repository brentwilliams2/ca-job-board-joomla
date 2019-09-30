<?php
/**
 * Answers Site Base Class for Controllers
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Controller;

// Framework classes
use \FOF30\Container\Container;
use \FOF30\Controller\DataController;

// no direct access
defined('_JEXEC') or die;

class BaseController extends DataController
{
  use \Calligraphic\Cajobboard\Admin\Controller\Mixin\Permissions;					// Overridden checkACL() method and utility methods
  use \Calligraphic\Cajobboard\Admin\Controller\Mixin\Redirect;							// Utilities for handling redirects in controller classes
  use \Calligraphic\Cajobboard\Admin\Controller\Mixin\ToggleField;          // Method to toggle boolean state fields
  use \Calligraphic\Cajobboard\Admin\Controller\Mixin\PredefinedTaskList;   // Overrides execute() to provide predefined tasks

	/*
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
      'publish',
      'read',
      'remove',
      'save',
      'savenew',
      'trash',
      'unpublish'
		));

    parent::__construct($container, $config);
  }


  /**
	 * Avoid default access permission check in Controller's triggerEvent method by implementing function
	 */
	protected function onBeforeEdit()
	{
		// Do ACL checks for user permission here, throw error if not authorized instead of dying quietly
		$result = $this->checkACL('core.edit') || $this->checkACL('core.edit.own');

		if (!$result)
		{
			throw new NoPermissions( Text::_('COM_CAJOBBOARD_EXCEPTION_NO_PERMISSION') );
		}

    return true;
  }
}
