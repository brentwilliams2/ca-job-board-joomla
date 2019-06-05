<?php
 /**
  * View Helper for formatting date time strings
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  namespace Calligraphic\Cajobboard\Site\Helper;

  use \Calligraphic\Cajobboard\Admin\Helper\Format as AdminFormat;
  use FOF30\Date\Date;
  use \Joomla\CMS\Language\Text;

  // no direct access
  defined('_JEXEC') or die;


  abstract class Format {
    /**
    * Format date strings to "1 day ago", etc.
    *
    * @param    $dateCreated  Date/time the object was created
    * @param    $dateModified Date/time the object was last modified
    *
    * @return   string  Formatted time
    */
    public static function convertToTimeAgoString($dateCreated, $dateModified = null) {
// time()             1557261473
// $dateCreated       0000-00-00 00:00:00
//
      // difference between current time and the database (MySQL format) item's created or modified time (whichever is later)
      $diff = time() - strtotime( $dateModified ? $dateModified : $dateCreated );

      if( $diff < 60 ) // it happened now
        return Text::_('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_NOW');

      elseif( $diff >= 60 && $diff < 120 ) // it happened 1 minute ago
        return Text::_('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_MINUTE');

      elseif( $diff < 3600 ) // it happened n minutes ago
        return Text::sprintf('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_MINUTES', round($diff / 60));

      elseif( $diff >= 3600 && $diff < 7200 ) // it happened 1 hour ago
        return Text::_('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_HOUR');

      elseif( $diff < 3600 * 24 ) // it happened n hours ago
        return Text::sprintf('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_HOURS', round($diff / 3600));

      elseif( $diff < 3600 * 24 * 2 ) // it happened yesterday
        return Text::_('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_YESTERDAY');

      elseif( $diff < 3600 * 24 * 30 ) // it happened n days ago
        return Text::sprintf('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_DAYS', round($diff / (3600 * 24)));

      elseif( $diff >= 3600 * 24 * 30 * 2 && $diff >= 3600 * 24 * 30 * 3 ) // it happened 1 month ago
        return Text::_('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_MONTH');

      elseif( $diff < 3600 * 24 * 30 * 12 ) // it happened n months ago
        return Text::sprintf('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_MONTHS', round($diff / (3600 * 24 * 30)));

      else // it happened a long time ago
        return Text::_('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_LONG');
    }

    /**
    * Format the "Created on" date strings to "Tuesday, April 4 2019, 12:18 pm", etc.
    *
    * @param    Date  $date   The date/time object to use for output
    *
    * @return   string  Formatted time
    */
    public static function getCreatedOnText($date) {
      // handle new records with database engine constant for time stamp
      if ('CURRENT_TIMESTAMP' == $date)
      {
        $now = new Date();

        $date = (string) $now;
      }

      return AdminFormat::date($date, 'l, F n o, g:i a');
    }
  }
