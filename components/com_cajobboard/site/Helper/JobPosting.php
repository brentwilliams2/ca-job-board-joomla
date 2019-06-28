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

  use \Joomla\CMS\Language\Text;

  // no direct access
  defined('_JEXEC') or die;

  abstract class JobPosting {
    /**
    * Handle formatting pay if range given
    *
    * @param    $dateCreated  Date/time the object was created
    * @param    $dateModified Date/time the object was last modified
    *
    * @return   string  Formatted time
    */
    public static function formatPayToValueOrRange($value = null, $min_value = null, $max_value = null, $duration='P0H1')
    {
      $payPeriod = 'COM_CAJOBBOARD_PAY_FORMATTER_' . $duration;

      if ($value)
      {
        return $value . ' ' . Text::_($payPeriod);
      }

      elseif ($min_value && $max_value)
      {
        return Text::_('COM_CAJOBBOARD_PAY_FORMATTER_BETWEEN') . ' ' . $min_value . ' ' . Text::_('COM_CAJOBBOARD_PAY_FORMATTER_AND') . ' ' . $max_value . ' ' . Text::_($payPeriod);
      }

      return null;
    }

    /**
    * Create a teaser sentence from a longer string of text
    *
    * @param    $string   The string containing full text
    * @param    $count    Number of words to include in teaser string
    *
    * @return   string  Formatted time
    */
    public static function getTeaser($string, $count)
    {
      $words = explode(' ', $string);

      if (count($words) > $count)
      {
        $words = array_slice($words, 0, $count);

        $teaser = implode(' ', $words);
      }

      return $teaser;
    }
  }
