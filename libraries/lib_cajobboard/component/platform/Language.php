<?php
/**
 * Language class to replace Joomla! JLanguage
 *
 * @package   Calligraphic Job Board
 * @version   July 2, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Library\Platform;

// no direct access
defined('_JEXEC') or die;

use \FOF30\Container\Container;
use \Joomla\CMS\Factory;
use \FOF30\View\View;

class Language
{
  /*
    @TODO: caching for language files

    Move from JText and JLanguage static methods to a Calligraphic library version
    of each that uses PHP files (so opcache can cache them) for all template,
    job board, and FOF30 language files. See notes in cajobboard_library_loader about
    implementation
  */

  /**
   * The container object
   *
   * @var Container
   */
  protected $container;


	/**
	 * Over-ridden public constructor for the params object
	 *
   * The constructor is extended to avoid a database query because the
	 * \FOF30\Params\Params base class calls reload() from it's constructor.
	 *
	 * @param  Container $container  The container we belong to
	 */
	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	/**
	 * Return the JLanguage instance of the CMS/application
	 *
	 * @return \Joomla\CMS\Language\Language
	 */
	public function getLanguage()
	{
		return Factory::getLanguage();
  }


  /**
	 * Load the translation file for a given view.
   *
   * Note that the $view variable may have a different container object
   * attached the Platform $container class property if HMVC in use.
   *
   * @param   View|string   A FOF30 View object or the name of the view. If no value provided, component translation file is loaded.
	 *
	 * @return  void
	 */
	public function loadViewTranslations($view = null)
	{
    // NOTE: caching is handled in Language class

    $component = $this->container->componentName;

    /* @var  \Joomla\CMS\Language\Language  $language */
    $language = $this->getLanguage();

    $siteLangDir  = JPATH_SITE . '/components/' . $component;
    $adminLangDir = JPATH_ADMINISTRATOR . '/components/' . $component;

    $isBackend = $this->container->platform->isBackend();

    // load the enum translation file
    $language->load('enum', $adminLangDir, 'en-GB', true);

    // load the exceptions translation file
    $language->load('exceptions', $adminLangDir, 'en-GB', true);

    // common language file for front-end and back-end in /administrator/language folder
    $language->load($component . '_common', $adminLangDir, 'en-GB', true);
    $language->load($component . '_common', $adminLangDir, null, true);

    // load component translation file
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

    // Exit if no view was given
    if (!$view)
    {
      return;
    }

    if ($view instanceof View)
    {
      $view = $view->getName();
    }

    $view = $this->container->inflector->normalizeMediaAssetName($view);

    if ($isBackend)
    {
      // core language file in /administrator/language folder
      $language->load($view, $adminLangDir, 'en-GB', true);
      $language->load($view, $adminLangDir, null, true);
    }
    else
    {
      // core language file in /language folder
      $language->load($view, $siteLangDir, 'en-GB', true);
      $language->load($view, $siteLangDir, null, true);
    }
  }
}
