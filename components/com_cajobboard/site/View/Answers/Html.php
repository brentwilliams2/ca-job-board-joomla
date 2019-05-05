<?php
/**
 * Answers Site HTML View
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\View\Answers;

// no direct access
defined('_JEXEC') or die;

use \FOF30\Container\Container;
use \Calligraphic\Cajobboard\Site\View\Common\BaseHtml;

if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

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

    $this->loadLanguageFileForView('answers');

    // Load javascript file for Answer views
    $this->addJavascriptFile('media://com_cajobboard/js/Site/answers.js');
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


	protected function onAfterEdit()
	{
    $model = $this->getModel();
    $model->getAssetJTable();
  }
}
