<?php
/**
 * Site Questions Model
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Model;

// no direct access
defined('_JEXEC') or die;

use FOF30\Container\Container;

/**
 * Model class description
 *
 * Fields:
 *
 * UCM
 * @property int            $question_id     Surrogate primary key.
 * @property string         $slug            Alias for SEF URL.
 * @property bool           $featured        Whether this question is featured or not.
 * @property int            $hits            Number of hits this question has received.
 * @property int            $created_by      Userid of the creator of this question.
 * @property string         $createdOn       Date this question was created.
 * @property int            $modifiedBy      Userid of person that last modified this question.
 * @property string         $modifiedOn      Date this question was last modified.
 *
 * SCHEMA: Thing
 * @property string         $name             A title to use for the question.
 * @property string         $description      Text of the question.
 *
 * SCHEMA: CreativeWork
 * @property QAPage         $isPartOf         This property points to a QAPage entity associated with this question. FK to #__cajobboard_qapage(qapage_id)
 * @property Organization   $Publisher        The company that wrote this question. FK to #__organizations(organization)id).
 * @property string         $text             The actual text of the question itself.
 *
 * * SCHEMA: Question
 * @property Answer         $acceptedAnswer   Use acceptedAnswer for the best answer to a question.  FK to #__cajobboard_answers(answer_id)
 * @property int            $upvote_count     Upvote count for this item.
 * @property int            $downvote_count   Downvote count for this item.
 *
 */
class Questions extends \Calligraphic\Cajobboard\Admin\Model\Questions
{
	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);
  }
}
