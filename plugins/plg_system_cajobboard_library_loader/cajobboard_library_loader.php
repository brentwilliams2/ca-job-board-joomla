<?php
/**
 * Register library namespaces with FOF autoloader
 *
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

/**
 * Custom library loader so library is available to any package
 */
class PlgSystemCajobboard_library_loader extends CMSPlugin
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
    // FOF30's Autoloader will append this autoloader to PHP's SPL
    // autoloader stack, so the class name is available anywhere
    $autoloader = FOF30\Autoloader\Autoloader::getInstance();

    // Add the library namespace
    $autoloader->addMap('Calligraphic\\Cajobboard\\Library\\', JPATH_LIBRARIES . '/Cajobboard');

    // Register modified autoload function
    $autoloader->register(false);

		return true;
  }
}
