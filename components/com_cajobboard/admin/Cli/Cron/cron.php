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

// @TODO: See Cron controller in the front end, and merge it or do something with it (based on Akeeba Cron script)

/*
    Can also use MySQL's native process handler to run periodic tasks, and use procedure language to set tasks:

    Check if process scheduler is enabled:

      SHOW PROCESSLIST;

    Enable process scheduler from command line when starting MySQL:

      --event-scheduler=ON

    Enable process scheduler in config my.cnf / (Windows) my.ini

      event_scheduler=ON

    Enable process scheduler in MySQL CLI:

      SET GLOBAL event_scheduler = ON;

    PL:

      CREATE EVENT `event_name`
      ON SCHEDULE schedule
      [ON COMPLETION [NOT] PRESERVE]
      [ENABLE | DISABLE | DISABLE ON SLAVE]
      DO BEGIN
        -- event body
      END;

    Schedule is:

      Once:                   AT ‘YYYY-MM-DD HH:MM.SS’
      Once after interval:    AT CURRENT_TIMESTAMP + INTERVAL n [HOUR|MONTH|WEEK|DAY|MINUTE]  e.g. AT CURRENT_TIMESTAMP + INTERVAL 1 DAY
      At intervals forever:   EVERY n [HOUR|MONTH|WEEK|DAY|MINUTE]
      At intervals limited:   EVERY n [HOUR|MONTH|WEEK|DAY|MINUTE] STARTS date ENDS date    e.g. EVERY 1 DAY STARTS CURRENT_TIMESTAMP + INTERVAL 1 WEEK ENDS ‘2012-01-01 00:00.00’

    Full sample:

      DELIMITER $$

      CREATE
        EVENT `archive_blogs`
        ON SCHEDULE EVERY 1 WEEK STARTS '2011-07-24 03:00:00'
        DO BEGIN

          -- copy deleted posts
          INSERT INTO blog_archive (id, title, content)
          SELECT id, title, content
          FROM blog
          WHERE deleted = 1;

          -- copy associated audit records
          INSERT INTO audit_archive (id, blog_id, changetype, changetime)
          SELECT audit.id, audit.blog_id, audit.changetype, audit.changetime
          FROM audit
          JOIN blog ON audit.blog_id = blog.id
          WHERE blog.deleted = 1;

          -- remove deleted blogs and audit entries
          DELETE FROM blog WHERE deleted = 1;

        END */$$

        DELIMITER ;
 */

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
