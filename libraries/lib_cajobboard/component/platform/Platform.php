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
use \FOF30\Model\DataModel;
use \FOF30\View\View;
use \Joomla\CMS\Component\ComponentHelper;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Router\Route;
use \Joomla\CMS\Categories\Categories;


// no direct access
defined('_JEXEC') or die;

class Platform extends \FOF30\Platform\Joomla\Platform
{
  /**
   * Get the Joomla! InputFilter object to use Global Configuration's Text
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


  /**
	 * Get a configuration option, cascading from highest to lowest priority:
   *
   *   item -> category -> component -> menu item -> global
	 *
	 * @param   string    $option   The option to fetch a value for
   * @param   mixed     $default  A default option for the configuration option
   * @param   DataModel $model    A DataModel instance if retrieving an item-level configuration option
	 *
	 * @return  string   The value of the global configuration option
	 */
	public function getConfigOption($option, $default = null, DataModel $model = null)
	{
    if ( $model instanceof DataModel && $value = $this->getItemConfigOption($option, null, $model) )
    {
      return $value;
    }
    elseif ( $model instanceof DataModel && $value = $this->getCategoryConfigOption($option, null, $model) )
    {
      return $value;
    }
    elseif ( $value = $this->getComponentConfigOption($option, null) )
    {
      return $value;
    }
    elseif ( $value = $this->getMenuConfigOption($option, null) )
    {
      return $value;
    }
    elseif ( $value = $this->getGlobalConfigOption($option, null) )
    {
      return $value;
    }

		return $default;
  }


  /**
	 * Get a global configuration option (set in configuration.php)
	 *
	 * @param   string  $option  The option to fetch a value for
   * @param   mixed   $default  A default option for the configuration option
	 *
	 * @return  string   The value of the global configuration option
	 */
	public function getGlobalConfigOption($option, $default = null)
	{
		return Factory::getConfig()->get($option, $default = null);
  }


  /**
	 * Get a menu configuration option for the current menu.
   * Returns null if option not set or in a CLI application .
	 *
	 * @param   string  $option  The option to fetch a value for
   * @param   mixed   $default  A default option for the configuration option
	 *
	 * @return  string   The value of the global configuration option
	 */
  public function getMenuConfigOption($option, $default = null)
  {
    if ( $this->isCli() )
    {
      return $default;
    }

    // getActive method returns null if an active menu item is not set
    $currentMenuItem = $this->getApplication()->getMenu()->getActive();

    if ($currentMenuItem)
    {
      return $currentMenuItem->params->get($option, $default);
    }
    else
    {
      return $default;
    }
  }


 /**
	 * Get a category configuration option
	 *
	 * @param   string  $option  The option to fetch a value for
   * @param   mixed   $default  A default option for the configuration option
	 *
	 * @return  string   The value of the global configuration option
	 */
	public function getCategoryConfigOption($option, $default = null, $model)
	{
    $categoryField = $model->getFieldAliase('cat_id');

    if ( !$model->hasField($categoryField) )
    {
      return null;
    }

    $categories = Categories::getInstance('com_cajobboard');

    /** @var \Joomla\CMS\Categories\CategoryNode */
    $category = $categories->get( $model->$categoryField );

    if (!$category)
    {
      return null;
    }

    /** @var \Joomla\Registry\Registry */
    $categoryParams = $category->getParams();

    $value = $categoryParams->get($option);

    $value = $value ? $value : $default;

    return $value;
  }


  /**
	 * Get a component configuration option, accessible from any component
	 *
	 * @param   string  $option  The option to fetch a value for
   * @param   mixed   $default  A default option for the configuration option
	 *
	 * @return  string   The value of the global configuration option
	 */
  public function getComponentConfigOption($option, $default = null)
  {
    return $this->container->params->get($option, $default);
  }


  /**
	 * Get a global configuration option (set in configuration.php)
	 *
	 * @param   string    $option   The option to fetch a value for
   * @param   mixed     $default  A default option for the configuration option
   * @param   DataModel $model    A DataModel instance for retrieving an item-level configuration option
	 *
	 * @return  string   The value of the global configuration option
	 */
  public function getItemConfigOption($option, $default = null, DataModel $model)
  {
    return $model->params->get($option, $default);
  }


  /**
	 * Get the application object
	 *
	 * @return  \Joomla\Application\CMSApplication
	 */
   public function getApplication()
   {
     return Factory::getApplication();
   }


  /**
	 * Get the current request URI as a routed SEF-friendly absolute URL
	 *
	 * @return  \Joomla\Application\CMSApplication
	 */
  public function getCurrentSefUri()
  {
    /** @var \Joomla\CMS\Uri\Uri */
    $uriHelper = Factory::getURI();

    // current() returns the request URI origin and filename without the query or fragment parts
    $uri = $uriHelper->current();

    $query = $uriHelper->getQuery();

    if ( !empty($query) )
    {
      $uri .= '?' . $query;
    }

    $fragment = $uriHelper->getFragment();

    if ( ( !empty($fragment) ) && ( '#' != $fragment) )
    {
      $strFragment .= $fragment;
    }

    $isTLS = $this->getConfigOption('force_ssl') ? TLS_FORCE : TLS_DISABLE;

    return Route::_($uri, true, $isTLS, true);
  }


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

    $isBackend = $this->isBackend();

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
