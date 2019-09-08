<?php
/**
 * Admin Comments Model
 * 
 * TreeModel to handle nesting of comments efficiently
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

use \FOF30\Container\Container;
use \Calligraphic\Cajobboard\Admin\Model\BaseTreeModel;

/**
 * Fields:
 *
 * UCM
 * @property int            $comment_id       Surrogate primary key.
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
 * @property int            $featured         Whether this item is featured or not.
 * @property string         $note             A note to save with this item for use in the back-end interface.
 *
 * SCHEMA: Thing
 * @property string         $name             A title to use for the comment.
 * @property string         $description      The text of the comment.
 * @property int            $about__foreign_model_id    The foreign model primary key that this comment belongs to
 * @property string         $about__foreign_model_name  The name of the foreign model this comment belongs to, discriminator field for single-table inheritance
 *
 * SCHEMA: Comment
 * @property int            $upvote_count     Upvote count for this item.
 * @property int            $downvote_count   Downvote count for this item.
 */

 // If you need to be able to store multiple trees then simply make the root node of each such
 // tree a child node under the single root node and adjust your code to take this into account.
 // SEEMS like we'd have two roots: the over-arching top-level root (node 1), and then a layer of nodes
 //       underneath that represent entities (using level = 1), and all real comments under the
 //       item-level entities. So real items would have level = 2 and getting the tree for an item 
 //       would be adding where clauses to the query (e.g. about__foreign_model_id = n and level = 1)
 //         $childCategoryTree = $table->getTree($id);
 //       First element in tree is the current category, so we can skip that one
 //	        unset($childCategoryTree[0]);
 //  Retrieves a one-dimensional array of all the nodes in the subtree, ordered by 'lft' column

class Comments extends BaseTreeModel
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
		$config['tableName'] = '#__cajobboard_comments';
    $config['idFieldName'] = 'comment_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.comments';

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

    // table field for belongsTo relation is in this model's table

    // many-to-one FK to  #__cajobboard_persons
    $this->belongsTo('Author', 'Persons@com_cajobboard', 'created_by', 'id');

    // many-to-one FK to  #__cajobboard_image_objects
    $this->hasOne('Image', 'ImageObjects@com_cajobboard', 'image', 'image_object_id');

    // @TODO: STI many-to-one with discriminator field: see RFC at https://github.com/akeeba/fof/issues/675
  }

  // @TODO: handle foreign_model_id and foreign_model_name

  // @TODO: Add method to "attach" a message thread to a root comment if the comment is attached to particular ATS views.
  //        The idea is to provide a system where there is a special category of comment: instead of showing a normal
  //        comment thread, it pulls a message thread in to allow it to be attached to an ATS entity for candidate
  //        tracking (instead of the messages just being in user's inboxes and not reference to any ATS entity)
}
