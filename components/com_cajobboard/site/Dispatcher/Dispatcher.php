<?php
/**
 * Back-end entry file for FOF component
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Dispatcher;

//  Framework classes
use FOF30\Container\Container;
use JHtml;

// Helpe classes
use Calligraphic\Cajobboard\Site\Helper\JobPostingViewHelper;

// no direct access
defined('_JEXEC') or die;

class Dispatcher extends \FOF30\Dispatcher\Dispatcher
{
	/** @var   string  The name of the default view, in case none is specified */
  public $defaultView = 'JobPostings';

	public function onBeforeDispatch()
	{
    // Load JQuery and Bootstrap javascript before anything else (template includes load after component)
    JHtml::_('jquery.framework');
    JHtml::_('bootstrap.framework');

    // Load common CSS and JavaScript
    if(JDEBUG)
    {
		$this->container->template->addCSS('media://com_cajobboard/css/frontend.css');
    $this->container->template->addJS('media://com_cajobboard/js/Site/frontend.js', true, false);
    }
    else
    {
      $this->container->template->addCSS('media://com_cajobboard/css/frontend.min.css');
      $this->container->template->addJS('media://com_cajobboard/js/Site/frontend.min.js', true, false);
    }

    // @TODO: Is this really how we want to do this?
    $this->container['job_posting_view_helper'] = function ($c) {
      return new JobPostingViewHelper();
    };
	}
}
