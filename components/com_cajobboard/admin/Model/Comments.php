<?php
/**
 * Comments Model
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
 * @property int            $comment_id     Surrogate primary key.
 * @property string         $slug            Alias for SEF URL.
 * @property bool           $featured        Whether this comment is featured or not.
 * @property int            $hits            Number of hits this comment has received.
 * @property int            $created_by      Userid of the creator of this comment.
 * @property string         $createdOn       Date this comment was created.
 * @property int            $modifiedBy      Userid of person that last modified this comment.
 * @property string         $modifiedOn      Date this comment was last modified.
 *
 * SCHEMA: Thing
 * @property string         $name             A title for this comment.
 * @property string         $description      A short description of this comment.
 *
 * SCHEMA: Comment
 * @property Comment        $parent_item      The comment this comment is a child of, or zero if a top-level comment. FK to #__cajobboard_comments
 * @property int            $upvote_count     The number of upvotes this comment has received from the community.
 * @property int            $downvote_count   The number of downvotes this comment has received from the community.
 *
 * SCHEMA: CreativeWork
 * @property string         $about__model     The model name this comment refers to.
 * @property int            $about__id        The entity id in the foreign model this comment refers to.
 * @property string         $text             The full text of this comment.
  */
class Comments extends DataModel
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
		$config['tableName'] = '#__cajobboard_comments';
    $config['idFieldName'] = 'comment_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.comments';

    // Add behaviours to the model
    $config['behaviours'] = array('Filters', 'Language', 'Tags');

    parent::__construct($container, $config);

    /*
     * Set up relations
     */

    // @TODO: Waiting on PR request for custom relation types (to create relation type for table inheritance)
    // $this->hasOne('about', $about__model' . @com_cajobboard', 'about__id', $this->container->inflector->singularize($about__model) . '_id');
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
    $this->assertNotEmpty($this->title, 'COM_CAJOBBOARD_COMMENT_ERR_TITLE');
    $this->assertNotEmpty($this->description, 'COM_CAJOBBOARD_COMMENT_ERR_DESCRIPTION');
    $this->assertNotEmpty($this->url, 'COM_CAJOBBOARD_COMMENT_ERR_URL');

		parent::check();

    return $this;
  }
}
