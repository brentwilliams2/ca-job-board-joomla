<?php
/**
 * Custom Joomla! HTMLHelper class for site browse view HTML widgets
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Usage in Blade templates:
 *     @jhtml('helper.browsewidgets.methodName', parameter1, ...)
 *
 * These are based on the Akeeba FEF (front-end framework) helpers included in FOF with revised HTML output
 */

// Can't namespace since this class is used through Joomla's autoloader and JHtml system, and class
// names have to be lower-cased and follow a naming convention for the JLoader scheme to work.

// no direct access
defined('_JEXEC') or die;

use \Joomla\CMS\Language\Text;

abstract class helperBrowsewidgets
{

}
