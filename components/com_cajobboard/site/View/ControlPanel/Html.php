<?php
/**
 * Site Control Panel HTML View
 *
 * @package   Calligraphic Job Board
 * @version   September 29, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\View\ControlPanel;

use FOF30\Container\Container;
use FOF30\View\View;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Component\ComponentHelper;
use \Joomla\CMS\HTML\HTMLHelper;

// no direct access
defined('_JEXEC') or die;

class Html extends View
{
  /**
	 * The application container
	 *
	 * @var  Container
	 */
  protected $container;


	/**
	 * Overridden. Load view-specific language file.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    $this->container = $container;

    // Unsure why having to set ViewTemplate path in this View class and not in DataView classes
    $config['template_path'] = JPATH_COMPONENT . '/ViewTemplates/' . $this->container->inflector->pluralize( $this->getName() );

    parent::__construct($container, $config);

    // Load CSS for admin view
		$this->addCssFile('media://com_cajobboard/css/frontend.css');
		$this->addCssFile('media://com_cajobboard/css/Site/control_panel.css');

    HTMLHelper::_('behavior.tooltip');
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
		$this->setPageTitle();
  }


	/**
	 * Set the page title and metadata
	 *
	 * @return  void
	 */
	public function setPageTitle()
	{
    $document = Factory::getDocument();

    $document->setTitle( Text::_('COM_CAJOBBOARD_TITLE_CONTROLPANELS_DEFAULT') );
  }
}
