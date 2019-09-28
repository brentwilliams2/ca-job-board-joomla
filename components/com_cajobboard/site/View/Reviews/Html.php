<?php
/**
 * Reviews HTML View
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\View\Reviews;

// no direct access
defined('_JEXEC') or die;

use \FOF30\Container\Container;
use \Calligraphic\Cajobboard\Site\View\Common\BaseHtml;

class Html extends BaseHtml
{
	/**
	 * Overridden.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);

    // Vendor lib for the star-rating widget
    $this->addJavascriptFile('media://com_cajobboard/js/Vendor/rater.min.js');
  }
}
