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

// @TODO: Should change the name of this plugin to a generic Calligraphic name space, instead
//        of the job board, since it's making sure the MFI template language file is loaded in production

/**
 * Custom library loader so libraries are available to any package
 */
class PlgSystemCajobboard_library_loader extends CMSPlugin
{
	/**
   * Listener for the `onAfterInitialise` system event
	 *
	 * @return  boolean
	 */
  public function onAfterInitialise()
	{
    // FOF30's Autoloader will append this autoloader to PHP's SPL
    // autoloader stack, so the class name is available anywhere
    $autoloader = FOF30\Autoloader\Autoloader::getInstance();

    // Add the library namespaces
    $autoloader->addMap('Calligraphic\\Library\\Cajobboard\\', JPATH_LIBRARIES . '/calligraphic/component/cajobboard');
    $autoloader->addMap('Calligraphic\\Library\\Platform\\', JPATH_LIBRARIES . '/calligraphic/platform');

    // Register modified autoload function
    $autoloader->register(false);

    if ( file_exists(JPATH_LIBRARIES . '/calligraphic/vendor/autoload.php') )
    {
      include_once JPATH_LIBRARIES . '/calligraphic/vendor/autoload.php';
    }
    else
    {
      throw new \Exception('Calligraphic Library cannot find the Composer autoload file');
    }

    $this->loadLanguageFiles();

		return true;
  }


	/**
   * Load a single language file for each of the MFI template and the Job Board
	 */
  public function loadLanguageFiles()
	{
    // @TODO: implement single language file loader. PHP opcache won't cache .ini files, so
    //        all language files should be concatenated into a single file for each of the
    //        MFI template, and the Job Board, and all related plugins and modules respectively,
    //        and these two files loaded on system load to avoid lots of small file loads.
  }
}
