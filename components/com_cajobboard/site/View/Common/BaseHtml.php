<?php
/**
 * Answers Site Base Class for HTML View
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Site\View\Common;

use \Calligraphic\Cajobboard\Admin\View\Exception\InvalidArgument;
use \Calligraphic\Cajobboard\Site\Helper\Pagination;
use \Calligraphic\Cajobboard\Site\Helper\Semantic;
use \FOF30\Container\Container;
use \FOF30\Model\DataModel;
use \FOF30\View\DataView\Html;
use \Joomla\CMS\Component\ComponentHelper;
use \Joomla\CMS\Document\Document;
use \Joomla\CMS\Factory;
use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\Registry\Registry;

// no direct access
defined('_JEXEC') or die;

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/Helper/Html');

class BaseHtml extends Html
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

    // Get component parameters
    // @TODO: Not already being done somewhere else?
    $this->componentParams = ComponentHelper::getParams('com_cajobboard');

    // Load CSS for site view
    $this->addCssFile('media://com_cajobboard/css/frontend.css');

    // Set the page parameters on the class, the base class does this for browse views only

    /** @var \Joomla\CMS\Application\SiteApplication $app */
    $app = Factory::getApplication();

    // @TODO: check if it's already done first? where is it being done?
    $this->pageParams = $app->getParams();

    $semanticHelper = new Semantic($this);

    $semanticHelper->setPageTitle();
    $semanticHelper->addOpenGraphMetaTags();

    $this->setMetadataHeaders();
  }


  /**
	 * Set the metadata headers in site views (author and robots)
   *
   * <meta name="robots" content="index|noindex, follow|nofollow" />
   *
   * index      Allow search engines to add the page to their index, so that it can be discovered by people searching. Default if tag missing.
   * noindex    Disallow search engines from adding this page to their index, and therefore disallow them from showing it in their results.
   * follow     Tells the search engines that it may follow links on the page, to discover other pages. Default if tag missing.
   * nofollow   Tells the search engines robots to not follow any links on the page.
   *
   * @param   string  $view   The name of the view, lowercased, to load a language file for
	 */
	public function setMetadataHeaders()
	{
    /** @var DataModel $model */
		$model = $this->getModel();

    /** @var Document $document */
    $document = $this->container->platform->getDocument();

    $document->setMetaData( 'robots', $model->params->get('robots', 'index, follow') );

    if ( $author = $model->params->get('author') )
    {
      $document->setMetaData($author);
    }

    if ( $keywords = $model->metakey )
    {
      $document->setMetaData('keywords', $keywords);
    }
  }

  /**
	 * Load the language file for this view
   *
   * @param   string  $view   The name of the view, lowercased, to load a language file for
	 */
	public function loadLanguageFileForView($view)
	{
    // @TODO: is FOF30 Dispatcher already loading the component language file? Should we split admin/site language files?

    // Using view-specific language files for maintainability
    $lang = Factory::getLanguage();

    // Load Answers language file, using combined admin/site language file
    $lang->load($view, JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_cajobboard', $lang->getTag(), true);
  }


  /**
	 * Executes before rendering the page for the add task.
   *
   * The model is pushed into the View by the Controller. As you can see in DataController::add() it is possible
   * to push both default values (defaultsForAdd) as well as data from the state (e.g. when saving a new record
   * failed for some reason and the user needs to edit it). That's why we populate defaultFields from $model. We
   * still do a full reset on a clone of the Model to get a clean object and merge default values (instead of null
   * values) with the data pushed by the controller.
	 */
	protected function onBeforeAdd()
	{
		/** @var DataModel $model */
    $model = $this->getModel();

    $defaultFields = $model->getData();

    $this->item = $model->getClone()->reset(true, true);

		foreach ($defaultFields as $k => $v)
		{
			try
			{
				$this->item->setFieldValue($k, $v);
			}
			catch (\Exception $e)
			{
				// Suppress errors in field assignments at this stage
			}
		}
  }


	/**
	 * Executes before rendering the page for the Edit task.
	 */
	protected function onBeforeEdit()
	{
		/** @var DataModel $model */
    $model = $this->getModel();

		// It seems that I can't edit records, maybe I can edit only this one due asset tracking?
		if (!$this->permissions->edit || !$this->permissions->editown)
		{
			if ($model)
			{
				// Record is tracked, check whether user can edit this record
				if ($model->isAssetsTracked())
				{
          $platform = $this->container->platform;

					if (!$this->permissions->edit)
					{
						$this->permissions->edit = $platform->authorise('core.edit', $model->getAssetName());
          }

					if (!$this->permissions->editown)
					{
						$this->permissions->editown = $platform->authorise('core.edit.own', $model->getAssetName());
					}
				}
			}
    }

		$this->item = $model->findOrFail();
  }


	/**
	 * Executes before rendering the page for the Read task.
	 */
	protected function onBeforeRead()
	{
		/** @var DataModel $model */
    $model = $this->getModel();

		$this->item = $model->findOrFail();
  }


	/**
	 * Setup for the browse task, called from onBeforeBrowse() View method.
   * This allows using an onBeforeBrowse() method in inherited views that
   * just sets up the correct relations for the model, functionality not
   * default to FOF30 base Raw view's onBeforeBrowse() method.
   *
   * @param   Array   $withModels   Array of relations for the model to eager load.
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

    $this->setPagination($model);
  }


	/**
	 * Set the pagination object for this view. This logic is refactored
   * out of the base Raw view's onBeforeBrowse() method.
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
      $app = Factory::getApplication();
      $defaultLimit = $app->get('list_limit', 20);
    }

    $this->lists->limitStart = $model->getState('limitstart', 0, 'int');
    $this->lists->limit = $model->getState('limit', $defaultLimit, 'int');

    $model->limitstart = $this->lists->limitStart;
    $model->limit = $this->lists->limit;

    // Ordering information
    // @TODO: This is always ordering by record number, we want to display by "featured" at top and by date or other criteria like in admin section for Answers
		$this->lists->order = $model->getState('filter_order', $model->getIdFieldName(), 'cmd');
    $this->lists->order_Dir = $model->getState('filter_order_Dir', null, 'cmd');

		if ($this->lists->order_Dir)
		{
			$this->lists->order_Dir = strtolower($this->lists->order_Dir);
    }
  }

  /*
   * Create a Pagination object by querying the DB for a count of total items,
   * based on the previous query filters used to actually fetch the data.
   *
   * @param  DataModel  $model    The model object for this view
	 *
	 * @return void
   */
  public function setPagination(DataModel $model)
	{
    // Run a "count all" query on the DB
    $this->itemCount = $model->count();

    // Create the view's pagination object with results from the model
    $this->pagination = new Pagination($this->itemCount, $this->lists->limitStart, $this->lists->limit);
  }
}
