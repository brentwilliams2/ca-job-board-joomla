<?php
/**
 * Comments Site HTML View
 *
 * @package   Calligraphic Job Board
 * @version   September 29, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Site\View\Comments;

use \FOF30\Container\Container;
use \Calligraphic\Cajobboard\Site\View\Common\BaseTreeHtml;

// no direct access
defined('_JEXEC') or die;

class Html extends BaseTreeHtml
{
	/**
	 * Overridden. Executes before rendering the page for the Browse task.
	 *
	 * IsPartOf not eager loaded, need to handle it as a 'browse' task instead with filters
	 */
	protected function getBrowseViewEagerRelations()
	{
    return array(
			'Author',
			'Image'
		);
	}
}
