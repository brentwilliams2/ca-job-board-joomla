<?php
/**
 * Site Base TreeModel Class HTML View
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Site\View\Common;

//use Calligraphic\Cajobboard\Admin\View\Common\BaseTreeHtml;
use \FOF30\Container\Container;
use \FOF30\Model\DataModel;
use \FOF30\View\DataView\Html;
use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Pagination\Pagination;

// no direct access
defined('_JEXEC') or die;

// Add a path to the front-end JHTML widget directory
HTMLHelper::addIncludePath(JPATH_COMPONENT . '/Helper/Html');

class BaseTreeHtml extends Html
{
	/**
	 * A pagination helper object, set for browse views by onBeforeBrowse method
	 *
	 * @var  \Calligraphic\Cajobboard\Site\Helper\Pagination
	 */
  protected $paginationHelper;


	/**
	 * Overridden. Load view-specific language file.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
		parent::__construct($container, $config);

		// Create the lists object
    $this->lists = new \stdClass();

		$this->addDefaultCss();
	}


  /**
	 * Load CSS for site view.
	 */
	protected function addDefaultCss()
	{
    $this->addCssFile('media://com_cajobboard/css/frontend.css');
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
			$model->where($whereClause);
		}

		$rootNode = $model->getRoot();

		// Prefix each table name with this table alias in Filter WHERE clauses.
		// For example, field bar normally creates a WHERE clause:  `bar` = '1'
    // If tableAlias is set to "foo" then the WHERE clause it generates becomes:  `foo`.`bar` = '1'
		// Necessary because the getDescendants() TreeModel method uses a CROSS JOIN
		// with `parent` and `node` tables of the same model class.
    $model->setBehaviorParam('tableAlias', 'node');

		// Assign items to the view (all children, including their children, but without $rootNode)
		$this->items = $rootNode->getDescendants();

		// Create a factory Pagination helper object and assign it to an object property
		$this->paginationHelper = $this->getContainer()->Pagination;

    // Set the current pagination parameters from the state on the model and view
		$this->paginationHelper->setPaginationObject($this, $model);

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
	 *   $db = $this->getModel()->getDbo();
   *   return $db->qn('price') . ' = ' . $db->q(12.34);
	 */
	protected function getBrowseViewWhereClause()
	{
		return null;
  }


	/**
	 * Set the item count object property
	 *
	 * @param 	int 	$value
	 *
	 * @return 	void
	 */
	public function setItemCount($value)
	{
		return $this->itemCount = $value;
	}


	/**
	 * Set the pagination object of this view
	 *
	 * @param 	Pagination 	$object		A Joomla! Pagination object to set on the property.
	 *
	 * @return void
	 */
	public function setPagination(Pagination $object)
	{
		return $this->pagination = $object;
	}


	/**
	 * Magic get method. Handles magic properties:
	 * $this->input  mapped to $this->container->input
	 *
	 * @param   string  $name  The property to fetch
	 *
	 * @return  mixed|null
	 */
	public function __set($property, $value)
	{
		if (property_exists($this, $property))
		{
      $this->$property = $value;
    }

    return $this;
	}


	/**
	 * Magic get method. Handles magic properties:
	 * $this->input  mapped to $this->container->input
	 *
	 * @return  boolean
	 */
	public function isUserLoggedIn()
	{
		return (bool) $this->getContainer()->platform->getUser()->id;
	}
}
