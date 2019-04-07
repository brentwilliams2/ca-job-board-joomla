<?php
/**
 * Site Answers Model
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

use \FOF30\Container\Container;

/**
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
class Answers extends \Calligraphic\Cajobboard\Admin\Model\Answers
{
	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);
  }
}
