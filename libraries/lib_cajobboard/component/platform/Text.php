<?php
/**
 * Text class to replace Joomla! JText
 *
 * @package   Calligraphic Job Board
 * @version   July 2, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Library\Platform;

//use \Joomla\String\StringHelper;
use \Joomla\CMS\Component\ComponentHelper;

// no direct access
defined('_JEXEC') or die;

/**
 * Languages/translation handler class
 */
class Text extends \Joomla\CMS\Language\Text
{
  /**
   * Return the Joomla! InputFilter object to use Global Configuration's Text
   * Filter Settings screen for HTML tag and attribute black/white listing
   */
  public function filterText(string $text)
  {
    return ComponentHelper::filterText($text);
  }


  /**
   * Truncate a text string to a maximum length, splitting on a word boundary (for intro text)
   *
   * @param   string  $text        The text to truncate
   * @param   int     $maxLength   The maximum length of the text
   *
   * @return  string  Returns the truncated string
   */
  public function truncateText(string $text, int $maxLength)
  {
    if ( strlen($text) <= $maxLength )
    {
      return $text;
    }

    $needle = '__END_OF_LINE__';

    $wrappedText = wordwrap($text, $maxLength, $needle);

    $pos = strpos($wrappedText , $needle);

    $result = substr($wrappedText, 0, $pos );
  }
}
