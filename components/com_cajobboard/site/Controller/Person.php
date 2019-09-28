<?php
/**
 * Site Person Controller
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Controller;

use \FOF30\Container\Container;
use Calligraphic\Cajobboard\Site\Controller\BaseController;

use \Calligraphic\Cajobboard\Admin\Controller\Exception\NoPermissions;
use \Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;

class Person extends BaseController
{
	/**
	 * Overridden. Limit the tasks we're allowed to execute.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    $this->modelName = 'Persons';

    $this->predefinedTaskList = array(
			'add',
			'browse',
			'edit',
			'read',
			'remove',
			'save',
		);

		parent::__construct($container, $config);
	}
}
