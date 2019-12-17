<?php
/**
 * Admin Collection container for Questions Model
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
 * @property int            $question_list_id   Surrogate primary key.
 * @property string         $slug             Alias for SEF URL.
 *
 * FOF "magic" fields
 * @property int            $asset_id         FK to the #__assets table for access control purposes.
 * @property int            $access           The Joomla! view access level.
 * @property int            $enabled          Publish status: -2 for trashed and marked for deletion, -1 for archived, 0 for unpublished, and 1 for published.
 * @property string         $created_on       Timestamp of record creation, auto-filled by save().
 * @property int            $created_by       User ID who created the record, auto-filled by save().
 * @property string         $modified_on      Timestamp of record modification, auto-filled by save(), touch().
 * @property int            $modified_by      User ID who modified the record, auto-filled by save(), touch().
 * @property string         $locked_on        Timestamp of record locking, auto-filled by lock(), unlock().
 * @property int            $locked_by        User ID who locked the record, auto-filled by lock(), unlock().
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
 * @property string         $name             A title to use for the question list.
 * @property string         $description      A description of the question list.
 * @property string         $description__intro   Short description of the item.
 *
 * SCHEMA: CreativeWork
 * @property string         $about__foreign_model_name    The name of the foreign model this question list belongs to.
 */
class QuestionLists extends BaseDataModel
{
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
		$config['tableName'] = '#__cajobboard_question_lists';
    $config['idFieldName'] = 'question_list_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.question_lists';

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

    // Many-to-one FK to  #__cajobboard_organizations
    $this->belongsTo('AboutOrganization', 'Organizations@com_cajobboard', 'about__organization', 'organization_id');

    // many-to-one FK to  #__cajobboard_persons
    $this->belongsTo('Author', 'Persons@com_cajobboard', 'created_by', 'id');

    // many-to-many FK to #__cajobboard_questions using join table #__cajobboard_q_a_pages_questions
    $this->belongsToMany('Questions', 'Questions@com_cajobboard', 'question_list_id', 'question_id', '#__cajobboard_question_lists_questions');
  }

  // @TODO: Need ability to mark questions as "must-have", so candidates can be rejected if they don't have it

  // @TODO: A value of 0 for about__organization indicates general-purpose question_list templates, how to implement this with relations? What hook to catch before relations loaded?


  /**
   * Uses the QuestionList model to clone the Question List join table records for a given
   * QuestionList item (#__cajobboard_question_lists_questions) into the join table for the
   * foreign model item (#__cajobboard_foreign_model_name_questions), substituting this item's
   * 'foreign_model_name_id' field value for QuestionList's 'question_list_id'
   *
   * @param int    $questionListIdValue   The id value of the question list to use as a template
   * @param string $foreignTableName      The name of the foreign model, e.g. '#__cajobboard_applications' or '#__cajobboard_interviews'.
   * @param string $foreignIdFieldName    The name of the foreign model primary key, e.g. 'application_id'.
   *
   * @return void
   *
   * Usage in foreign model:
   *
   * $questionListModel = $this->container->factory->model('QuestionLists', array('factoryClass' => 'FOF30\\Factory\\MagicFactory'));
   * $questionListModel->cloneQuestionListToForeignModel($questionListIdValue, $foreignTableName, $foreignIdFieldName);
   */
  public function cloneQuestionListToForeignModel($questionListIdValue, $foreignTableName, $foreignIdFieldName)
  {
    // @TODO: clone the questions associated with a given question list to the appropriate join table, e.g. #__cajobboard_question_lists_questions
  }
}
