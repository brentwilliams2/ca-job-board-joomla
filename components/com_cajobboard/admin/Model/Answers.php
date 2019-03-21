<?php
/**
 * Answers Admin Model
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model;

// no direct access
defined('_JEXEC') or die;

use FOF30\Container\Container;
use FOF30\Model\DataModel;
use JFilterOutput;
use JLog;

/**
 * Model class description
 *
 * Fields:
 *
 * UCM
 * @property int            $id               Surrogate primary key.
 * @property string         $slug             Alias for SEF URL.
 * @property bool           $featured         Whether this answer is featured or not.
 * @property int            $hits             Number of hits this answer has received.
 * @property int            $created_by       Userid of the creator of this answer.
 * @property string         $createdOn        Date this answer was created.
 * @property int            $modifiedBy       Userid of person that last modified this answer.
 * @property string         $modifiedOn       Date this answer was last modified.
 *
 * SCHEMA: Thing
 * @property string         $name             A title to use for the answer.
 * @property string         $description      A description of the answer.
 *
 * SCHEMA: CreativeWork
 * @property QAPage         $isPartOf         This property points to a QAPage entity associated with this answer. FK to #__cajobboard_qapage(qapage_id).
 * @property Organization   $Publisher        The company that wrote this answer. FK to #__organizations(organization_id).
 * @property string         $text             The actual text of the answer itself.
 * @property Person         $Author           The author of this comment.  FK to #__persons.
 *
 * SCHEMA: Answer
 * @property Question       $parentItem       The question this answer is intended for. FK to #__cajobboard_questions(question_id).
 * @property int            $upvote_count     Upvote count for this item.
 * @property int            $downvote_count   Downvote count for this item.
 */
class Answers extends DataModel
{
  use \Calligraphic\Cajobboard\Admin\Helper\AssetHelperTrait;

	/**
	 * Public constructor. Overrides the parent constructor.
	 *
	 * @see DataModel::__construct()
	 *
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    // Not using convention for table names or primary key field
		$config['tableName'] = '#__cajobboard_answers';
    $config['idFieldName'] = 'answer_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.answers';

    // Add behaviours to the model
    $config['behaviours'] = array('Filters', 'Language', 'Tags');

    // Parent constructor
    parent::__construct($container, $config);

    // Set `filter_order` state variable to use the ordering column, for Joomla!'s
    // administrator browse view panel drag-and-drop ordering functionality
    $this->setState('filter_order', 'ordering');

    /* Set up relations */

    // one-to-one FK to #__cajobboard_qapage
    $this->hasOne('isPartOf', 'QAPages@com_cajobboard', 'is_part_of', 'qapage_id');

    // many-to-one FK to  #__organizations
    $this->belongsTo('Publisher', 'Organizations@com_cajobboard', 'publisher', 'organization_id');

    // one-to-one FK to  #__cajobboard_questions
    $this->hasOne('parentItem', 'Questions@com_cajobboard', 'parent_item', 'question_id');

    // one-to-one FK to  #__cajobboard_persons
     $this->hasOne('Author', 'Persons@com_cajobboard', 'created_by', 'id');
  }


  /**
	 * Perform checks on data for validity
	 *
	 * @return  static  Self, for chaining
	 *
	 * @throws \RuntimeException  When the data bound to this record is invalid
	 */
	public function check()
	{
    // @TODO: Make sure a default category for com_cajobboard ({title, path, alias}=uncategorized)
    // exists in #__categories, and that the default category is set for this item if nothing else is set
    // Most categories are the same as their model name, except for Persons
    // (Connectors, Employers, Job Seekers, and Recruiters)

    // Make sure slug is populated from the answer title, if it is left empty
    if(!$this->slug)
    {
      $this->makeSlug();
    }

    // Answer title ('name' column in DB) and description are required
    $this->assertNotEmpty($this->name, 'COM_CAJOBBOARD_EDIT_TITLE_ERR');
    $this->assertNotEmpty($this->description, 'COM_CAJOBBOARD_EDIT_DESCRIPTION_ERR');

		parent::check();

    return $this;
  }


   /*
   * Handle creating ACL record after creating a new Answer record
   */
  protected function onAfterCreate()
  {
    if($this->isAssetsTracked())
    {
      // Get the JTableAsset object for this item's asset name
      $assetModel = $this->getAsset();

      // Get the ID of the parent asset object for this item
      $assetModel->parent_id = $this->getCategoryAssetID();
      $assetModel->name = $this->getAssetName();
      $assetModel->rules = (string) $this->getRules();

      $assetId = $this->saveAssetRecord($assetModel);

      $this->setFieldValue('asset_id', $assetId);

      $this->save();
    }
  }


  /*
   * Handle deleting the ACL record after an Answer record is deleted
   */
  protected function onAfterDelete()
  {
    $this->removeAssetRecord();
  }


  /*
   * Handle updating ACL record after editing an Answer record
   */
  protected function onAfterUpdate()
  {
    // @TODO: implement to check when the permissions page is changed on an admin edit screen
  }


  /*
   * Handle the 'metadata' JSON field
   */
  protected function onBeforeSave($data)
  {
    // @TODO: author and robot fields are not handling JRegistry metadata field correctly.
    // Set 'metadata' field to new JRegistry object when save is for a new item (add task)
    if (!is_object($this->metadata) && (!$this->metadata instanceof \JRegistry))
    {
      var_dump('why are we here?');
      die();
      $this->metadata = new \JRegistry();
    }

    $this->metadata->set('author', $this->input->get('metadata_author'));
    $this->metadata->set('robots', $this->input->get('metadata_robots'));
  }


  /**
	 * Transform 'metadata' field to a JRegistry object on bind
	 *
	 * @return  static  Self, for chaining
	 *
	 * @throws \RuntimeException  When the data bound to this record is invalid
	 */
  protected function getMetadataAttribute($value)
  {
    // Make sure it's not a JRegistry already
    if (is_object($value) && ($value instanceof \JRegistry))
    {
        return $value;
    }

    // Return the data transformed to a JRegistry object
    return new \JRegistry($value);
  }


  /**
	 * Transform 'metadata' field's JRegistry object to a JSON string before save
	 *
	 * @return  static  Self, for chaining
	 *
	 * @throws \RuntimeException  When the data bound to this record is invalid
	 */
  protected function setMetadataAttribute($value)
  {
    // Make sure it a JRegistry object, otherwise return the value
    if (!is_object($value) || !($value instanceof \JRegistry))
    {
      return $value;
    }

    // Return the data transformed to JSON
    return $value->toString('JSON');
  }


  /**
	 * Create a slug from the answer title
	 *
	 * @return  static  Self, for chaining
	 *
	 * @throws \RuntimeException  When the data bound to this record is invalid
	 */
  protected function makeSlug()
  {
    $this->slug = JFilterOutput::stringURLSafe($this->name);
  }
}
