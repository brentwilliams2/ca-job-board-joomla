<?php
/**
 * Admin Messages Model for site user messaging similar to UddeIM
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
use \Calligraphic\Cajobboard\Admin\Helper\MessageCounts;

/**
 * Fields:
 *
 * UCM
 * @property int            $message_id     Surrogate primary key.
 * @property string         $slug             Alias for SEF URL.
 *
 * FOF "magic" fields
 * @property bool           $featured         Whether this message is featured or not.
 * @property int            $hits             Number of hits this message has received.
 * @property int            $created_by       Userid of the creator of this message.
 * @property string         $createdOn        Date this message was created.
 * @property int            $modifiedBy       Userid of person that last modified this message.
 * @property string         $modifiedOn       Date this message was last modified.
 *
 * SCHEMA: Joomla UCM fields, used by Joomla!s UCM when using the FOF ContentHistory behaviour
 * @property string         $publish_up       Date and time to change the state to published, schema.org alias is datePosted.
 * @property string         $publish_down     Date and time to change the state to unpublished.
 * @property int            $ordering         Order this record should appear in for sorting.
 * @property string         $params           JSON encoded parameters for this item.
 * @property string         $language         The language code for the article or * for all languages.
 * @property int            $cat_id           Category ID for this item.
 * @property string         $note             A note to save with this item for use in the back-end interface.
 *
 * SCHEMA: Thing
 * @property string         $name             A title to use for the message.
 * @property string         $description      A description of the message.
 *
 * SCHEMA: Message
 * @property string         $date_read        The date/time at which the message was read by the recipient.
 */
class Messages extends BaseTreeModel
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
		$config['tableName'] = '#__cajobboard_messages';
    $config['idFieldName'] = 'message_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.messages';

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

    // many-to-one FK to  #__cajobboard_persons
    $this->belongsTo('Author', 'Persons@com_cajobboard', 'created_by', 'id');

    // many-to-one FK to  #__cajobboard_organizations
    $this->belongsTo('Recipient', 'Persons@com_cajobboard', 'recipient', 'id');

    // relation field for belongsToMany is in a join table

    // many-to-many FK to  #__cajobboard_audio_objects via join table
    $this->belongsToMany('AudioMessageAttachment', 'AudioObjects@com_cajobboard', 'message_attachment__audio', 'audio_object_id', '#__cajobboard_messages_audio_objects', 'message_id');

    // many-to-many FK to  #__cajobboard_digital_documents via join table
    $this->belongsToMany('DigitalDocumentAttachment', 'DigitalDocuments@com_cajobboard', 'message_attachment__document', 'digital_document_id', '#__cajobboard_messages_digital_documents', 'message_id');

    // many-to-many FK to  #__cajobboard_image_objects via join table
    $this->belongsToMany('ImageMessageAttachment', 'ImageObjects@com_cajobboard', 'message_attachment__image', 'image_object_id', '#__cajobboard_messages_image_objects', 'message_id');

    // many-to-many FK to  #__cajobboard_video_objects via join table
    $this->belongsToMany('VideoMessageAttachment', 'VideoObjects@com_cajobboard', 'message_attachment__video', 'video_object_id', '#__cajobboard_messages_video_objects', 'message_id');
  }

    // @TODO: Should this be a TreeModel, to handle nesting of messages efficiently?

  /**
	 * @throws    \RuntimeException when the assertion fails
	 *
	 * @return    $this   For chaining.
	 */
	public function onBeforeBind()
	{
    if ( $this->shouldIncrementViewCounts() )
    {
      $this->container->MessageCounts->updateMessageCounts( $this->get('recipient') );
    }
  }

  // @TODO: Need a field that can reference what ATS entity the message is about (like an Application),
  //        and a UI button to automatically attach it to that entity (via a Comment)
}
