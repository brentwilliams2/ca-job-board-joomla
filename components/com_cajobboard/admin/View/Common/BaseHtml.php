<?php
/**
 * Admin Base Class HTML View
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic
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
    $this->componentParams = ComponentHelper::getParams('com_cajobboard');

		// Load CSS for admin view
		if ( $this->container->platform->isBackend() )
		{
			$this->addCssFile('media://com_cajobboard/css/backend.css');
		}
  }


  /**
	 * View code to execute before rendering the page for the 'add' task.
	 */
	protected function onBeforeAdd()
	{
    $status = parent::onBeforeAdd();

    return $status;
  }


	/**
	 *  View code to execute before rendering the page for the 'edit' task.
	 */
	protected function onBeforeEdit()
	{
    $status = parent::onBeforeEdit();

    return $status;
  }


	/**
	 *  View code to execute before rendering the page for the 'read' task.
	 */
	protected function onBeforeRead()
	{
    $status = parent::onBeforeRead();

		return $status;
  }


	/**
	 * View code to execute before rendering the page for the 'browse' task. Modified to eager
   * load Author relation to Persons model and push the models to the view templates.
	 */
	protected function onBeforeBrowse()
	{
		/** @var DataModel $model */
    $model = $this->getModel();

		// Persist the state in the session
    $model->savestate(1);

		// Set eager-loaded relations if any
		if ( $withModels = $this->getBrowseViewEagerRelations() )
		{
			$model->with($withModels);
		}

		// Set a where clause on the model query
		if ( $whereClause = $this->getBrowseViewWhereClause() )
		{
			$model->whereRaw($whereClause);
		}

		// Assign items to the view
  	$this->items = $model->get();

    // Set the current pagination parameters from the state on the model and view
		$this->setPaginationParams($model);

		return true;
	}


	/**
	 * Relations to eager load in the browse view models. Override in View classes.
	 *
	 * @return array	The names of the relations to eager load, e.g. the $name parameter that sets up the relation in constructor.
	 */
	protected function getBrowseViewEagerRelations()
	{
    return array();
	}


	/**
	 * Add a 'where' clause to the browse view item query. Override in View classes.
	 *
	 * @return string		The 'where' clause string to use
	 *
	 * Usage:
	 *   $db = $model->getDbo();
   *   return $db->qn('price') . ' = ' . $db->q(12.34);
	 */
	protected function getBrowseViewWhereClause()
	{
		return null;
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

		$this->itemCount = $model->count();

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
