<?php
/**
 * Admin Toolbar
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Toolbar;

// no direct access
defined('_JEXEC') or die;

use \Joomla\CMS\Toolbar\ToolbarHelper as JToolBarHelper;
use \Joomla\CMS\Language\Text;
use \FOF30\Container\Container;
use \Calligraphic\Cajobboard\Admin\Toolbar\ToolbarHelper;

class Toolbar extends \FOF30\Toolbar\Toolbar
{
  /**
   * The `option` input parameter, e.g. `com_cajobboard`
   *
   *  @var  string
   */
  protected $option = null;


	/**
	 * Public constructor.
	 *
	 * The $config array can contain the following optional values:
	 *
	 * renderFrontendButtons	bool	Should I render buttons in the front-end of the component?
	 * renderFrontendSubmenu	bool	Should I render the submenu in the front-end of the component?
	 * useConfigurationFile		bool	Should we use the configuration file (fof.xml) of the component?
	 *
	 * @param   Container  $c       The container for the component
	 * @param   array      $config  The configuration overrides, see above
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);

    $this->option = $container->componentName;
  }


  /**
	 * Renders the toolbar for the current view and task
	 *
	 * @param   string   $view  The view of the component
	 * @param   string   $task  The exact task of the view
	 *
	 * @return  void
	 */
  /*
	public function renderToolbar($view = null, $task = null)
	{

  }
*/

	/**
	 * Renders the toolbar for the Control Panel page
	 *
	 * @return  void
	 */
	public function onControlPanelsDefault()
	{
    if ( !$this->container->platform->isBackend() )
    {
      return;
    }

    $this->renderSubmenu();

    $this->renderTitle('default');
  }


	/**
	 * Renders the toolbar for the component's Browse pages (the plural views)
	 *
	 * @return  void
	 */
	public function onBrowse()
	{
    if ( !$this->container->platform->isBackend() )
    {
      return;
    }

    $this->renderSubmenu();

		// Setup
		try
		{
      $view   = $this->container->input->getCmd('view', 'cpanel');
      $model = $this->container->factory->model($view);
		}
		catch (\Exception $e)
		{
			$model = null;
    }

    $this->renderTitle('browse');

		if (!$this->isDataView())
		{
			return;
    }

		$this->perms->create && JToolBarHelper::addNew();

		$this->perms->edit && JToolBarHelper::editList();

    // Published buttons are only added if there is an 'enabled' field in the table
    if ($model && $model->hasField('enabled') && $this->perms->editstate)
    {
      JToolBarHelper::publishList();
      JToolBarHelper::unpublishList();
    }

    // Featured buttons are only added if there is a 'featured' field in the table
    if ($model && $model->hasField('featured') && $this->perms->editstate)
    {
      ToolbarHelper::featureList();
      ToolbarHelper::unfeatureList();
    }

    $this->perms->editstate && JToolBarHelper::archiveList();

    // A Check-In button is only added if there is a locked_on field in the table
    // @TODO: move this into the job board widget helper class and use a nicer Bootstrap modal, and lose the all caps
    ($model && $model->hasField('locked_on') && $this->perms->edit) && JToolBarHelper::checkin();

    $this->perms->delete && JToolBarHelper::trash('trash');

    $this->perms->delete && JToolBarHelper::deleteList(strtoupper(Text::_($this->option . '_CONFIRM_DELETE')));

    JToolBarHelper::divider();

    // "Options" button that launches a modal of com_config view for this component
    JToolBarHelper::preferences($this->option);

    // string  $ref        The name of the popup file (excluding the file extension for an xml file).
    // bool    $com        Use the help file in the component directory.
    // string  $override   Use this URL instead of any other
    // string  $component  Name of component to get Help (null for current component)
    // @TODO: Add "Help" button
    // JToolBarHelper::help($ref, $com = false, $override = null, $component = null);
  }


	/**
	 * Renders the toolbar for the component's Read pages
	 *
	 * @return  void
	 */
	public function onRead()
	{
    if ( !$this->container->platform->isBackend() )
    {
      return;
    }

    $this->renderSubmenu();

		$this->renderTitle('read');

    JToolBarHelper::title(Text::_(strtoupper($this->option)) . ': ' . Text::_($subtitle_key), $componentName);

		if (!$this->isDataView())
		{
			return;
    }

		JToolBarHelper::back();
  }


	/**
	 * Renders the toolbar for the component's Add pages
	 *
	 * @return  void
	 */
	public function onAdd()
	{
    if ( !$this->container->platform->isBackend() || !$this->isDataView() )
    {
      return;
    }

    $this->renderTitle('add');

		($this->perms->edit || $this->perms->editown) && JToolBarHelper::apply();

    JToolBarHelper::save();

		$this->perms->create && JToolBarHelper::custom('savenew', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);

		JToolBarHelper::cancel();
  }


	/**
	 * Renders the toolbar for the component's Edit pages
	 *
	 * @return  void
	 */
	public function onEdit()
	{
    if ( !$this->container->platform->isBackend() || !$this->isDataView() )
    {
      return;
    }

    $this->renderTitle('edit');

		($this->perms->edit || $this->perms->editown) && JToolBarHelper::apply();

    JToolBarHelper::save();

		($this->perms->create) && JToolBarHelper::custom('savenew', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);

		JToolBarHelper::cancel();
  }


	/**
	 * Renders the title for admin pages
	 *
	 * @param   string    $task   The task of the page the title should be rendered for
	 */
	public function renderTitle($task)
	{
    // Set toolbar title
    $view = $this->container->inflector->pluralize($this->container->input->getCmd('view', 'cpanel'));

    $title_key = Text::_(strtoupper($this->option));

    $subtitle_key = Text::_(strtoupper($this->option . '_TITLE_' . $view . '_' . $task));

    JToolBarHelper::title($title_key . ': ' . $subtitle_key, 'com_cajobboard');
  }
}
