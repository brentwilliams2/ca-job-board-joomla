<?php
/**
 * Overridden Platform class
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Library\Platform;

use \Calligraphic\Library\Platform\Inflector;
use \FOF30\View\View;

// no direct access
defined('_JEXEC') or die;

class Platform extends \FOF30\Platform\Joomla\Platform
{
  /*
    @TODO:
    Move from JText and JLanguage static methods to a Calligraphic library version
    of each that uses PHP files (so opcache can cache them) for all template,
    job board, and FOF30 language files. See notes in cajobboard_library_loader about
    implementation

    use \Calligraphic\Library\Platform\Text;
    use \Calligraphic\Library\Platform\Language;
  */

	/**
	 * Return the \JLanguage instance of the CMS/application
	 *
	 * @return \JLanguage
	 */
	public function getLanguage()
	{
		return JFactory::getLanguage();
  }


  /**
	 * Load the translation file for a given view.
   *
   * Note that the $view variable may have a different container object
   * attached the Platform $container class property if HMVC in use.
   *
   * @param   View   A FOF30 View object. If no value provided, component translation file is loaded.
	 *
	 * @return  void
	 */
	public function loadViewTranslations(View $view = null)
	{
    // NOTE: caching is handled in Language class

    $component = $this->container->componentName;

    /* @var  \Joomla\CMS\Language\Language  $language */
    $language = $this->getLanguage();

    $siteLangDir  = JPATH_SITE . '/components/' . $component . '/language';
    $adminLangDir = JPATH_ADMINISTRATOR . '/components/' . $component . '/language';

    $isBackend = $this->isBackend();

    // load component and exception translation files if no view given
    if (!$viewName)
    {
      // load the exceptions translation file
      $language->load('exceptions', $adminLangDir, 'en-GB', true);

      if ($isBackend)
      {
        // core language file in /administrator/language folder
        $language->load($component, $adminLangDir, 'en-GB', true);
        $language->load($component, $adminLangDir, null, true);
      }
      else
      {
        // core language file in /language folder
        $language->load($component, $siteLangDir, 'en-GB', true);
        $language->load($component, $siteLangDir, null, true);
      }

      return;
    }

    $viewName = $this->container->inflector->normalizeMediaAssetName( $view->getName() );

    // Language method adds file prefix and suffix
    $qualifiedName = $component . '_' . $viewName;

    if ($isBackend)
    {
      // core language file in /administrator/language folder
      $language->load($qualifiedName, $adminLangDir, 'en-GB', true);
      $language->load($qualifiedName, $adminLangDir, null, true);
    }
    else
    {
      // core language file in /language folder
      $language->load($qualifiedName, $siteLangDir, 'en-GB', true);
      $language->load($qualifiedName, $siteLangDir, null, true);
    }
  }

  /**
	 * Load the component translation files
	 *
	 * @return  void
	 */
	public function loadComponentTranslations()
	{
    $this->loadViewTranslations();
  }
}
