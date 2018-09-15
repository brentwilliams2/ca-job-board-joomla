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
use Jlog;

// no direct access
defined('_JEXEC') or die;

if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

class Html extends \FOF30\View\DataView\Html
{
	/**
	 * The component-level parameters stored in #__extensions by com_config
	 *
	 * @var   \JRegistry
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
    $config['template_path'] = $container->thisPath . '/ViewTemplates/JobPostings';

    parent::__construct($container, $config);

    // Using view-specific language files for maintainability
    $lang = JFactory::getLanguage();
    $lang->load('job_postings', JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_cajobboard', $lang->getTag(), true);

    // Get component parameters
    $this->componentParams = \JComponentHelper::getParams('com_cajobboard');

    // Load javascript file for Job Posting views
    $this->addJavascriptFile('media://com_cajobboard/js/jobPostings.js');
  }

  /*
   * Actions to take before list view is executed
   *
   * @return  void
   */
	protected function onBeforeBrowse()
	{
    JLog::add('onBeforeBrowse() in Html View called', JLog::DEBUG, 'cajobboard');

		// Create the lists object
    $this->lists = new \stdClass();

		// Load the model
		/** @var DataModel $model */
    $model = $this->getModel();

		// We want to persist the state in the session
    $model->savestate(1);

    // Assign items to the view
    $eagerLoadModels = array(
      'hiringOrganization',
      'Places'
    );

    // Load and populate state in the model, with eager-loaded models
    $this->items = $model->with($eagerLoadModels)->get(false);

    $this->itemCount = $model->count();

		// Display limits
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

		// Pagination
    $this->pagination = new \JPagination($this->itemCount, $this->lists->limitStart, $this->lists->limit);
  }

  /*
   * Actions to take before item view is executed
   *
   * @return  void
   */
	protected function onBeforeRead()
	{
    JLog::add('onBeforeRead() in Html View called', JLog::DEBUG, 'cajobboard');

    parent::onBeforeRead();
  }

	/**
	 * Executes before rendering the page for the add task.
   *
   * @return  void
	 */
	protected function onBeforeAdd()
	{
    JLog::add('onBeforeAdd() in Html View called', JLog::DEBUG, 'cajobboard');

    parent::onBeforeAdd();
  }

	/**
	 * Executes before rendering the page for the Edit task.
   *
   * @return  void
	 */
	protected function onBeforeEdit()
	{
    JLog::add('onBeforeEdit() in Html View called', JLog::DEBUG, 'cajobboard');

    parent::onBeforeEdit();
  }
}
