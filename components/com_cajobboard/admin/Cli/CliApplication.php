<?php
/**
 * CLI that loads FOF and Joomla! framework
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

 // Abort immediately when this file is executed from a web SAPI
if (array_key_exists('REQUEST_METHOD', $_SERVER))
{
	die('Access Denied.');
}

// Set globals and app config for Jomsocial to initialize itself
empty($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] = '127.0.0.1';

// Define ourselves as a parent Joomla! entry point file
define('_JEXEC', 1);

// Required by the CMS
define('DS', DIRECTORY_SEPARATOR);

// Faker access the debug flag
define("JDEBUG", 0);

// Set the application root directory constant
define('JPATH_BASE', rtrim(realpath(dirname(__DIR__) . '/../../../'), DIRECTORY_SEPARATOR));

// Load Joomla's constant definitions
require_once JPATH_BASE . '/includes/defines.php';

// Load the framework classes
if (file_exists(JPATH_LIBRARIES . '/import.legacy.php'))
{
	require_once JPATH_LIBRARIES . '/import.legacy.php';
}
else
{
	require_once JPATH_LIBRARIES . '/import.php';
}

require_once JPATH_LIBRARIES . '/cms.php';

// Load the Joomla! configuration file to grab database information
JFactory::getConfig(JPATH_CONFIGURATION . '/configuration.php');

if (!defined('FOF30_INCLUDED') && !@include_once(JPATH_LIBRARIES . '/fof30/include.php'))
{
	throw new RuntimeException('Cannot load FOF', 500);
}

// More help for Jomsocial, set this script as admin
JFactory::getConfig()->set('session_name', 'administrator');

// Current path to script
$path = array(realpath(dirname(__FILE__)) . '/');

$autoloader = FOF30\Autoloader\Autoloader::getInstance();

// Add the current namespace to the autoloader
$autoloader->addMap('Calligraphic\\Cajobboard\\Admin\\Cli\\', $path);

// Path to Helper directory
$helperPath = array(realpath(dirname(__FILE__) . '/../Helper') . '/');

// Add the Helper namespace to the autoloader
$autoloader->addMap('Calligraphic\\Cajobboard\\Admin\\Helper\\', $helperPath);

// Path to Form directory
$formPath = array(realpath(dirname(__FILE__) . '/../Form') . '/');

// Quiet errors about forms on model save by adding the Form namespace to the autoloader
$autoloader->addMap('Calligraphic\\Cajobboard\\Admin\\Form\\', $formPath);

/* Plugin events not firing on CLI? */

// Rebuild the PHP global autoloader
$autoloader->register();

// Add Composer autoloader for applications in vendor directory
require_once JPATH_ADMINISTRATOR . '/components/com_cajobboard/vendor/autoload.php';

use \FOF30\Container\Container;
use \Joomla\Registry\Registry;
use \Joomla\CMS\Input\Cli;
use \Calligraphic\Cajobboard\Admin\Cli\Seeder\Exception\CliApplicationException;


/**
 * Calligraphic Job Board CLI Application
 */
class CliApplication extends JApplicationCli
{
 	/**
	 * The application container object
	 *
	 * @var    Container
	 */
  protected $container;


  /**
   * Class constructor
   *
   * @param Cli   $input
   * @param Registry   $config
   * @param \JDispatcher $dispatcher
   */
  public function __construct()
  {
    // Instantiate a new input object. It will populate itself with command line arguments (argv)
    $this->input = new Cli();

    // Instantiate a new configuration object.
    $this->config = new Registry;

    // Load an event dispatcher object.
    $this->loadDispatcher();

    // Load the configuration object.
    $this->loadConfiguration($this->fetchConfigurationData());

    // Set the execution datetime and timestamp for profiling;
    $this->set('execution.datetime', gmdate('Y-m-d H:i:s'));
    $this->set('execution.timestamp', time());

    // Set the current directory.
    $this->set('cwd', getcwd());

    // $_SERVER variables required by the view, let's fake them
    $_SERVER['HTTP_HOST'] = 'http://www.example.com';

    $this->disableTimeLimit();
    $this->setErrorHandling();

    $this->displayBanner();
  }


  /**
	 * Main method of class
	 */
  public function execute()
  {
    \JPluginHelper::importPlugin('system');

    // Trigger the onAfterInitialise event.
    $this->triggerEvent('onAfterInitialise');

    // Get a FOF Container to use. Must be in execute() method.
    $this->container = Container::getInstance('com_cajobboard');

    // Sections for FOF30 use, can be 'auto', 'inverse', 'site', or 'admin'
    $this->container->factory->setSection('admin');

    // The container lazy-loads services, so services that are set on the container
    // in the dispatcher constructor or onBeforeDispatch event aren't available in
    // cases where the CLI script accesses models directly without going through a
    // controller. This access instantiates the dispatcher to make those services available.
    $this->container->dispatcher;

    // Load translation files, HTML views do this in the onBeforeDispatch event
    $this->container->Language->loadViewTranslations();
  }

  //-----------------------------------------------------------------------
  // Following Joomla! CMSApplication and Web Application methods are for
  // the benefit of system plugins responding to onAfterInitialise event
  //-----------------------------------------------------------------------
  public function isClient($identifier)
	{
		return 'administrator' === $identifier;
  }

  public function isSite()
	{
		return $this->isClient('site');
  }

  public function isAdmin()
	{
		return $this->isClient('administrator');
  }

	public function getName()
	{
		return 'administrator';
	}

  public function getUserState($key, $default = null)
	{
    return $default;
  }

  //-----------------------------------------------------------------------

  /**
   * Default banner to display above CLI application output
   */
  protected function displayBanner()
  {
    $this->out("Calligraphic Job Board CLI");
    $this->out("");
  }


  /**
   * Disable PHP time limit
   */
  protected function disableTimeLimit()
  {
    // Unset time limits
    $safe_mode = true;

    if (function_exists('ini_get'))
    {
      $safe_mode = ini_get('safe_mode');
    }

    if (!$safe_mode && function_exists('set_time_limit'))
    {
      @set_time_limit(0);
    }
  }


  /**
   * Set error handling
   */
  protected function setErrorHandling()
  {
    // Set all errors to output the messages to the console, in order to
    // avoid infinite loops in JError
    restore_error_handler();

    JError::setErrorHandling(E_ERROR, 'die');
    JError::setErrorHandling(E_WARNING, 'echo');
    JError::setErrorHandling(E_NOTICE, 'echo');
  }


  /**
   * @return string
   */
  public function getTemplate()
  {
      return 'system';
  }


  /**
   * Use fgets instead of fread in JApplicationCli base class
   * @return string
   */
  public function in()
  {
      return trim(fgets(STDIN));
  }
}
// END class CliApplication


/**
 * Exception handler to pretty-print all script error messages, and
 * only give full stack trace on non-user errors
 *
 * @return  void
 */
function cliExceptionHandler (\Throwable $exception)
{
  echo $exception->getMessage();

  if ( !($exception instanceof CliApplicationException) )
  {
    echo $exception->getFile() . ' Line: ' . $exception->getLine();
    echo $exception->getTrace();
  }

  exit();
}

set_exception_handler('cliExceptionHandler');


/**
 * Timeout handler
 *
 * This function is registered as a shutdown script. If a catchable timeout occurs it will detect it and
 * print a helpful error message instead of just dying cold. The error level is set to 253 in this case.
 *
 * @return  void
 */
function CliTimeoutHandler ()
{
  $connection_status = connection_status();
  if ($connection_status == 0)
  {
    // Normal script termination, do not report an error.
    return;
  }

  echo "\n\n";
  echo "********** ERROR! **********\n\n";

  if (!$connection_status == 1)
  {
    echo 'This script has timed out. As a result, the process has FAILED to complete.';
  }

  echo "\n\n";
  exit(253);
}

register_shutdown_function('CliTimeoutHandler');
