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

    $this->monkeyPatchLanguageSingleton();

		return true;
  }


	/**
   * Load a single language file for each of the MFI template and the Job Board
	 */
  public function monkeyPatchLanguageSingleton()
	{
    return;

    /*
    @TODO:

    implement single language file loader. PHP opcache won't cache .ini files, so
    all language files should be concatenated into a single file for each of the
    MFI template, and the Job Board, and all related plugins and modules respectively,
    and these two files loaded on system load to avoid lots of small file loads.

    Probably these steps:

    1. make sure administrator/language/en-GB/en-GB.lib_joomla.ini  is empty. This file is loaded during the initialisation routine (before the triggerEvent call to onAfterInitialise) and can't be avoided.
    2. then, in onAfterInitialise, set the JLanguage object's $language class property to visible and empty it of objects.
    3. Reload the JLanguage object's $language class property with Calligraphic Language objects for all system languages.
    4. Write the Calligraphic Language class in lib_cajobboard/platform. Have it check the template for .php language files in the template before falling back to .ini in components/plugins/modules/libraries. Skip that checking for a whitelist of Calligraphic extensions that are known to have .php language files.
    5. Convert all language files to .php language files

    JLang->load($extension = 'joomla', $basePath = JPATH_BASE, $lang = null, $reload = false, $default = true)
    returns true if file is loaded. null for $lang loads current language.

    example: JLang->load('lib_joomla', JPATH_ADMINISTRATOR); loads administrator/language/en-GB/en-GB.lib_joomla.ini

    JApplication's initialiseApp method calls onAfterInitialise event after the above language file has been loaded
    protected $this->language in JApplication can override with public JApplication->loadLanguage(\JLanguage $language = null)

    There's two ways in the framework to get the language object, and it's possible they return different objects (!):

      Factory::getLanguage()  // returns the Language class's singleton

      JApplication::getLanguage()  // returns the Application class's $language protected class property, setting it with a call to Factory::getLanguage() if empty

    JLanguage's protected $languages class property can have multiple language objects, representing different languages like Spanish, keyed by language name ('en-GB')

    zero-out the en-GB.lib_joomla.ini file, probably best idea and load everything from PHP files.
    use reflection to check if it works, log it in case a Joomla! update overwrites the language file.
    Initialise script doesn't check for language overrides.

    maybe check if opcache has the lib_joomla.ini file first, before getting it from reflection


    Getting access to protected class properties via reflection:

    Language class: protected array $strings

    function accessProtected($obj, $prop) {

      $reflection = new ReflectionClass($obj);

      $property = $reflection->getProperty($prop);

      $property->setAccessible(true);

      return $property->getValue($obj);
    }
    */
  }
}
