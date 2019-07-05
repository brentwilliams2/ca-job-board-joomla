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

use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Toolbar\Toolbar;
use \FOF30\Container\Container;

// Classes injected into Container
use \Calligraphic\Cajobboard\Admin\Dispatcher\ExceptionHandler;
use \Calligraphic\Cajobboard\Admin\Helper\AssetFiles;
use \Calligraphic\Cajobboard\Admin\Helper\EmailIncoming;
use \Calligraphic\Cajobboard\Admin\Helper\EmailOutgoing;
use \Calligraphic\Cajobboard\Admin\Helper\Enum\ImageObjectAspectRatiosEnum;
use \Calligraphic\Cajobboard\Admin\Helper\Enum\VideoObjectAspectRatiosEnum;
use \Calligraphic\Cajobboard\Admin\Helper\MessageCounts;
use \Calligraphic\Library\Platform\Inflector;

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
	 * @param Container   $container
	 * @param array       $config
	 */
  public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);

    // Add services to the FOF container
    $this->addContainerServices();

    // Add irregular plural form words for component to inflector
    // MUST be called affer container services are added
    $this->initInflectorVocab();

    $this->setViewAliases(array(
      // @TODO: Setup any view aliases in use: PII, FCRA?
    ));
  }


  /**
	 * Load translations, assets, set Toolbar paths, and add irregular plural
   * model names to the inflector before executing the component
	 *
	 * @return  void
	 */
	public function setupBeforeDispatch()
	{
    if ( $this->container->platform->isBackend() )
    {
      // Add component's toolbar button path to Joomla!'s Toolbar singleton for admin area
      $toolbar = ToolBar::getInstance();

      $toolbar->addButtonPath(realpath(__DIR__ . DS . '..' . DS . 'Toolbar' . DS . 'Buttons'));
    }

    $this->loadTranslations();

    // Load assets
    $this->setAssetPaths();
    $this->addJavascript();
    $this->addCss();
  }


  /**
	 * Set view aliases. Call from onBeforeDispatch methods.
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
	 * Load the core  and view component translation files
	 *
	 * @return  void
	 */
	protected function loadTranslations()
	{
    // load the core translation file based on whether backend or frontend, e.g. en-GB.lib_calligraphic.php
    $this->container->platform->loadComponentTranslations();

    // load the current view translation file based on whether backend or frontend
    $this->container->platform->loadViewTranslations($this->view);
  }


  /**
	 * Adds words with irregular plural forms to the inflector
	 *
	 * @return  void
	 */
	public function initInflectorVocab()
	{
    $irregularWords = array(
      'FCRA' => 'FCRA',
      'PersonallyIdentifiableInformation' => 'PersonallyIdentifiableInformation'
    );

    foreach ($irregularWords as $singular => $plural)
    {
      $this->container->inflector->addWord($singular, $plural);
    }
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

    $this->container->AssetFiles = function ($c) {
      return new AssetFiles();
    };

    $this->container->ExceptionHandler = function ($c) {
      return new ExceptionHandler();
    };

    // overriding inflector already loaded, not an option in fof.xml
    $this->container->inflector = function ($c) {
      return new Inflector();
    };
  }


  /*
   * Load component-wide and individual component Javascript files
   *
   * @return  void
   */
  protected function addJavascript()
  {
    $this->container->AssetFiles->addComponentJS();
  }


  /*
   * Load component-wide and individual component style sheets
   *
   * @return  void
   */
  protected function addCss()
  {
    $this->container->AssetFiles->addComponentCSS();
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
      $this->setupBeforeDispatch();

      $this->triggerEvent( $isCli ? 'onBeforeDispatchCLI' : 'onBeforeDispatch' );

      // Task set here and not in constructor so onBeforeDispatch methods have opportunity to set it in state
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
      $this->transparentAuthenticationLogout();

      $this->container->ExceptionHandler->handle($e);
    }

    $this->transparentAuthenticationLogout();

		$this->controller->redirect();
  }
}
