<?php
/**
 * CLI Script for handling email asynchronously.
 *
 * Uses the Email helper and EmailMessages model for processing and sending
 * email, respectively. Can be called from cron to scan for and send periodic
 * mailings, or from plg_cajobboard_mail when that plugin is dispatched on an
 * event by a controller. The Email helper is broken out as it is used in
 * common by this CLI script for asynchronous execution, and by the mail plugin
 * for synchronous execution when this script is unavailable, e.g. because of
 * permissions.
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

include realpath(__DIR__ . '/../CliApplication.php');
include realpath(__DIR__ . '/IncomingMail.php');
include realpath(__DIR__ . '/OutgoingMail.php');

use \FOF30\Container\Container;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Input\Cli;
use \Joomla\Registry\Registry;


// @TODO: implement MailProcessor

/**
 * Calligraphic Job Board Sample Data Seeder CLI Application
 *
 * @var    \JInput                       $input
 * @var    \Joomla\Registry\Registry    $config
 */
class MailProcessor extends CliApplication
{
	/**
	 * Class constructor
	 */
  public function __construct()
  {
    parent::__construct();
  }


  /**
	 * Main method of class
   *
   * @return void
	 */
  public function execute()
  {
    // Create the FOF Container object
    parent::execute();
  }


  /**
	 * Checks if PCNTL support is available for parallel async processing of tasks with spatie/async, not available in Windows environment
   *
   * @return boolean
	 */
  public function isPcntlAvailable()
  {
    // Need
    return extension_loaded('pcntl');

    /*
      Call from client code:

      // handle making sure there's permission to run the script
      whoiam()

      if ( substr( php_uname(), 0, 7 ) == "Windows" )
      {
        // Windows doesn't have Pcntl
        pclose( popen("start /B ". $cmd, "r") );
      }
      else
      {
        // Run the script as a background process so that it's async, and redirect STDOUT and STDERR with double-redirect
        exec($cmd . " &> /dev/null &");
      }
    */
  }
}

// Execute this CLI application
$app = CliApplication::getInstance('MediaProcesor');
Factory::$application = $app;
$app->execute();
