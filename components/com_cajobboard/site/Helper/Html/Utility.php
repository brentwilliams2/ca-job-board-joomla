<?php
/**
 * Helper class for site view Common HTML widgets
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Site\Helper\Html;

// no direct access
defined('_JEXEC') or die;

abstract class Utility
{
  /**
	 * Method to return standard class attributes for an HTML element based on a given prefix, suffic, and task name
	 *
   * @param 	string    $suffix   The element's suffix to use for a class attribute name, e.g. 'author-avatar' (same as field name)
   * @param 	string    $prefix   A prefix to prepend to a class attribute, e.g. a 'prefix-created-on-date' class
   * @param 	string    $crud     The name of the crud view, e.g. 'browse', 'read', 'edit', 'add'
	 *
	 * @return  string
	 */
	public static function getAttributeClass($suffix, $prefix = null, $crud = null)
	{
    $class  = $crud ? $crud . ' ' : '';
    $class .= 'common-' . $suffix;
    $class .= $prefix ? ' ' . $prefix . '-' . $suffix : '';

    return $class;
  }
}