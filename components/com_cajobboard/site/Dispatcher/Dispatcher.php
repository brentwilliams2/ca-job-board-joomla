<?php
/**
 * Site entry file for FOF component
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Dispatcher;

if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

//  Framework classes
use \Calligraphic\Cajobboard\Admin\Dispatcher\Dispatcher as AdminDispatcher;
use \Calligraphic\Cajobboard\Site\Helper\JobPosting;
use \Calligraphic\Cajobboard\Site\Helper\RegistrationHelper;
use \FOF30\Container\Container;

// Classes injected into Container
use \Calligraphic\Cajobboard\Site\Helper\Pagination;
use \Calligraphic\Cajobboard\Site\Helper\Registration;
use \Calligraphic\Cajobboard\Site\Helper\Semantic;
use \Calligraphic\Cajobboard\Site\Helper\User;

// no direct access
defined('_JEXEC') or die;

class Dispatcher extends AdminDispatcher
{
  /**
   * @property   string  The name of the default view, in case none is specified
   */
  public $defaultView = 'JobPostings';


  /**
	 * @param Container   $container
	 * @param array       $config
	 */
  public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);

    // Setup any front-end view aliases in use: PII, FCRA
    $this->setViewAliases(array(
      //
    ));
  }


  /*
   * Services to add to the component's container. The container object ($c)
   * is available  inside the closure.
   */
  protected function addContainerServices()
  {
    // Add services common to both back-end and front-end of the site
    parent::addContainerServices();

    // Add services that are only used in the front-end from here down

    $this->container->Pagination = function ($container) {
      return new Pagination($container);
    };

    $this->container->Registration = function ($container) {
      return new Registration($container);
    };

    $this->container->Semantic = function ($container) {
      return new Semantic($container);
    };

    $this->container->User = function ($container) {
      return new User($container);
    };

    $this->container->JobPosting = function ($container) {
      return new JobPosting();
    };
  }
}
