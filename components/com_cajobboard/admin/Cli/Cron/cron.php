<?php
/**
 * CLI Script for Job Board CRON tasks
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// @TODO: Implement cron, We're calling this script as a task from "No Boss Crons" component

// Initialize Joomla framework
const _JEXEC = 1;

// Load system defines
if (file_exists(dirname(__DIR__) . '/defines.php'))
{
    require_once dirname(__DIR__) . '/defines.php';
}

if (!defined('_JDEFINES'))
{
    define('JPATH_BASE', dirname(__DIR__));
    require_once JPATH_BASE . '/includes/defines.php';
}

// Get the framework.
require_once JPATH_LIBRARIES . '/import.legacy.php';

// Bootstrap the CMS libraries.
require_once JPATH_LIBRARIES . '/cms.php';

// Load the configuration
require_once JPATH_CONFIGURATION . '/configuration.php';

require_once JPATH_BASE . '/includes/framework.php';

/**
 * Cron job
 *
 */
class Cron extends JApplicationCli
{
  /**
   * Entry point for the script
   *
   * @return  void
   *
   * @since   2.5
   */
  public function doExecute()
  {
    require_once JPATH_BASE.'/administrator/components/com_mycom/helpers/XMLImporter.php';

    echo "CRON TASK START\n";

    $instance = PropertyXMLImporter::instance();

    $instance->execute_import();

    echo "CRON TASK END\n";
  }
}

JApplicationCli::getInstance('Cron')->execute();
