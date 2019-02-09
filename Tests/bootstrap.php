<?php
/**
 * PHPUnit Testing Fixture Bootstrap File
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018-2019 Calligraphic LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

define('_JEXEC', 1);

// Make sure timezone is set in PHP.ini, as PHP will stupidly error without checking the system
// tz setting when error reporting is equal or higher than E_STRICT and tz is unset in PHP.ini
if (function_exists('date_default_timezone_get'))
{
  // suppress errors if timezone isn't set in PHP.ini
  $serverTimezone = @date_default_timezone_get();
	if (empty($serverTimezone) || !is_string($serverTimezone)) exit('Please set timezone in your PHP.ini configuration file');
}

// Get development-specific settings for Joomla! installation to test against
require_once 'config.php';

define('JPATH_BASE', $testConfig['site_root']);

// Import Joomla! constant definitions
require_once JPATH_BASE . '/includes/defines.php';

if (!defined('JPATH_TESTS'))
{
	define('JPATH_TESTS', realpath(__DIR__));
}

// Bootstrap the CMS libraries.
require_once JPATH_LIBRARIES . '/import.legacy.php';
require_once JPATH_LIBRARIES . '/cms.php';

// This is required to force Joomla! to read the correct configuration.php file...
$config = JFactory::getConfig(JPATH_SITE . '/configuration.php');

// Load FOF's autoloader
require_once JPATH_LIBRARIES . '/fof30/include.php';

\FOF30\Autoloader\Autoloader::getInstance()->addMap('Calligraphic\\Cajobboard\\Tests\\', __DIR__);

// Work around Joomla! 3.7's Session package
$session    = JFactory::getSession();
$dispatcher = new JEventDispatcher();
$session    = JFactory::getSession();
$input      = new JInputCli();
$session->initialise($input, $dispatcher);
$session->start();

// Setup the tests
\Calligraphic\Cajobboard\Tests\Stubs\CommonSetup::setup();
