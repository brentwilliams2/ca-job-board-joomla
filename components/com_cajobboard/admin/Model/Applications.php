<?php
/**
 * Admin Applications Model
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model;

// no direct access
defined('_JEXEC') or die;

use \FOF30\Container\Container;
use \Calligraphic\Cajobboard\Admin\Model\BaseDataModel;

/**
 * Fields:
 *
 * UCM
 * @property int            $application_id   Surrogate primary key.
 * @property string         $slug             Alias for SEF URL.
 *
 * FOF "magic" fields
 * @property int            $asset_id           FK to the #__assets table for access control purposes.
 * @property int            $access             The Joomla! view access level.
 * @property int            $enabled            Publish status: -2 for trashed and marked for deletion, -1 for archived, 0 for unpublished, and 1 for published.
 * @property string         $created_on         Timestamp of record creation, auto-filled by save().
 * @property int            $created_by         User ID who created the record, auto-filled by save().
 * @property string         $modified_on        Timestamp of record modification, auto-filled by save(), touch().
 * @property int            $modified_by        User ID who modified the record, auto-filled by save(), touch().
 * @property string         $locked_on          Timestamp of record locking, auto-filled by lock(), unlock().
 * @property int            $locked_by          User ID who locked the record, auto-filled by lock(), unlock().
 *
 * SCHEMA: Joomla UCM fields, used by Joomla!s UCM when using the FOF ContentHistory behaviour
 * @property string         $publish_up       Date and time to change the state to published, schema.org alias is datePosted.
 * @property string         $publish_down     Date and time to change the state to unpublished.
 * @property int            $version          Version of this item.
 * @property int            $ordering         Order this record should appear in for sorting.
 * @property object         $metadata         JSON encoded metadata field for this item.
 * @property string         $metakey          Meta keywords for this item.
 * @property string         $metadesc         Meta description for this item.
 * @property string         $xreference       A reference to enable linkages to external data sets, used to output a meta tag like FB open graph.
 * @property string         $params           JSON encoded parameters for this item.
 * @property string         $language         The language code for the article or * for all languages.
 * @property int            $cat_id           Category ID for this item.
 * @property int            $hits             Number of hits the item has received on the site.
 * @property int            $featured         Whether this item is featured or not.
 * @property string         $note             A note to save with this item for use in the back-end interface.
 *
 * SCHEMA: Thing
 * @property string         $name             A title to use for the application.
 * @property string         $description      A description of the application.
 * @property string         $description__intro   Short description of the item, used for the text shown on social media via shares and search engine results.
 */
class Applications extends BaseDataModel
{
  use \FOF30\Model\Mixin\Assertions;

	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    /* Set up config before parent constructor */

    // Not using convention for table names or primary key field
		$config['tableName'] = '#__cajobboard_applications';
    $config['idFieldName'] = 'application_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.applications';

    // Set an alias for the title field for DataModel's check() method's slug field auto-population
    $config['aliasFields'] = array('title' => 'name');

    // Add behaviours to the model. Filters, Created, and Modified behaviours are added automatically.
    $config['behaviours'] = array(
      'Access',     // Filter access to items based on viewing access levels
      'Assets',     // Add Joomla! ACL assets support
      //'ContentHistory', // Add Joomla! content history support
      //'Own',        // Filter access to items owned by the currently logged in user only
      //'PII',        // Filter access for items that have Personally Identifiable Information. ONLY for ATS screens, use view template PII access control for individual fields
      //'Tags'        // Add Joomla! Tags support
    );

    /* Parent constructor */
    parent::__construct($container, $config);

    /* Set up relations after parent constructor */

    // many-to-many FK to #__cajobboard_questions using join table #__cajobboard_q_a_pages_questions
    $this->belongsToMany('Questions', 'Questions@com_cajobboard', 'application_id', 'question_id', '#__cajobboard_applications_questions');

    // one-to-many FK to #__cajobboard_answers, key in foreign table
    // @TODO: Answers table uses STI, so need to filter on 'about__foreign_model_name' = 'QAPages'. Note we've stuffed an 'is_required' field into the join table.
    $this->hasMany('Answers', 'Answers@com_cajobboard', 'q_a_page_id', 'is_part_of');

    // Many-to-one FK to  #__cajobboard_persons
    $this->belongsTo('MainEntityOfPage', 'Persons@com_cajobboard', 'main_entity_of_page', 'id');

    // Many-to-one FK to  #__cajobboard_question_lists
    $this->belongsTo('AboutQuestionList', 'QuestionLists@com_cajobboard', 'about__question_list', 'question_list_id');
  }

  // @TODO: Need ability to mark questions as "must-have", so candidates can be rejected if they don't have it e.g. "has visa"


  /**
   * Perform necessary tasks after creation of a new Application
   *
   * @return void
   */
  public function onAfterCreate()
  {
    $this->cloneApplicationQuestions();

    $this->createCandidate();

    $this->redirectToSimilarJobPostings();
  }


  /**
   * Uses the QuestionList model to clone the Question List join table records for a given
   * QuestionList item (#__cajobboard_question_lists_questions) into the join table for this
   * Application item (#__cajobboard_applications_questions), substituting this item's
   * 'application_id' field value for QuestionList's 'question_list_id'
   *
   * @return void
   */
  public function cloneApplicationQuestions()
  {
    $questionListModel = $this->container->factory->model('QuestionLists', array('factoryClass' => 'FOF30\\Factory\\MagicFactory'));

    $questionListModel->cloneQuestionListToForeignModel($this->getQuestionListId(), '#__cajobboard_applications_questions', 'application_id');
  }


  /**
   * @TODO: MOVE TO CONTROLLER!!!
   * Create a Candidate in the ATS workflow in response to a job seeker submitting an Application
   *
   * @return void
   *
   */
  public function createCandidate()
  {
    // @TODO: implement creating candidate from Application on after create
  }


  /**
   * Redirect on successful Application creation to Job Postings browse view filtered on similar jobs
   *
   * @return void
   *
   */
  public function redirectToSimilarJobPostings()
  {
    // @TODO: implement redirect
  }


  /**
   * Get the ID of the Question List to use for this application, set as the default to use in WorkFlows
   *
   * @return void
   *
   */
  public function getQuestionListId()
  {
    // should have 'about__job_posting' input variable, which can be used to get the workflow template for that job posting

    // @TODO: $this->getFieldValue('about__question_list')
  }



  /**
   * Toggle whether Application is locked or not
   *
   * @return void
   *
   */
  public function setApplicationLocking($isLocked = false)
  {
    /*
    @TODO:    locked_on   and   locked_by   handling
    Need option to handle "locking" an application, so a job seeker can't change it after it's submitted: how to do this?
    There needs to be a special button to message a job seeker from a received application to ask for changed / additional
    information, and unlock the application until that happens. Needs to message back to the employer when the changes are made.
    */
  }
}
