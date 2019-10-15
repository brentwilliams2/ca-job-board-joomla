<?php
/**
 * Overridden Platform class
 *
 * @package   Calligraphic Job Board
 * @version   September 11, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Library\Platform;

use \Calligraphic\Library\Platform\Inflector;
use \Calligraphic\Library\Platform\Params;
use \FOF30\Model\DataModel;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Router\Route;
use \Joomla\CMS\Categories\Categories;


// no direct access
defined('_JEXEC') or die;

class Platform extends \FOF30\Platform\Joomla\Platform
{
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
    * Get a reference to the Joomla! Language object
    *
    * @return \Joomla\CMS\Language\Language
    */
   public function getLanguage()
   {
     return $this->container->Language->getLanguage();
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

    $isTLS = $this->Params->getConfigOption('force_ssl') ? TLS_FORCE : TLS_DISABLE;

    return Route::_($uri, true, $isTLS, true);
  }
}
