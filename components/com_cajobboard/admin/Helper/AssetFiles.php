<?php
/**
 * Helper class for loading Javascript and style sheet files
 *
 * @package   Calligraphic Job Board
 * @version   July 3, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Usage:
 */

namespace Calligraphic\Cajobboard\Admin\Helper;

use \FOF30\Container\Container;
use \FOF30\View\View;

// no direct access
defined('_JEXEC') or die;

class AssetFiles
{
  /**
   * @property Container
   */
  protected $container;


  /**
   * An array of css files that have already been loaded
   *
   * @property array
   */
  protected $cssFiles = array();


  /**
   * An array of css file that have already been loaded
   *
   * @property array
   */
  protected $javascriptFiles = array();


  /**
   * The string to use when building asset filenames (value can be 'frontend' or 'backend')
   *
   * @property  string
   */
  protected $areaName;


  /**
   * The asset folders to use in the media directory URL (value can be 'Site' or 'Admin')
   *
   * @property  string
   */
  protected $areaFolder;


  /**
   * A string to prepend for loading minified asset files in production (value can be empty or '.min')
   *
   * @property  string
   */
  protected $minified;


	/**
	 * @param Container   $container
	 */
  public function __construct(Container $container)
	{
    $this->container = $container;
  }


  /**
   * Set properties used for loading asset files differentially, based on admin vs. site
   * and dev vs. production. The job board uses a bespoke directory structure in the media folder.
   *
   * @return  void
   */
  public function setAssetPaths()
  {
    if ( $this->container->platform->isBackend() )
    {
      $this->areaFolder = 'Admin';
      $this->areaName = 'backend';
    }
    else
    {
      $this->areaFolder = 'Site';
      $this->areaName = 'frontend';
    }

    $this->minified =  JDEBUG ? '' : '.min';
  }


  /**
   * Add a view CSS file to the page header based on the View
   * object passed and whether in front-end or back-end of site
   *
   * Note that the $view variable may have a different container object
   * attached than this object's $container class property if HMVC in use.
   *
   * @param  View   A FOF30 View object. If no value provided, component CSS file is loaded.
   *
   * @return void
   */
  public function addViewCss(View $view = null)
  {
    if (!$view)
    {
      // media://com_cajobboard/css/backend.min.css
      $this->container->template->addCSS('media://com_cajobboard/css/'. $this->areaFolder . '/' . $this->areaName . $this->minified . '.css', true, false);

      return;
    }

    $viewName = $this->container->inflector->normalizeMediaAssetName( $view->getName() );

    if ( in_array($viewName, $this->cssFiles) )
    {
      return;
    }

    $this->container->template->addCSS('media://com_cajobboard/css/'. $this->areaFolder . '/' . $viewName . $this->minified . '.css', true, false);

    array_push($this->cssFiles, $viewName);
  }


  /**
   * Add a view Javascript file to the page header based on the View
   * object passed and whether in front-end or back-end of site
   *
   * Note that the $view variable may have a different container object
   * attached than this object's $container class property if HMVC in use.
   *
   * @param  View|null   A FOF30 View object. If no value provided, component Javascript file is loaded.
   *
   * @return void
   */
  public function addViewJavascript(View $view = null)
  {
    if (!$view)
    {
      $this->container->template->addJS('media://com_cajobboard/js/'. $this->areaFolder . '/' . $this->areaName . $this->minified . '.js', true, false);

      return;
    }

    $viewName = $this->container->inflector->normalizeMediaAssetName( $view->getName() );

    if ( in_array($viewName, $this->javascriptFiles) )
    {
      return;
    }

    $this->container->template->addJS('media://com_cajobboard/js/'. $this->areaFolder . '/' . $viewName . $this->minified . '.js', true, false);

    array_push($this->javascriptFiles, $viewName);
  }


  /**
   * Add the component's CSS file to the page header based on whether in front-end or back-end of site
   *
   * @return void
   */
  public function addComponentCss()
  {
    $this->addViewCss();
  }


  /**
   * Add a view CSS file to the page header based on whether in front-end or back-end of site
   *
   * @return void
   */
  public function addComponentJavascript()
  {
    $this->addViewJavascript();
  }
}
