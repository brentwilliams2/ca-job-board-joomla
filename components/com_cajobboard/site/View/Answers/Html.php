<?php
/**
 * Answers Site HTML View
 *
 * @package   Calligraphic Job Board
 * @version   September 29, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Site\View\Answers;

use \FOF30\Container\Container;
use \Calligraphic\Cajobboard\Site\View\Common\BaseHtml;

// no direct access
defined('_JEXEC') or die;

class Html extends BaseHtml
{
	/**
	 * Overridden. Load view-specific Javascript files.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
		parent::__construct($container, $config);

		// Load Javascript modules for Answers site view
		$this->addJavascriptFile('media://com_cajobboard/js/Site/Component/report_item.js');
		$this->addJavascriptFile('media://com_cajobboard/js/Site/Component/toggle_login_register.js');
	}


	/**
	 * Overridden. Executes before rendering the page for the Browse task.
	 */
	protected function getBrowseViewEagerRelations()
	{
    return array(
			'Author',
			'IsPartOf'
		);
  }
}
