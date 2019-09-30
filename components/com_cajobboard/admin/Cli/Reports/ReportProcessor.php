<?php
/**
 * CLI Script for generating and sending PDF analytics reports asynchronously.
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

include realpath(__DIR__ . '/../CliApplication.php');

use \FOF30\Container\Container;
use \Joomla\CMS\Factory;
use \Joomla\Registry\Registry;

// @TODO: Implement Reports CLI script for generating and sending PDF analytics reports asynchronously


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
