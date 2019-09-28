<?php
/**
 * Site Base Class for HTML View
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Site\View\Common;

use \FOF30\Container\Container;
use \FOF30\Model\DataModel\Collection;
use \FOF30\Model\Model\DataModel;
use \Calligraphic\Cajobboard\Admin\View\Common\BaseHtml as AdminBaseHtml;
use \Joomla\CMS\Helper\TagsHelper;
use \Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;

class BaseHtml extends AdminBaseHtml
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

    // Load CSS for site view
    $this->addCssFile('media://com_cajobboard/css/frontend.css');
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
	 *  View code to execute before rendering the page for the 'browse' task.
	 */
	protected function onBeforeBrowse()
	{
    $status = parent::onBeforeBrowse();

		return $status;
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
