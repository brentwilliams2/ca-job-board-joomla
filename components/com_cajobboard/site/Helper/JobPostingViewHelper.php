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

  // Framework classes
  use JText;

  // no direct access
  defined('_JEXEC') or die;

	/**
	* View helpers for job postings
	*/
  class JobPostingViewHelper {
    /**
    * Format date strings to "1 day ago", etc.
    *
    * @param    $dateCreated  Date/time the object was created
    * @param    $dateModified Date/time the object was last modified
    *
    * @return   string  Formatted time
    */
    public function convertToTimeAgoString($dateCreated, $dateModified = null) {
      // difference between current time and the database (MySQL format) item's created or modified time (whichever is later)
      $diff = time() - strtotime($dateModified = null? $time : $dateModified);

      if( $diff < 60 ) // it happened now
        return JText::_('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_NOW');

      elseif( $diff >= 60 && $diff < 120 ) // it happened 1 minute ago
        return JText::_('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_MINUTE');

      elseif( $diff < 3600 ) // it happened X minutes ago
        return JText::sprintf('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_MINUTES', round($diff / 60));

      elseif( $diff >= 3600 && $diff < 7200 ) // it happened 1 hour ago
        return JText::_('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_HOUR');

      elseif( $diff < 3600 * 24 ) // it happened X hours ago
        return JText::sprintf('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_HOURS', round($diff / 3600));

      elseif( $diff < 3600 * 24 * 2 ) // it happened yesterday
        return JText::_('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_YESTERDAY');

      elseif( $diff < 3600 * 24 * 30 ) // it happened X days ago
        return JText::sprintf('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_DAYS', round($diff / (3600 * 24)));

      elseif( $diff >= 3600 * 24 * 30 * 2 && $diff >= 3600 * 24 * 30 * 3 ) // it happened 1 month ago
        return JText::_('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_MONTH');

      elseif( $diff < 3600 * 24 * 30 * 12 ) // it happened X months ago
        return JText::sprintf('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_MONTHS', round($diff / (3600 * 24 * 30)));

      else // it happened a long time ago
        return JText::_('COM_CAJOBBOARD_DATETIME_HELPER_TIMEBEFORE_LONG');
    }

    /**
    * Handle formatting pay if range given
    *
    * @param    $dateCreated  Date/time the object was created
    * @param    $dateModified Date/time the object was last modified
    *
    * @return   string  Formatted time
    */
    public function formatPayToValueOrRange($value = null, $min_value = null, $max_value = null, $duration='P0H1') {
      $payPeriod = 'COM_CAJOBBOARD_PAY_FORMATTER_' . $duration;

      if ($value) {
        return $value . ' ' . JText::_($payPeriod);
      }

      elseif ($min_value && $max_value) {
        return JText::_('COM_CAJOBBOARD_PAY_FORMATTER_BETWEEN') . ' ' . $min_value . ' ' . JText::_('COM_CAJOBBOARD_PAY_FORMATTER_AND') . ' ' . $max_value . ' ' . JText::_($payPeriod);
      }

      return null;
    }
  }
