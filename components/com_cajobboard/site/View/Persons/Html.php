<?php
/**
 * Persons HTML View
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\View\Persons;

use \FOF30\Container\Container;
use \Calligraphic\Cajobboard\Site\View\Common\BaseHtml;

class Html extends BaseHtml
{
	/**
	 * The component-level parameters stored in #__extensions by com_config
	 *
	 * @var  \Joomla\Registry\Registry
	 */
  protected $componentParams;

	/**
	 * Overridden. Load view-specific language file.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);
  }


	/**
	 * Overridden. Executes before rendering the page for the Browse task.
   * Modified to eager load Profile relation to Profiles model and push the
   * model to the view templates.
	 */
	protected function onBeforeBrowse()
	{
    // Relations to eager-load
    $this->setupBrowse(array('Profile'));
  }
