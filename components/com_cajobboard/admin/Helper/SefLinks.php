<?php
/**
 * Registration Helpers
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 *            Copyright (c) 2011-2018 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Helper;

use \Joomla\CMS\Router\Route;
use \Joomla\CMS\Uri\Uri;

// no direct access
defined('_JEXEC') or die;

class SefLinks
{
  /**
   * @property  Container
   */
  private $container;

  /**
	 * Public constructor
	 *
	 * @param   Container
	 */
	public function __construct(Container $container)
	{
    $this->container = $container;
  }


  /**
   * An administrator triggering an email from the back-end to a user will not get SEF-friendly URLs from JRoute. This routine can be used anywhere.
   */
  public function getSefLink($contentUrl)
  {
    // Here the contentURL is the url with correct itemid
    $contentUrl = Route::_($contentUrl);

    if ( $this->container->platform->isBackend() )
    {
      $parsed_url = substr($contentUrl, strlen( Uri::base(true)) + 1);

      $app = $this->container->platform->getApplication();

      $appInstance = $app::getInstance('site');

      $router = $appInstance->getRouter();

      $uri = $router->build($parsed_url);

      $parsed_url = $uri->toString();

      $contentRoutedUrl = substr($parsed_url, strlen( Uri::base(true) ) + 1);
    }
  }
}
