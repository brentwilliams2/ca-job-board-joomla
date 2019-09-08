<?php
/**
 * Site Base Class for HTML View
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Site\View\Common;

use \FOF30\Container\Container;
use \FOF30\Model\DataModel\Collection;
use \FOF30\Model\Model\DataModel;
use \FOF30\View\DataView\Html;
use \Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;

class BaseHtml extends Html
{
  /**
   * Whether a combo box to choose the number of results per page should
   * be shown on browse views
   *
   * @property  boolean
   */
  public $showLimitBox;


  /**
   * Whether the pagination links should be shown at the bottom of browse views
   *
   * @property  boolean
   */
   public $showPagesLinks;


	/**
	 * Overridden. Load view-specific language file.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);
  }


  /**
   * Override parent display method to add semantic headers. Parent method has
   * onAfter{task} methods, but no generic event to catch for this.
   *
   * @param string  $tpl   The name of the template file to parse
   *
   * @return void
   */
  public function display($tpl = null)
	{
    $status = parent::display($tpl);

    $this->container->Semantic->setSemanticHeaders($this);

    return $status;
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
		/** @var \FOF30\Model\DataModel $model */
    $model = $this->getModel();

		// Persist the state in the session
    $model->savestate(1);

    // Set the current pagination parameters from the state on the model and view
    $paginationOptions = $this->container->Pagination->getPaginationParams($model);

		// Assign items to the view
    $this->items = $model->with($withModels)->get();

    // Return a pagination object using the state set previously and the results of the model query
    $this->pagination = $this->container->Pagination->getPaginator($model, $paginationOptions);

    $this->showLimitBox = $model->getState('showLimitBox', true);
  }


  /**
   * Returns true if the item property is set to a DataModel
   *
   * @return boolean
   */
  public function isItem()
	{
    return $this->item instanceof DataModel;
  }


  /**
   * Returns true if the items property is a Collection of DataModels
   *
   * @return boolean
   */
  public function isCollection()
	{
    return $this->items instanceof Collections;
  }


  /**
   * Indicate whether the user is registered and logged in
   *
   * @return  boolean   Returns true if the user is registered and logged in
   */
  public function isUserLoggedIn()
  {
    // current user ID
    $userId = $this->container->platform->getUser()->id;

    return $userId != 0;
  }


  /**
   * Test whether the current task matches a parameter
   *
   * @param   string    $task   The name of the task to compare to the current task
   *
   * @return  boolean   Returns true if the current task matches the parameter
   */
   public function isTask($task)
   {
     return $this->getTask() == $task;
   }


  /**
   * Returns the title for the model item if it's set, or placeholder text for new records
   *
   * @param   string    $item
   *
   * @return  boolean
   */
  public function getTitle($item)
  {
    if ( isset($item->title) )
    {
      return $item->title;
    }

    // e.g. JobPostings
    $viewName = $this->getName();

    // e.g. COM_CAJOBBOARD_JOB_POSTINGS_TITLE_EDIT_PLACEHOLDER
    $translationKey = 'COM_CAJOBBOARD_' . strtoupper( $this->container->inflector->underscore($viewName) ) . '_TITLE_EDIT_PLACEHOLDER';

    return Text::_($translationKey);
  }


  /**
   *
   *
   * @param   string    $item
   *
   * @return  boolean
   */
  public function getTags($item)
  {
    // Get Joomla! tags
    // \Site\Model\JobPostings: protected '_has_tags' => boolean false
    $tags = new TagsHelper;

    return $tags->getItemTags('com_cajobboard.jobpostings', $item->id);
  }


  /**
   * Build the URL to for the form's action attribute
   *
   * @return  string   Returns the fully-qualified path to submit the form to
   */
  public function getFormActionUrl()
  {
    $url = 'index.php?option=' . $this->getContainer()->componentName . '&view=' . $this->getName();

    if ( $this->isTask('edit') )
    {
      $url .= '&id=' . $this->getItem()->getId();
    }

    return $url;
  }
}
