<?php
/**
 * Job Postings HTML View
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\View\JobPostings;

use FOF30\Container\Container;
use JComponentHelper;
use JFactory;

// no direct access
defined('_JEXEC') or die;

if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

class Html extends \FOF30\View\DataView\Html
{
	/**
	 * The component-level parameters stored in #__extensions by com_config
	 *
	 * @var  \JRegistry
	 */
  protected $componentParams;

	/**
	 * The aggregate reviews data for each job posting
	 *
	 * @var  array  Indexed array of PHP objects containing aggregate review data
   */
   protected $aggregateReviews;

	/**
	 * Overridden. Load view-specific language file.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    // Add view template helper for Job Postings to container
    $config['template_path'] = $container->thisPath . '/ViewTemplates/JobPostings';

    parent::__construct($container, $config);

    // Using view-specific language files for maintainability
    $lang = JFactory::getLanguage();
    $lang->load('job_postings', JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_cajobboard', $lang->getTag(), true);

    // Get component parameters
    $this->componentParams = \JComponentHelper::getParams('com_cajobboard');

    // Load javascript file for Job Posting views
    $this->addJavascriptFile('media://com_cajobboard/js/Site/jobPostings.js');

    // Vendor lib for the star-rating widget
    $this->addJavascriptFile('media://com_cajobboard/js/Vendor/rater.min.js');
  }

  /*
   * Actions to take before list view is executed
   *
   * @return  void
   */
	protected function onBeforeBrowse()
	{
		// Create the lists object
    $this->lists = new \stdClass();

		// Load the Job Postings model, and set to persist state in the session
		/** @var DataModel $model */
    $model = $this->getModel()->savestate(1);

    // Relations to eager-load
    $eagerLoadModels = array(
      'hiringOrganization',
      'Places'
    );

    // Load and populate state in the model, with eager-loaded models
    $this->items = $model->with($eagerLoadModels)->get(false);

    // Get a count of total items in the model to set pagination parameters
    $this->itemCount = $model->count();

		// Number of items per page for pagination
    $displayLimit = $this->componentParams->get('job_postings_pagination_limit', 20);

		$this->lists->limitStart = $model->getState('limitstart', 0, 'int');
    $this->lists->limit = $model->getState('limit', $displayLimit, 'int');

		$model->limitstart = $this->lists->limitStart;
    $model->limit = $this->lists->limit;

    // Ordering information
    // @TODO Set options for ordering by date posted. Provide parameter to show "featured" postings
    //       on every page. Reorder to show "featured" postings first. Maybe on 'relevant_occupation_name' field
		$this->lists->order = $model->getState('filter_order', $model->getIdFieldName(), 'cmd');
    $this->lists->order_Dir = $model->getState('filter_order_Dir', null, 'cmd');

		if ($this->lists->order_Dir)
		{
			$this->lists->order_Dir = strtolower($this->lists->order_Dir);
    }

		// Set pagination
    $this->pagination = new \JPagination($this->itemCount, $this->lists->limitStart, $this->lists->limit);

    // @TODO: Move to repository as a join
    // Aggregate Review data for each job posting item
    $joinIds = array();

    foreach ($this->items as $item)
    {
      array_push($joinIds, $item->job_posting_id);
    }

    $db = $this->container->db;

    $joinIdString = '(' . implode(', ', array_map(function($item) use ($db) { return $item; }, $joinIds)) . ')';
    // '`1`, `2`'

    // Create a new query object.
    $query = $db->getQuery(true);

    $query
      ->select($db->qn(array(
        'job_postings.job_posting_id',
        'job_postings.hiring_organization',
        'aggregate_ratings.item_reviewed',
        'aggregate_ratings.rating_count',
        'aggregate_ratings.review_count',
        'aggregate_ratings.rating_value'
      )))
      ->from($db->qn('#__cajobboard_job_postings', 'job_postings'))
      ->leftJoin($db->qn('#__cajobboard_employer_aggregate_ratings', 'aggregate_ratings') . ' ON (' . $db->qn('job_postings.job_posting_id') . ' = ' . $db->qn('aggregate_ratings.item_reviewed') . ')')
      ->where($db->qn('job_posting_id') . ' IN ' . $joinIdString);

    // Reset the query using our newly populated query object.
    $db->setQuery($query);

    // Load the results as a list of stdClass objects
    $this->aggregateReviews = $db->loadObjectList();

		// Pass page params on frontend only
		if ($this->container->platform->isFrontend())
		{
			/** @var \JApplicationSite $app */
			$app = \JFactory::getApplication();
			$params = $app->getParams();
			$this->pageParams = $params;
		}
  }

  /*
   * Actions to take before item view is executed
   *
   * @return  void
   */
	protected function onBeforeRead()
	{
    parent::onBeforeRead();

    // @TODO: Move logic for returning reviews from database to Repo
    $db = $this->container->db;

    // Create a new query object.
    $query = $db->getQuery(true);

    $query
      ->select($db->qn(array(
        'job_postings.job_posting_id',
        'job_postings.hiring_organization',
        'aggregate_ratings.item_reviewed',
        'aggregate_ratings.rating_count',
        'aggregate_ratings.review_count',
        'aggregate_ratings.rating_value'
      )))
      ->from($db->qn('#__cajobboard_job_postings', 'job_postings'))
      ->leftJoin($db->qn('#__cajobboard_employer_aggregate_ratings', 'aggregate_ratings') . ' ON (' . $db->qn('job_postings.job_posting_id') . ' = ' . $db->qn('aggregate_ratings.item_reviewed') . ')')
      ->where($db->qn('job_posting_id') . ' = ' . $this->item->job_posting_id);

    // Reset the query using our newly populated query object.
    $db->setQuery($query);

    // Load the results as a list of stdClass objects
    $this->aggregateReviews = $db->loadObjectList();
  }

	/**
	 * Executes before rendering the page for the add task.
   *
   * @return  void
	 */
	protected function onBeforeAdd()
	{
    parent::onBeforeAdd();
  }

	/**
	 * Executes before rendering the page for the Edit task.
   *
   * @return  void
	 */
	protected function onBeforeEdit()
	{
    parent::onBeforeEdit();
  }
}
