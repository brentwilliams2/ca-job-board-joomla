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
use \FOF30\Container\Container;

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
}
