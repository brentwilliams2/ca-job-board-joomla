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
 * @property string         $description__intro   Short description of the item, used for the text shown on social media via shares and search engine results.
 * @property Registry       $image            Image metadata for social share and page header images.
 * @property int            $about__foreign_model_id    The foreign model primary key that this comment belongs to
 * @property string         $about__foreign_model_name  The name of the foreign model this comment belongs to, discriminator field for single-table inheritance
 *
 * SCHEMA: Message
 * @property string         $date_read        The date/time at which the message was read by the recipient.
 *
 * SCHEMA: Custom UCM
 * @property Json           $attachment_counts    JSON encoded state field to indicate attachment counts for this message, keyed by media object name: {"audio_objects":0,"digital_documents":0,"image_objects":0,"video_objects":0}',
 */
class Messages extends BaseTreeModel
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
      'AttachmentCounts', // model-specific behaviour
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

    // many-to-one FK to  #__cajobboard_persons
    $this->belongsTo('Recipient', 'Persons@com_cajobboard', 'recipient', 'id');

    // many-to-one FK to  #__cajobboard_messages
    $this->belongsTo('IsPartOf', 'Messages@com_cajobboard', 'is_part_of', 'message_id');

    /*
     * Relation field for belongsToMany is in a JOIN TABLE
     */

    // many-to-many FK to  #__cajobboard_audio_objects via join table
    $this->belongsToMany('AudioMessageAttachment', 'AudioObjects@com_cajobboard', 'message_attachment__audio', 'audio_object_id', '#__cajobboard_messages_audio_objects', 'message_id');

    // many-to-many FK to  #__cajobboard_digital_documents via join table
    $this->belongsToMany('DigitalDocumentAttachment', 'DigitalDocuments@com_cajobboard', 'message_attachment__document', 'digital_document_id', '#__cajobboard_messages_digital_documents', 'message_id');

    // many-to-many FK to  #__cajobboard_image_objects via join table
    $this->belongsToMany('ImageMessageAttachment', 'ImageObjects@com_cajobboard', 'message_attachment__image', 'image_object_id', '#__cajobboard_messages_image_objects', 'message_id');

    // many-to-many FK to  #__cajobboard_video_objects via join table
    $this->belongsToMany('VideoMessageAttachment', 'VideoObjects@com_cajobboard', 'message_attachment__video', 'video_object_id', '#__cajobboard_messages_video_objects', 'message_id');
  }

  /*
     @TODO:  'about__' field references what ATS entity the message is about (like an Application), need
              a UI button to automatically attach it to that entity (displaying the message with Comment view html)
  */

  // @TODO: STI many-to-one with discriminator field: see RFC at https://github.com/akeeba/fof/issues/675

  // @TODO: handle foreign_model_id and foreign_model_name

  // @TODO: COPIED FROM COMMENTS MODEL
  //        Add method to "attach" a message thread to a root comment if the comment is attached to particular ATS views.
  //        The idea is to provide a system where there is a special category of comment: instead of showing a normal
  //        comment thread, it pulls a message thread in to allow it to be attached to an ATS entity for candidate
  //        tracking (instead of the messages just being in user's inboxes and not reference to any ATS entity)

  /**
	 * Update the 'messagesTotal' and 'messagesUnread' keys in the Person model 'params' field
	 *
	 * @return    void
	 */
	public function onBeforeBind($data)
	{
    if ( $this->shouldIncrementViewCounts() )
    {
      $recipient = $data->recipient;

      $this->container->MessageCounts->updateMessageCounts($recipient);
    }
  }


  /**
	 * Transform attachment_counts' field to a JRegistry object on bind
	 *
	 * @return  \Calligraphic\Library\Platform\Registry
	 */
  protected function getAttachmentCountsAttribute($value)
  {
    $default = '{"audio_objects":0,"digital_documents":0,"image_objects":0,"video_objects":0}';

    $attachmentCounts = $this->transformJsonToRegistry($value, $default);

    return $attachmentCounts;
  }


  /**
	 * Transform 'attachment_counts' field's JRegistry object to a JSON string before save
	 *
	 * @return  string  JSON string
	 */
  protected function setAttachmentCountsAttribute($value)
  {
    return $this->transformRegistryToJson($value);
  }
}
