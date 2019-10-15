<?php
/**
 * Load services into Container
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Dispatcher;

// no direct access
defined('_JEXEC') or die;

use \FOF30\Container\Container;

// Classes injected into Container
use \Calligraphic\Cajobboard\Admin\Dispatcher\ExceptionHandler;
use \Calligraphic\Cajobboard\Admin\Helper\AssetFiles;
use \Calligraphic\Cajobboard\Admin\Helper\EmailIncoming;
use \Calligraphic\Cajobboard\Admin\Helper\EmailOutgoing;
use \Calligraphic\Cajobboard\Admin\Helper\Format;
use \Calligraphic\Cajobboard\Admin\Helper\MessageCounts;
use \Calligraphic\Cajobboard\Admin\Helper\SefLinks;
use \Calligraphic\Cajobboard\Admin\Model\Helper\TableFields;
use \Calligraphic\Cajobboard\Site\Helper\JobPosting;
use \Calligraphic\Cajobboard\Site\Helper\Pagination;
use \Calligraphic\Cajobboard\Site\Helper\Registration;
use \Calligraphic\Cajobboard\Site\Helper\Semantic;
use \Calligraphic\Cajobboard\Site\Helper\User;
use \Calligraphic\Library\Platform\Inflector;
use \Calligraphic\Library\Platform\Language;
use \Calligraphic\Library\Platform\Params as JobBoardParams;
use \Calligraphic\Library\Platform\Registry;
use \Calligraphic\Library\Platform\Text;
use \FOF30\Params\Params as FrameworkParams;
use \Identicon\Identicon;

class Services
{
  /**
   * The container to add services to
   *
   * @var   Container
   */
  protected $container;


  /**
	 * @param   Container $container  A FOF30 Container object
	 */
	public function __construct(Container $container)
	{
    $this->container = $container;
  }


  /**
   * Services to add to the component's container. The container object ($c)
   * is available  inside the closure.
   *
   * @return  void
   */
  public function addContainerServices()
  {
    $this->replaceParamsObject();

    $this->addCommonServices();

    if ( $this->container->platform->isBackend() )
    {
      $this->addAdminServices();
    }
    else
    {
      $this->addSiteServices();
    }
  }


  /**
   * This effort is necessary because the \FOF30\Params\Params object is
   * set to $container['params] in the Container constructor, so there's
   * no way to catch it early enough to use the Job Board's custom Params
   * class, which also uses the Job Board's custom Registry class.
   *
   * @return  void
   */
  public function replaceParamsObject()
  {
    // Additional code that will run immediately after the service is created
    $this->container->extend('params', function (FrameworkParams $frameworkParamsObject, $container) {

      // Extract the framework Params class instance's registry object
      $reflectionClass = new \ReflectionClass($frameworkParamsObject);

      /** @var   \ReflectionProperty  $params */
      $paramsReflector = $reflectionClass->getProperty('params');

      // 'params' property of framework Params class has private visibility
      $paramsReflector->setAccessible(true);
      $frameworkRegistry = $paramsReflector->getValue($frameworkParamsObject);

      $jobBoardRegistry = new Registry($container);
      $jobBoardRegistry->merge($frameworkRegistry);

      $jobBoardParams = new JobBoardParams($container);
      $jobBoardParams->setParamsObject($jobBoardRegistry);

      return $jobBoardParams;
    });
  }


  /**
   * Services to add to the component's container for back-end and front-end views
   *
   * @return  void
   */
  protected function addCommonServices()
  {
    $this->container->AssetFiles = function ($container) {
      return new AssetFiles($container);
    };

    $this->container->EmailIncoming = function ($container) {
      return new EmailIncoming($container);
    };

    $this->container->EmailOutgoing = function ($container) {
      return new EmailOutgoing($container);
    };

    $this->container->ExceptionHandler = function ($container) {
      return new ExceptionHandler($container);
    };

    $this->container->Format = function ($container) {
      return new Format($container);
    };

    $this->container->Identicon = function ($container) {
      return new Identicon();
    };

    // overriding inflector already loaded, not an option to set the inflector in fof.xml
    $this->container->inflector = function ($container) {
      return new Inflector();
    };

    $this->container->Language = function ($container) {
      return new Language($container);
    };

    $this->container->MessageCounts = function ($container) {
      return new MessageCounts($container);
    };

    $this->container->TableFields = function ($container) {
      return new TableFields($container);
    };

    $this->container->Text = function ($container) {
      return new Text();
    };
  }


  /**
   * Services to add to the component's container for back-end views
   *
   * @return  void
   */
  protected function addAdminServices()
  {
    $this->container->SefLinks = function ($container) {
      return new SefLinks($container);
    };
  }


  /**
   * Services to add to the component's container for front-end views
   *
   * @return  void
   */
  protected function addSiteServices()
  {
    $this->container->JobPosting = function ($container) {
      return new JobPosting();
    };

    $this->container->Pagination = $this->container->factory(function ($container) {
      return new Pagination($container);
    });

    $this->container->Registration = function ($container) {
      return new Registration($container);
    };

    $this->container->Semantic = function ($container) {
      return new Semantic($container);
    };

    $this->container->User = function ($container) {
      return new User($container);
    };
  }
}
