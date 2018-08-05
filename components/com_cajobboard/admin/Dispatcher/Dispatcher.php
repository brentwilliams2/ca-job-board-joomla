<?php
/**
 * Back-end entry file for FOF component
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Dispatcher;

// no direct access
defined('_JEXEC') or die;

use FOF30\Container\Container;

class Dispatcher extends \FOF30\Dispatcher\Dispatcher
{
	/** @var   string  The name of the default view, in case none is specified */
  public $defaultView = 'ControlPanel';

	public function onBeforeDispatch()
	{
		// Renderer options (0=none, 1=frontend, 2=backend, 3=both)
		// $myParam   = $this->container->params->get('param_name', 3);
		// $this->container->renderer->setOption('param_name', $myParam);

		// Load common CSS and JavaScript
		$this->container->template->addCSS('media://com_cajobboard/css/backend.css', $this->container->mediaVersion);
		$this->container->template->addJS('media://com_cajobboard/js/backend.js', false, false, $this->container->mediaVersion);
	}
}
