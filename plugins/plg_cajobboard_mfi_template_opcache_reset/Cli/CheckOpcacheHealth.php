<?php
/**
 * CLI Script to test PHP Opcache health. Run from Cron task periodically.
 *
 * @package   Calligraphic Job Board
 * @version   May 1, 2019
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

// set this script as admin
JFactory::getConfig()->set('session_name', 'administrator');

use \Joomla\CMS\Input\Cli;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Log\Log;

/**
 * Multi Family Insiders Template PHP Opcache Health CLI Application
 */
class CheckOpcacheHealth extends JApplicationCli
{
  /*
   * What level the health check message should be logged at
   */
  private $logLevel = 'notice';


  public function __construct()
  {
    // Instantiate a new input object. It will populate itself with command line arguments (argv)
    $this->input = new Cli();

    // Set the execution datetime and timestamp for profiling;
    $this->set('execution.datetime', gmdate('Y-m-d H:i:s'));
    $this->set('execution.timestamp', time());

    // Set the current directory.
    $this->set('cwd', getcwd());

    // $_SERVER variables required by the view, let's fake them
    $_SERVER['HTTP_HOST'] = 'http://www.example.com';

    $this->disableTimeLimit();
    $this->setErrorHandling();
  }


  /**
	 * Main method of class
	 */
  public function execute()
  {
    // returns false if opcache not enabled
    $stat = opcache_get_status(false);

    if (!$stat)
    {
      Log::add( Text::_('PLG_EXTENSION_MFI_TEMPLATE_OPCACHE_RESET_HEALTH_NOCACHE'), Log::WARNING );

      return;
    }

    $config = opcache_get_configuration();

    $logMssg = Text::_('PLG_EXTENSION_MFI_TEMPLATE_OPCACHE_RESET_HEALTH_LEADER');

    if (!$stat["cache_full"])
    {
      $this->logLevel = 'warning';

      $logMssg .= Text::_('PLG_EXTENSION_MFI_TEMPLATE_OPCACHE_RESET_HEALTH_CACHE_FULL');
    }

    if ($stat["restart_pending"] || $stat["restart_in_progress"])
    {
      $this->logLevel = 'warning';

      $logMssg .= Text::_('PLG_EXTENSION_MFI_TEMPLATE_OPCACHE_RESET_HEALTH_RESTART');
    }

    $logMssg .= Text::_('PLG_EXTENSION_MFI_TEMPLATE_OPCACHE_RESET_HEALTH_USED_MEMORY', ["memory_usage"]["used_memory"] ?? '<this key not set>');
    $logMssg .= Text::_('PLG_EXTENSION_MFI_TEMPLATE_OPCACHE_RESET_HEALTH_FREE_MEMORY', ["memory_usage"]["free_memory"] ?? '<this key not set>');
    $logMssg .= Text::_('PLG_EXTENSION_MFI_TEMPLATE_OPCACHE_RESET_HEALTH_WASTED_MEMORY', ["memory_usage"]["wasted_memory"] ?? '<this key not set>');
    $logMssg .= Text::_('PLG_EXTENSION_MFI_TEMPLATE_OPCACHE_RESET_HEALTH_CURRENT_WASTED_PERCENTAGE', ["memory_usage"]["current_wasted_percentage"] ?? '<this key not set>');

    $logMssg .= Text::_('PLG_EXTENSION_MFI_TEMPLATE_OPCACHE_RESET_HEALTH_INTERNED_STRING_USED_MEMORY', ["interned_strings_usage"]["used_memory"] ?? '<this key not set>');
    $logMssg .= Text::_('PLG_EXTENSION_MFI_TEMPLATE_OPCACHE_RESET_HEALTH_INTERNED_STRING_FREE_MEMORY', ["interned_strings_usage"]["free_memory"] ?? '<this key not set>');
    $logMssg .= Text::_('PLG_EXTENSION_MFI_TEMPLATE_OPCACHE_RESET_HEALTH_INTERNED_STRING_NUMBER_OF_STRINGS', ["interned_strings_usage"]["number_of_strings"] ?? '<this key not set>');

    $logMssg .= Text::_('PLG_EXTENSION_MFI_TEMPLATE_OPCACHE_RESET_HEALTH_NUM_CACHED_SCRIPTS', ["opcache_statistics"]["num_cached_scripts"] ?? '<this key not set>');
    $logMssg .= Text::_('PLG_EXTENSION_MFI_TEMPLATE_OPCACHE_RESET_HEALTH_NUM_CACHED_KEYS', ["opcache_statistics"]["num_cached_keys"] ?? '<this key not set>');
    $logMssg .= Text::_('PLG_EXTENSION_MFI_TEMPLATE_OPCACHE_RESET_HEALTH_HITS', ["opcache_statistics"]["hits"] ?? '<this key not set>');
    $logMssg .= Text::_('PLG_EXTENSION_MFI_TEMPLATE_OPCACHE_RESET_HEALTH_MISSES', ["opcache_statistics"]["misses"] ?? '<this key not set>');
    $logMssg .= Text::_('PLG_EXTENSION_MFI_TEMPLATE_OPCACHE_RESET_HEALTH_BLACKLIST_MISSES', ["opcache_statistics"]["blacklist_misses"] ?? '<this key not set>');
    $logMssg .= Text::_('PLG_EXTENSION_MFI_TEMPLATE_OPCACHE_RESET_HEALTH_BLACKLIST_MISS_RATIO', ["opcache_statistics"]["blacklist_miss_ratio"] ?? '<this key not set>');
    $logMssg .= Text::_('PLG_EXTENSION_MFI_TEMPLATE_OPCACHE_RESET_HEALTH_OPCACHE_HIT_RATE', ["opcache_statistics"]["opcache_hit_rate"] ?? '<this key not set>');

    if ($this->logLevel == 'notice')
    {
      Log::add($logMssg, Log::NOTICE);
    }
    else
    {
      Log::add($logMssg, Log::WARNING);
    }
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
}


/**
 * Exception handler to pretty-print all script error messages, and
 * only give full stack trace on non-user errors
 *
 * @return  void
 */
function cliExceptionHandler (\Throwable $exception)
{
  echo $exception->getMessage();

  echo $exception->getFile() . ' Line: ' . $exception->getLine();

  echo $exception->getTrace();

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

// Execute this CLI application
$app = CliApplication::getInstance('CheckOpcacheHealth');
\JFactory::$application = $app;
$app->execute();
