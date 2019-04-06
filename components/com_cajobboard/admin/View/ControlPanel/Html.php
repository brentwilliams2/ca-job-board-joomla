<?php
/**
 * Admin Control Panel HTML View
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\View\ControlPanel;

use FOF30\Container\Container;
use FOF30\View\View;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Component\ComponentHelper;

// no direct access
defined('_JEXEC') or die;

if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

class Html extends View
{
	/**
	 * The component-level parameters stored in #__extensions by com_config
	 *
	 * @var  \JRegistry
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

    //$this->getContainer()->input->set('render_toolbar', false);

    parent::__construct($container, $config);

    // Get component parameters
    $this->componentParams = ComponentHelper::getParams('com_cajobboard');

    // Using view-specific language files for maintainability
    $lang = Factory::getLanguage();
    $lang->load('control_panel', JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_cajobboard', $lang->getTag(), true);

    // Load javascript file for Job Posting views
    $this->addJavascriptFile('media://com_cajobboard/js/Admin/controlPanel.js');
  }

	/**
	 * Runs before rendering the view template, echoing HTML to put before the
	 * view template's generated HTML
	 *
	 * @return  void
	 *
	 * @throws \Exception
	 */
	protected function preRender()
	{
    $view = $this->getName();

    $task = $this->task;

    $toolbar = $this->container->toolbar;

		$toolbar->renderToolbar($view, $task);

		$this->setPageTitle();

    $renderer = $this->container->renderer;

		$renderer->preRender($view, $task);
  }


	/**
	 * Runs after rendering the view template, echoing HTML to put after the
	 * view template's generated HTML
	 *
	 * @return  void
	 */
	protected function postRender()
	{
    $view = $this->getName();

    $task = $this->task;

    $renderer = $this->container->renderer;

		if ($renderer instanceof RenderInterface)
		{
			$renderer->postRender($view, $task);
		}
  }

	/**
	 * Set the page title and metadata
	 *
	 * @return  void
	 */
	public function setPageTitle()
	{
    $document = Factory::getDocument();

    $document->setTitle( Text::_('COM_CAJOBBOARD_ADMIN_CONTROL_PANEL_PAGE_TITLE') );
  }
}

