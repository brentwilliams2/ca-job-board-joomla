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

// Add the current namespace to the autoloader
FOF30\Autoloader\Autoloader::getInstance()->addMap('Calligraphic\\Cajobboard\\Admin\\Cli\\', $path);

// Path to Helper directory
$helperPath = array(realpath(dirname(__FILE__) . '/../Helper') . '/');

// Add the Helper namespace to the autoloader
FOF30\Autoloader\Autoloader::getInstance()->addMap('Calligraphic\\Cajobboard\\Admin\\Helper\\', $helperPath);

// Path to Form directory
$formPath = array(realpath(dirname(__FILE__) . '/../Form') . '/');

// Quiet errors about forms on model save by adding the Form namespace to the autoloader
FOF30\Autoloader\Autoloader::getInstance()->addMap('Calligraphic\\Cajobboard\\Admin\\Form\\', $formPath);

// Rebuild the PHP global autoloader
FOF30\Autoloader\Autoloader::getInstance()->register();

// Add Composer autoloader for applications in vendor directory
require_once JPATH_ADMINISTRATOR . '/components/com_cajobboard/vendor/autoload.php';

use FOF30\Container\Container;

/**
 * Calligraphic Job Board CLI Application
 */
class CliApplication extends JApplicationCli
{
 	/**
	 * The application container object
	 *
	 * @var    \Joomla\Registry\Registry
	 */
  protected $container;


  /**
   * Class constructor
   *
   * @param JInputCli   $input
   * @param JRegistry   $config
   * @param JDispatcher $dispatcher
   */
  public function __construct(JInputCli $input = null, JRegistry $config = null, JDispatcher $dispatcher = null)
  {
    // Access POSIX-style CLI options
    //$this->getOption();

    // If a input object is given use it or instantiate a new input object.
    if ($input instanceof JInput)
    {
      $this->input = $input;
    }
    else
    {
      $this->input = new JInputCLI();
    }

    // If a config object is given use it or instantiate a new configuration object.
    if ($config instanceof JRegistry)
    {
      $this->config = $config;
    }
    //
    else
    {
      $this->config = new JRegistry;
    }

    // If an event dispatcher object is given use it or load one.
    if ($dispatcher instanceof JDispatcher)
    {
      $this->dispatcher = $dispatcher;
    }
    else
    {
      $this->loadDispatcher();
    }

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
    // Get a FOF Container to use. Must be in execute() method.
    $this->container = Container::getInstance('com_cajobboard');

    // Sections can be 'auto', 'inverse', 'site', or 'admin'
    $this->container->factory->setSection('admin');
  }


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
 * Timeout handler
 *
 * This function is registered as a shutdown script. If a catchable timeout occurs it will detect it and print a helpful
 * error message instead of just dying cold. The error level is set to 253 in this case.
 *
 * @return  void
 */
function CliTimeoutHandler()
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
