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

namespace Calligraphic\Cajobboard\Site\Render;

use \FOF30\Container\Container;
use \FOF30\Render\RenderInterface;
use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Toolbar\Toolbar;
use \Joomla\CMS\Language\Text;

// For unused method signatures
use \FOF30\Model\DataModel;
use \FOF30\Form\Form;

// no direct access
defined('_JEXEC') or die;


class SiteRender implements RenderInterface
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

    $area = 'site';
    $option = $input->getCmd('option', '');
    $viewForCssClass = $input->getCmd('view', '');
    $layout = $input->getCmd('layout', '');
    $taskForCssClass = $input->getCmd('task', '');

    $classes = array(
      $area,
      $option,
      'view-' . $view,
      'view-' . $viewForCssClass,
      'layout-' . $layout,
      'task-' . $task,
      'task-' . $taskForCssClass,
      'j-toggle-main',
      'j-toggle-transition',
      'row-fluid',
    );

    $classes = array_unique($classes);

    echo '<div id="cajobboard" class="' . implode($classes, ' ') . "\">\n";
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

    echo "</div>\n";
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
