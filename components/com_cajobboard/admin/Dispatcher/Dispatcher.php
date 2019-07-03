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
use \Calligraphic\Cajobboard\Admin\Helper\MessageCounts;
use \FOF30\Container\Container;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Toolbar\Toolbar;

// no direct access
defined('_JEXEC') or die;

// Load extended array functions, based on Laravel 4's "helpers.php"
require_once(JPATH_LIBRARIES . DS . 'fof30' . DS . 'Utils' . DS . 'helpers.php');

class Dispatcher extends \FOF30\Dispatcher\Dispatcher
{
  /**
   * The name of the default view, in case none is specified
   *
   * @property  string
   */
  public $defaultView = 'ControlPanels';

  /**
	 * Maps view name aliases to actual views. The format is 'alias' => 'RealView'.
	 *
	 * @property  array
	 */
	protected $viewNameAliases = [];


  /**
   * The string to use when building asset filenames (value can be 'frontend' or 'backend')
   *
   * @property  string
   */
  public $areaName;


  /**
   * The asset folders to use in the media directory URL (value can be 'Site' or 'Admin')
   *
   * @property  string
   */
  public $areaFolder;


  /**
   * A string to prepend for loading minified asset files in production (value can be empty or '.min')
   *
   * @property  string
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

    // Load the translations for this component
    $this->loadTranslations();

    // Add services to the FOF container
    $this->addContainerServices();
  }


	public function onAfterDispatch()
	{
    $this->setAssetPaths();
    $this->addJavascript();
    $this->addCss();
  }


  /**
	 * Set view aliases. Call from onBeforeDispatch method.
   *
   * @param array $aliases   An array of view aliases to set
	 *
	 * @return  void
	 */
	public function setViewAliases($aliases)
	{
    array_merge($this->viewNameAliases, $aliases);
  }


  /**
	 * Load the translation files
	 *
	 * @return  void
	 */
	protected function loadTranslations()
	{
    $component = $this->container->componentName;

    $view = strtolower($this->view);

		if ($this->isBackend())
		{
			$paths = array(JPATH_ROOT, JPATH_ADMINISTRATOR);
		}
		else
		{
			$paths = array(JPATH_ADMINISTRATOR, JPATH_ROOT);
    }

    /* @var  \Joomla\CMS\Language\Language  $language */
    $language = Factory::getLanguage();

    // @TODO: Add View language file

    // load($extension = 'joomla', $basePath = JPATH_BASE, $lang = null, $reload = false, $default = true)
    // returns true if file is loaded. null for $lang loads current language.
		$language->load($component, $paths[0], 'en-GB', true);
		$language->load($component, $paths[0], null, true);
		$language->load($component, $paths[1], 'en-GB', true);
		$language->load($component, $paths[1], null, true);
	}


  /*
   * Services to add to the component's container. The container object ($c)
   * is available  inside the closure.
   *
   * @return  void
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

    $this->container->MessageCounts = function ($c) {
      return new MessageCounts();
    };
  }


  /*
   * Set properties used for loading asset files differentially, based on admin vs. site
   * and dev vs. production. The job board uses a bespoke directory structure in the media folder.
   *
   * @return  void
   */
  protected function setAssetPaths()
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
   * Load component-wide and individual component Javascript files
   *
   * @return  void
   */
  protected function addJavascript()
  {
    $this->container->template->addJS('media://com_cajobboard/js/'. $this->areaFolder . '/' . $this->areaName . $this->minified . '.js', true, false);
    // @TODO: Add view JS
  }


  /*
   * Load component-wide and individual component style sheets
   *
   * @return  void
   */
  protected function addCss()
  {
    // media://com_cajobboard/css/backend.min.css
    $this->container->template->addCSS('media://com_cajobboard/css/' . $this->areaName . $this->minified . '.css');
    // @TODO: Add view CSS
  }


	/**
	 * Create an appropriate controller and execute it. FOF Dispatcher's dispatch method is
   * overridden here to add exception handling. All Job Board onBefore<task> and onAfter<task>
   * methods should throw exceptions on error condition. Default FOF behaviour is to return
   * false on error.
	 *
	 * @return  void
	 */
	public function dispatch()
	{
		// Perform transparent authentication for API calls
		if ($this->container->platform->getUser()->guest)
		{
			$this->transparentAuthenticationLogin();
    }

    $isCli = $this->container->platform->isCli();

    // set view from an alias if given
    if ( array_key_exists($this->view, $this->viewNameAliases) )
		{
      $this->view = $this->viewNameAliases[ $this->view ];
      $this->container->input->set('view', $this->view);
    }

		try
		{
      $this->triggerEvent( $isCli ? 'onBeforeDispatchCLI' : 'onBeforeDispatch' );

      // Task set here and not in controller so onBeforeDispatch methods can alter it
      $task = $this->input->getCmd('task', 'default');

      if ('default' == $task)
      {
          $this->input->set('task', 'default');
      }

      // Get and execute the controller
      $this->controller = $this->container->factory->controller($this->view, $this->config)->execute($task);

		  $this->triggerEvent( $isCli ? 'onAfterDispatchCLI' : 'onAfterDispatch' );
    }
		catch (\Exception $e)
		{
			if ($this->container->platform->isCli())
			{
				$this->container->platform->setHeader('Status', '403 Forbidden', true);
      }

      $this->transparentAuthenticationLogout();

      /*
        Redirect logic:

        If CLI, rethrow $e
        If on edit, redirect to the item view if user is authorized, otherwise to browse view if user is authorized, otherwise to default view
        If on add, redirect to the browse view if user is authorized, otherwise to default view
        If on browse, redirect to the default view

        Move all exceptions to admin
      */
    }

    $this->transparentAuthenticationLogout();

		$this->controller->redirect();
  }
}
