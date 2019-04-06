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

// Load extended array functions, based on Laravel 4's "helpers.php"
require_once(JPATH_LIBRARIES . DS . 'fof30' . DS . 'Utils' . DS . 'helpers.php');

class Dispatcher extends \FOF30\Dispatcher\Dispatcher
{
	/** @var   string  The name of the default view, in case none is specified */
  public $defaultView = 'ControlPanels';

	public function onBeforeDispatch()
	{
    // Add component's toolbar button path to Joomla!'s Toolbar singleton
    $toolbar = \JToolBar::getInstance();
    $toolbar->addButtonPath(realpath(__DIR__ . DS . '..' . DS . 'Toolbar' . DS . 'Buttons'));

    // Load common CSS and JavaScript
    if(JDEBUG)
    {
		  $this->container->template->addCSS('media://com_cajobboard/css/backend.css', $this->container->mediaVersion);
      $this->container->template->addJS('media://com_cajobboard/js/Admin/backend.js', false, false, $this->container->mediaVersion);
    }
    else
    {
		  $this->container->template->addCSS('media://com_cajobboard/css/backend.min.css', $this->container->mediaVersion);
      $this->container->template->addJS('media://com_cajobboard/js/Admin/backend.min.js', false, false, $this->container->mediaVersion);
    }
	}
}
