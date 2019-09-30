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

// no direct access
defined('_JEXEC') or die;

if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

if(!defined('LENGTH_NOT_ENFORCED')) define('LENGTH_NOT_ENFORCED', 0);
if(!defined('LENGTH_TRUNCATE_ON_EXCEEDED')) define('LENGTH_TRUNCATE_ON_EXCEEDED', 1);
if(!defined('LENGTH_REJECT_ON_EXCEEDED')) define('LENGTH_REJECT_ON_EXCEEDED', 2);

use \Calligraphic\Cajobboard\Admin\Dispatcher\Services;
use \FOF30\Container\Container;
use \Joomla\CMS\Toolbar\Toolbar;

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
	protected $viewNameAliases = array();


  /**
	 * @param Container   $container
	 * @param array       $config
	 */
  public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);

    // Load component services into the container
    $services = new Services($container);
    $services->addContainerServices();

    // Add irregular plural form words for component to inflector
    // MUST be called affer container services are added
    $this->initInflectorVocab();

    // Setup any back-end view aliases in use: PII, FCRA
    if ( $this->container->platform->isBackend() )
    {
      $this->setViewAliases(array(
        'ControlPanels' => 'ControlPanel'
      ));
    }
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
    $this->container->AssetFiles->setAssetPaths();
    $this->container->AssetFiles->addComponentJavascript();
    $this->container->AssetFiles->addComponentCss();
  }


  /**
	 * Set view aliases. Call from onBeforeDispatch methods.
   *
   * @param array $aliases   An array of view aliases to set, in the format 'alias' => 'RealView'
	 *
	 * @return  void
	 */
	public function setViewAliases($aliases)
	{
    array_merge($this->viewNameAliases, $aliases);
  }


  /**
	 * Get a view name from its alias, if set.
   *
   * @param string $alias   The view alias to get the real name for
	 *
	 * @return  string|false   Returns the real name for the view alias, or false if no match
	 */
	public function getViewNameFromAlias($alias)
	{
    if ( isset($this->viewNameAliases[$alias]) )
    {
      return $this->viewNameAliases[$alias];
    }

    return false;
  }


  /**
	 * Get a view alias from its name, if set.
   *
   * @param string $alias   The view name to get the alias for
	 *
	 * @return  string|false   Returns the view alias, or false if no match
	 */
	public function getViewAlias($name)
	{
    return array_search($name, $this->viewNameAliases);
  }


  /**
	 * Load the core  and view component translation files
	 *
	 * @return  void
	 */
	protected function loadTranslations()
	{
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
      'FairCreditReportingAct' => 'FairCreditReportingAct',
      'PersonallyIdentifiableInformation' => 'PersonallyIdentifiableInformation',
      'Person' => 'Persons'
    );

    foreach ($irregularWords as $singular => $plural)
    {
      $this->container->inflector->addWord($singular, $plural);
    }
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
      $this->controller = $this->container->factory->controller($this->view, $this->config);

      $this->controller->execute($task);

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
