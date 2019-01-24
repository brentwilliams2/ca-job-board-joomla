<?php
/**
 * Answers Model
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

/**
 * Model class description
 *
 * Fields:
 *
 * UCM
 * @property int            $answer_id       Surrogate primary key.
 * @property string         $slug            Alias for SEF URL.
 * @property bool           $featured        Whether this answer is featured or not.
 * @property int            $hits            Number of hits this answer has received.
 * @property int            $created_by      Userid of the creator of this answer.
 * @property string         $createdOn       Date this answer was created.
 * @property int            $modifiedBy      Userid of person that last modified this answer.
 * @property string         $modifiedOn      Date this answer was last modified.
 *
 * SCHEMA: Thing
 * @property string         $name            A title to use for the answer.
 * @property string         $description     Alias of the author.
 *
 * SCHEMA: CreativeWork
 * @property QAPage         $isPartOf         This property points to a QAPage entity associated with this answer. FK to #__cajobboard_qapage(qapage_id).
 * @property Organization   $Publisher        The company that wrote this answer. FK to #__organizations(organization)id).
 * @property string         $text             The actual text of the answer itself.
 *
 * SCHEMA: Answer
 * @property Question       $parentItem       The question this answer is intended for. FK to #__cajobboard_questionss(question_id).
 * @property int            $upvote_count     Upvote count for this item.
 * @property int            $downvote_count   Downvote count for this item.
 */
class Answers extends DataModel
{
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

    parent::__construct($container, $config);

    /*
     * Set up relations
     */

    // one-to-one FK to #__cajobboard_qapage
    $this->hasOne('isPartOf', 'QAPages@com_cajobboard', 'is_part_of', 'qapage_id');

    // many-to-one FK to  #__organizations
    $this->belongsTo('Publisher', 'Organizations@com_cajobboard', 'publisher', 'organization_id');

    // one-to-one FK to  #__cajobboard_questions
    $this->hasOne('parentItem', 'Questions@com_cajobboard', 'parent_item', 'question_id');
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
    $this->assertNotEmpty($this->title, 'COM_CAJOBBOARD_ANSWER_ERR_TITLE');
    $this->assertNotEmpty($this->description, 'COM_CAJOBBOARD_ANSWER_ERR_DESCRIPTION');
    $this->assertNotEmpty($this->url, 'COM_CAJOBBOARD_ANSWER_ERR_URL');

		parent::check();

    return $this;
  }
}
