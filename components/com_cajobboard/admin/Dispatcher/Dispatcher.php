<?php
/**
 * Admin entry file for FOF component
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Dispatcher;

if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

use \Calligraphic\Cajobboard\Admin\Helper\EmailIncoming;
use \Calligraphic\Cajobboard\Admin\Helper\EmailOutgoing;
use \Calligraphic\Cajobboard\Admin\Helper\Enum\ImageObjectAspectRatiosEnum;
use \Calligraphic\Cajobboard\Admin\Helper\Enum\VideoObjectAspectRatiosEnum;
use \FOF30\Container\Container;
use \Joomla\CMS\Toolbar\Toolbar;

// no direct access
defined('_JEXEC') or die;

// Load extended array functions, based on Laravel 4's "helpers.php"
require_once(JPATH_LIBRARIES . DS . 'fof30' . DS . 'Utils' . DS . 'helpers.php');

class Dispatcher extends \FOF30\Dispatcher\Dispatcher
{
  /**
   * @property  string  The name of the default view, in case none is specified
   */
  public $defaultView = 'ControlPanels';


  /**
   * @property  string  The string to use for asset filenames (frontend, backend)
   */
  public $areaName;


  /**
   * @property  string  The string to use for the asset folders (Site, Admin)
   */
  public $areaFolder;


  /**
   * @property  string  A string to prepend for loading minified asset files in production
   */
  public $minified;


	public function onBeforeDispatch()
	{
    if ( $this->container->platform->isBackend() )
    {
      // Add component's toolbar button path to Joomla!'s Toolbar singleton for admin area
      $toolbar = ToolBar::getInstance();
      $toolbar->addButtonPath(realpath(__DIR__ . DS . '..' . DS . 'Toolbar' . DS . 'Buttons'));
    }

    $this->setAssetModifiers()
    $this->addJavascript();
    $this->addCss();

    $this->addContainerServices();
  }

  /*
   * Services to add to the component's container. The container object ($c)
   * is available  inside the closure.
   */
  protected function addContainerServices()
  {
    $this->container->ImageObjectAspectRatiosEnum = function ($c) {
      return new ImageObjectAspectRatiosEnum();
    };

    $this->container->VideoObjectAspectRatiosEnum = function ($c) {
      return new VideoObjectAspectRatiosEnum();
    };

    $this->container->EmailOutgoing = function ($c) {
      return new EmailOutgoing();
    };

    $this->container->EmailIncoming = function ($c) {
      return new EmailIncoming();
    };
  }


  /*
   * Set properties used for loading asset files differentially, based on admin vs. site and dev vs. production
   */
  protected function setAssetModifiers()
  {
    if ( $this->container->platform->isBackend() )
    {
      $this->areaFolder = 'Admin';
      $this->areaName = 'backend';
    }
    else
    {
      $this->areaFolder = 'Site';
      $this->areaName = 'frontend';
    }

    $this->minified =  DEBUG ? '' : '.min';
  }


  /*
   * Load component-wide Javascript files
   */
  protected function addJavascript()
  {
    $this->container->template->addJS('media://com_cajobboard/js/'. $this->areaFolder . '/' . $this->areaName . $this->minified . '.js', true, false);
  }


  /*
   * Load component-wide style sheets
   */
  protected function addCss()
  {
    // media://com_cajobboard/css/backend.min.css
    $this->container->template->addCSS('media://com_cajobboard/css/' . $this->areaName . $this->minified . '.css');
  }
}
