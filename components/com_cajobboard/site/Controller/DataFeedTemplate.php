<?php
/**
 * Site Data Feed Template Controller
 *
 * @package   Calligraphic Job Board
 * @version   October 26, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Controller;

// Framework classes
use \Calligraphic\Cajobboard\Site\Controller\BaseController;
use \FOF30\Container\Container;

// no direct access
defined('_JEXEC') or die;

class DataFeedTemplate extends BaseController
{
	/**
	 * Overridden. Limit the tasks we're allowed to execute.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
		parent::__construct($container, $config);

		$this->setModelName('DataFeedTemplates');

		$this->addPredefinedTaskList(array(

		));
	}
}
