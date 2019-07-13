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

namespace Calligraphic\Cajobboard\Admin\View\Common;

use \Joomla\CMS\Factory;
use \Joomla\Registry\Registry;
use \Joomla\CMS\Pagination\Pagination;
use \Joomla\CMS\Component\ComponentHelper;
use \Joomla\CMS\HTML\HTMLHelper;
use \FOF30\Container\Container;
use FOF30\Model\DataModel;
use FOF30\Model\DataModel\Collection;
use \FOF30\View\DataView\Html;
use Calligraphic\Cajobboard\Admin\View\Exception\InvalidArgument;

// no direct access
defined('_JEXEC') or die;

if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

HTMLHelper::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/Helper/Html');

class BaseHtml extends Html
{
	/**
	 * The component-level parameters stored in #__extensions by com_config
	 *
	 * @var  Registry
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

    // Get component parameters
    // @TODO: Need page prameters for front-end only?
    $this->componentParams = ComponentHelper::getParams('com_cajobboard');

    // Load CSS for admin view
    $this->addCssFile('media://com_cajobboard/css/backend.css');
  }


  /**
	 * Load the language file for this view
	 */
	public function loadLanguageFileForView($view)
	{
    // @TODO: is FOF30 Dispatcher already loading the component language file?

    // Using view-specific language files for maintainability
    $lang = $this->container->platform->getLanguage();

    // Load Answers language file
    $lang->load($view, JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_cajobboard', $lang->getTag(), true);
  }


  /**
	 * Executes before rendering the page for the add task.
	 */
	protected function onBeforeAdd()
	{
    parent::onBeforeAdd();
  }


	/**
	 * Executes before rendering the page for the Edit task.
	 */
	protected function onBeforeEdit()
	{
    parent::onBeforeEdit();
  }


	/**
	 * Executes before rendering the page for the Read task.
	 */
	protected function onBeforeRead()
	{
		parent::onBeforeRead();
  }


	/**
	 * Setup for the browse task, called from onBeforeBrowse() View method
	 */
	protected function setupBrowse($withModels)
	{
		/** @var DataModel $model */
    $model = $this->getModel();

		// Persist the state in the session
    $model->savestate(1);

    // Set the current pagination parameters from the state on the model and view
    $this->setPaginationParams($model);

		// Assign items to the view
    $this->items = $model->with($withModels)->get();

    $this->itemCount = $model->count();

    // Create the view's pagination object with results from the model
    $this->pagination = new Pagination($this->itemCount, $this->lists->limitStart, $this->lists->limit);
  }


	/**
	 * Set the pagination object for this view
   *
   * @param  DataModel  $model    The model object for this view
	 *
	 * @return void
	 */
	public function setPaginationParams(DataModel $model)
	{
    // Display limits
    $defaultLimit = 20;

  	// Create the lists object
    $this->lists = new \stdClass();

    if (!$this->container->platform->isCli())
    {
      $app = $this->container->platform->getApplication();
      $defaultLimit = $app->get('list_limit', 20);
    }

    $this->lists->limitStart = $model->getState('limitstart', 0, 'int');
    $this->lists->limit = $model->getState('limit', $defaultLimit, 'int');

    $model->limitstart = $this->lists->limitStart;
    $model->limit = $this->lists->limit;

		// Ordering information
		$this->lists->order = $model->getState('filter_order', $model->getIdFieldName(), 'cmd');
    $this->lists->order_Dir = $model->getState('filter_order_Dir', null, 'cmd');

		if ($this->lists->order_Dir)
		{
			$this->lists->order_Dir = strtolower($this->lists->order_Dir);
    }

		// Pagination
    $this->pagination = new Pagination($this->itemCount, $this->lists->limitStart, $this->lists->limit);
  }
}
