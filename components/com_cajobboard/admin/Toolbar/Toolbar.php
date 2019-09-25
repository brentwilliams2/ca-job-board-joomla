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

use \Calligraphic\Cajobboard\Admin\Toolbar\ToolbarHelper;
use \Joomla\CMS\Component\ComponentHelper;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Toolbar\ToolbarHelper as JToolBarHelper;

/**
 * Toolbar class for the Job Board admin pages.
 * 
 * This file has onTask() methods that control the formatting of the toolbar for the 
 * various admin views: onBrowse, onRead, onAdd, onEdit
 */
class Toolbar extends \FOF30\Toolbar\Toolbar
{
  // Trait with overridden base-class Toolbar methods
  use \Calligraphic\Cajobboard\Admin\Toolbar\Mixin\ToolbarBase;

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

    // Setup
    try
    {
      $view  = $this->container->input->getCmd('view', 'cpanel');
      $model = $this->container->factory->model($view);
    }
    catch (\Exception $e)
    {
      $model = null;
    }

    $this->renderSubmenu();
    $this->renderTitle('browse');

    if (!$this->isDataView())
    {
      return;
    }

    // #1 "New" button
		$this->perms->create && JToolBarHelper::addNew();

    // #2 "Edit" button
		$this->perms->edit && JToolBarHelper::editList();

    // #3 "Publish" and "Unpublish" buttons
    if ($model && $model->hasField('enabled') && $this->perms->editstate)
    {
      JToolBarHelper::publishList();
      JToolBarHelper::unpublishList();
    }

    // #4 "Feature" and "Unfeature" buttons
    if ($model && $model->hasField('featured') && $this->perms->editstate)
    {
      ToolbarHelper::featureList();
      ToolbarHelper::unfeatureList();
    }

    // #5 "Archive" button
    $this->perms->editstate && JToolBarHelper::archiveList();

    // #6 Check-in button
    ($model && $model->hasField('locked_on') && $this->perms->edit) && JToolBarHelper::checkin();

    // #7 "Trash" button
    $this->perms->delete && JToolBarHelper::trash('trash');

    // #8 "Delete" button
    $this->perms->delete && JToolBarHelper::deleteList(strtoupper(Text::_('COM_CAJOBBOARD_CONFIRM_DELETE')));

    JToolBarHelper::divider();

    // #9 "Options" button (launches a modal of com_config view for this component)
    JToolBarHelper::preferences('COM_CAJOBBOARD');

    // #10 "Help" button

    // string  $ref        The name of the popup file (excluding the file extension for an xml file).
    // bool    $com        Use the help file in the component directory. Set to true to force the use of local component help files.
    // string  $override   Use this URL instead of any other
    // string  $component  Name of component to get Help (null for current component)

    // JToolBarHelper::help($ref, $com = false, $override = null, $component = null);

    // A translation key of Components_Banners_Banners for $ref gives the following URL:
    // https://help.joomla.org/proxy?keyref=Help39:Components_Banners_Banners&lang=en

    // JToolbarHelper::help( 'MY_COMPONENT_HELP_VIEW_TYPE1', true );
    // MY_COMPONENT_HELP_VIEW_TYPE1="view_type1"
    // /components/com_my_component/help/en-GB/view_type1.html

    // JToolbarHelper::help( 'MY_COMPONENT_HELP_VIEW_TYPE1', false, '', 'com_mycomponent' );
    // MY_COMPONENT_HELP_VIEW_TYPE1="http://www.example.com/{component}/{keyref}/{langcode}"
    // http://www.example.com/com_mycomponent/view_type1/en

  }


	/**
	 * Renders the toolbar for the component's Read pages
   * 
   * @TODO: Where is this used? All admin item views are edit views
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

    $user = $this->container->platform->getUser();

    $this->renderTitle('add');

    // #1 "Save" button
		($this->perms->edit || $this->perms->editown) && JToolBarHelper::apply();

    // #2 "Save & Close" button
    JToolBarHelper::save();

    // #3 "Save & New" button
    $this->perms->create && JToolBarHelper::custom('savenew', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);

    // #4 "Copy" button with create permission check.
		if (count($user->getAuthorisedCategories('com_content', 'core.create')) > 0)
		{
			JToolbarHelper::save2copy('article.save2copy');
    }

    // #5 "Versions" button
    if (ComponentHelper::isEnabled('com_contenthistory') && $this->container->input->get('save_history', 0) && $itemEditable)
    {
      JToolbarHelper::versions('com_content.article', $this->item->id);
    }

    // #6 "Help" button
    // @TODO: implement "Help" button

    // #7 "Close" button
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

    // #1 "Save" button
		($this->perms->edit || $this->perms->editown) && JToolBarHelper::apply();

    // #2 "Save & Close" button
    JToolBarHelper::save();

    // #3 "Save & New" button
		($this->perms->create) && JToolBarHelper::custom('savenew', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);

    // @TODO: "Save as Copy" button

    // @TODO: "Versions" button

    // @TODO: "Help" button

    // #4 "Close" button
		JToolBarHelper::cancel();
  }


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
}
