<?php
/**
 * Administrator Control Panel Controller
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Controller;

// no direct access
defined('_JEXEC') or die;

class Person extends DataController
{
	/*
	 * Overridden. Limit the tasks we're allowed to execute.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    $this->predefinedTaskList = ['browse', 'save'];

    parent::__construct($container, $config);
  }

	/*
	 * Override browse task.
	 */
	protected function browse()
	{
  }

	/*
	 * Override read task.
	 */
	protected function read()
	{
  }

  /*
   * Override edit task.
   */
	protected function edit()
	{
	}
}
