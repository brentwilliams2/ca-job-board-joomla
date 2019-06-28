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
use \Calligraphic\Cajobboard\Admin\Helper\Enum\ImageObjectAspectRatiosEnum;
use \Calligraphic\Cajobboard\Admin\Helper\Enum\VideoObjectAspectRatiosEnum;
use \Calligraphic\Cajobboard\Site\Helper\JobPosting as JobPostingHelper;
use \Calligraphic\Cajobboard\Site\Helper\RegistrationHelper;
use \FOF30\Container\Container;

// no direct access
defined('_JEXEC') or die;

class Dispatcher extends AdminDispatcher
{
  /**
   * @property   string  The name of the default view, in case none is specified
   */
  public $defaultView = 'JobPostings';


  /*
   * Services to add to the component's container. The container object ($c)
   * is available  inside the closure.
   */
  protected function addContainerServices()
  {
    parent::addContainerServices();

    $this->container->RegistrationHelper = function ($c) {
      return new RegistrationHelper($c);
    };
  }
}
