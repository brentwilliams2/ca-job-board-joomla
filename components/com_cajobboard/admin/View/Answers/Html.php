<?php
/**
 * Answers Admin HTML View
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\View\Answers;

use \FOF30\Container\Container;

use \Calligraphic\Cajobboard\Admin\View\Common\BaseHtml;

// no direct access
defined('_JEXEC') or die;

class Html extends BaseHtml
{
	/**
	 * Overridden. Load view-specific language file.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);

    $this->loadLanguageFileForView('answers');

    // Load javascript file for Answer views
    //$this->addJavascriptFile('media://com_cajobboard/js/Admin/answers.js');
  }


	/**
	 * Overridden. Executes before rendering the page for the Browse task.
   * Modified to eager load Author relation to Persons model and push the
   * model to the view templates.
	 */
	protected function onBeforeBrowse()
	{
    $this->setupBrowse(array('Author', 'Publisher'));
  }
}
