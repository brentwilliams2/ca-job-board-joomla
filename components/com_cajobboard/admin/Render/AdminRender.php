<?php
/**
 * Admin Renderer
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Render;

use \FOF30\Container\Container;
use \FOF30\Render\RenderInterface;
use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Toolbar\Toolbar;
use \Joomla\CMS\Language\Text;
use \JHtmlSidebar;

// For unused method signatures
use \FOF30\Model\DataModel;
use \FOF30\Form\Form;

// no direct access
defined('_JEXEC') or die;


class AdminRender implements RenderInterface
{
	/** @var   Container|null  The container we are attached to */
  protected $container = null;


	/**
	 * Public constructor. Determines the priority of this class and if it should be enabled
	 */
	public function __construct(Container $container)
	{
    $this->container = $container;

		// Load Joomla! backend language file to display system translation strings
    $this->container->platform->loadTranslations('joomla');
  }


	/**
	 * Echoes HTML to show before the view template
	 *
	 * @param   string $view The current view
	 * @param   string $task The current task
	 *
	 * @return  void
	 */
	function preRender($view, $task)
	{
    $input = $this->container->input;
    $platform = $this->container->platform;

    $format	 = $input->getCmd('format', 'html');

		if ( $format != 'html' || $platform->isCli() )
		{
			return;
    }

		HTMLHelper::_('behavior.core');
    HTMLHelper::_('jquery.framework', true);

    $classes = array();

    $area = 'admin';
    $option = $input->getCmd('option', '');
    $viewForCssClass = $input->getCmd('view', '');
    $layout = $input->getCmd('layout', 'default');
    $taskForCssClass = $input->getCmd('task', 'default');

    $classes = array(
      'area-' . $area,
      'option-' . $option,
      'view-' . $viewForCssClass,
      'layout-' . $layout,
      'task-' . $taskForCssClass,
      'j-toggle-main',
      'j-toggle-transition',
      'row-fluid'
    );

    $classes = array_unique($classes);

    echo '<div id="cajobboard" class="' . implode($classes, ' ') . "\">\n";

    $this->renderLinkbarItems();
  }


	/**
	 * Echoes any HTML to show after the view template
	 *
	 * @param   string $view The current view
	 * @param   string $task The current task
	 *
	 * @return  void
	 */
	function postRender($view, $task)
	{
    $input = $this->container->input;
    $platform = $this->container->platform;

    $format	 = $input->getCmd('format', 'html');

		if ( $format != 'html' || $platform->isCli() )
		{
			return;
    }

    // JHtmlSidebar is not namespaced in Joomla! 3.9
    $sidebarEntries = JHtmlSidebar::getEntries();

    if (!empty($sidebarEntries))
    {
      echo '</div><!-- sidebar links -->';
    }

    echo "</div><!-- id=cajobboard -->\n";
  }


  /**
	 * Render the linkbar
	 *
	 * @param   Toolbar  $toolbar  A toolbar object
	 */
	protected function renderLinkbarItems()
	{
    $toolbar = $this->container->toolbar;

    $links = $toolbar->getLinks();

		if (empty($links))
		{
      return;
    }

    foreach ($links as $link)
    {
      JHtmlSidebar::addEntry($link['name'], $link['link'], $link['active']);

      $dropdown = false;

      if (array_key_exists('dropdown', $link))
      {
        $dropdown = $link['dropdown'];
      }

      if ($dropdown)
      {
        foreach ($link['items'] as $item)
        {
          JHtmlSidebar::addEntry('– ' . $item['name'], $item['link'], $item['active']);
        }
      }
    }
	}


	/**
	 * Required to fulfill interface. Not used.
	 */
	public function setOption($key, $value)
	{
		throw new \LogicException(sprintf('AdminRenderer does not implement setOption() method'));
  }


	/**
	 * Required to fulfill interface. Not used.
	 */
	public function setOptions(array $options)
	{
    throw new \LogicException(sprintf('AdminRenderer does not implement setOptions() method'));
  }


	/**
	 * Required to fulfill interface. Not used.
	 */
	public function getOption($key, $default = null)
	{
		throw new \LogicException(sprintf('AdminRenderer does not implement getOption() method'));
  }


	/**
	 * Required to fulfill interface. Not used.
	 *
	 * @return object
	 */
	public function getInformation()
	{
		throw new \LogicException(sprintf('AdminRenderer does not implement getInformation() method'));
  }


	/**
	 * Required to fulfill interface. Not used. Will be removed in Akeeba FOF Version 4.
	 */
	function renderForm(Form &$form, DataModel $model, $formType = null, $raw = false)
	{
		throw new \LogicException(sprintf('renderForm() method in AdminRenderer is deprecated'));
  }


	/**
	 * Required to fulfill interface. Not used. Will be removed in Akeeba FOF Version 4.
	 */
	function renderFormBrowse(Form &$form, DataModel $model)
	{
		throw new \LogicException(sprintf('renderFormBrowse() method in AdminRenderer is deprecated'));
  }


	/**
	 * Required to fulfill interface. Not used. Will be removed in Akeeba FOF Version 4.
	 */
	function renderFormRead(Form &$form, DataModel $model)
	{
		throw new \LogicException(sprintf('renderFormRead() method in AdminRenderer is deprecated'));
  }


	/**
	 * Required to fulfill interface. Not used. Will be removed in Akeeba FOF Version 4.
	 */
	function renderFormEdit(Form &$form, DataModel $model)
	{
		throw new \LogicException(sprintf('renderFormEdit() method in AdminRenderer is deprecated'));
  }


	/**
	 * Required to fulfill interface. Not used. Will be removed in Akeeba FOF Version 4.
	 */
	function renderFormRaw(Form &$form, DataModel $model, $formType = null)
	{
		throw new \LogicException(sprintf('renderFormRaw() method in AdminRenderer is deprecated'));
  }


	/**
	 * Required to fulfill interface. Not used.
	 */
	function renderCategoryLinkbar()
	{
		throw new \LogicException(sprintf('renderCategoryLinkbar() method in AdminRenderer is deprecated'));
  }


	/**
	 * Required to fulfill interface. Not used.
	 */
	function renderFieldset(\stdClass &$fieldset, Form &$form, DataModel $model, $formType, $showHeader = true)
	{
		throw new \LogicException(sprintf('renderFieldset() method in AdminRenderer is deprecated'));
  }


	/**
	 * Required to fulfill interface. Not used.
	 */
	function renderFieldsetLabel($field, Form &$form, $title)
	{
		throw new \LogicException(sprintf('renderFieldsetLabel() method in AdminRenderer is deprecated'));
  }


	/**
	 * Required to fulfill interface. Not used.
	 */
	function isTabFieldset($fieldset)
	{
    throw new \LogicException(sprintf('isTabFieldset() method in AdminRenderer is deprecated'));
	}
}
