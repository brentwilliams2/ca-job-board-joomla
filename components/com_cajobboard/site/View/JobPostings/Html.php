<?php
/**
 * Job Postings HTML View
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\View;

// Framework classes
use JUri;

// Models accessed in this view class
use Calligraphic\Cajobboard\Site\Model\JobPostings;

// no direct access
defined('_JEXEC') or die;

class Html extends \FOF30\View\DataView\Html
{
 /*
  * Actions to take before list view is executed
  */
	protected function onBeforeBrowse()
	{
    parent::onBeforeBrowse();
  }

 /*
  * Actions to take before item view is executed
  */
	protected function onBeforeRead()
	{
		parent::onBeforeRead();
	}
}
