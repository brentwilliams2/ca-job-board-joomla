<?php
/**
 * @package     Calligraphic Job Board
 * @subpackage  User Plugin User.cajobboard
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// no direct access
defined('_JEXEC') or die;

use \Joomla\CMS\Plugin\CMSPlugin;

include 'Exception.php';

/**
 * Custom exception handler for the Multi Family Insiders template
 */
class plgSystemMfi_template_exception_handler extends CMSPlugin
{
	/**
   * Listener for the `onAfterInitialise` system event
	 *
	 * @return  boolean
	 *
	 * @since   1.0
	 */
  public function onAfterInitialise()
	{
    // Only using our handler if on expected platform, PHP 7.x series
    if (PHP_MAJOR_VERSION >= 7)
    {
      // Joomla's exception handler is set here:
      //  ./libraries/cms.php:71: set_exception_handler(array('JErrorPage', 'render'));
      restore_exception_handler();
      set_exception_handler(array('MfiTemplateExceptionHandler', 'render'));
    }

		return true;
  }
}
