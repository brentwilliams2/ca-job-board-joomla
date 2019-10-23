<?php
/**
 * POPO Object Template for Messages model sample data seeding
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates;

use Faker;

// no direct access
defined('_JEXEC') or die;

class MessagesTemplate extends CommonTemplate
{
  use \Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates\Mixins\SeedJoinTable;
  use \Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates\Mixins\Tree;

	/**
	 * The primary key of the foreign model item that this comment belongs to.
	 *
	 * @property    int
   */
  public $about__foreign_model_id;


	/**
	 * The name of the foreign model this comment belongs to, discriminator field for single-table inheritance.
	 *
	 * @property    string    VARCHAR(255)
   */
  public $about__foreign_model_name;


  /**
	 *  The date/time at which the message was opened by the recipient.
	 *
	 * @property    int
   */
  public $date_read;


	/**
	 *  The recipient of this message, FK to #__cajobboard_persons
	 *
	 * @property    int
   */
  public $recipient;


	/**
	 *  JSON encoded state field to indicate attachment counts for this message
	 *
	 * @property    int
   */
  public $attachment_counts;


	/**
	 *  An AudioObject attachment for this message. FK to #__cajobboard_messages_audio_objects join table
	 *
	 * @property    int
   */
  public $message_attachment__audio;


	/**
	 *  A DigitalDocument attachment for this message. FK to #__cajobboard_messages_digital_documents join table
	 *
	 * @property    int
   */
  public $message_attachment__document;


	/**
	 *  A ImageObject attachment for this message. FK to #__cajobboard_messages_image_objects join table
	 *
	 * @property    int
   */
  public $message_attachment__image;


	/**
	 *  A VidioObject attachment for this message. FK to #__cajobboard_messages_video_objects join table
	 *
	 * @property    int
   */
  public $message_attachment__video;


	/**
	 * The parent item for this comment, defaults to the root node for the seeder
	 *
	 * @property    int
   */
  public $is_part_of;


	/**
	 * Class constructor
   *
   * @throws \RuntimeException
	 */
  public function __construct()
  {
    $this->validateTreeTable('#__cajobboard_messages');
  }


  /**
	 * Setters for Message fields
   */

  // $this->belongsToMany('DigitalDocumentAttachment', 'DigitalDocuments@com_cajobboard', 'message_attachment__digital_document', 'digital_document_id', '#__cajobboard_messages_digital_documents');
  public function message_attachment__document ($config, $faker)
  {
    $this->seedJoinTable ($faker, $config, 5, '#__cajobboard_messages_digital_documents', 'message_id', 'DigitalDocuments', 'digital_document_id');

    unset($this->message_attachment__document);
  }


  // $this->belongsToMany('AudioMessageAttachment', 'AudioObjects@com_cajobboard', 'message_attachment__audio', 'audio_object_id', '#__cajobboard_messages_audio_objects');
  public function message_attachment__audio ($config, $faker)
  {
    $this->seedJoinTable ($faker, $config, 5, '#__cajobboard_messages_audio_objects', 'message_id', 'AudioObjects', 'audio_object_id');

    unset($this->message_attachment__audio);
  }


  // $this->belongsToMany('ImageMessageAttachment', 'ImageObjects@com_cajobboard', 'message_attachment__image', 'image_object_id', '#__cajobboard_messages_image_objects');
  public function message_attachment__image ($config, $faker)
  {
    $this->seedJoinTable ($faker, $config, 5, '#__cajobboard_messages_image_objects', 'message_id', 'ImageObjects', 'image_object_id');

    unset($this->message_attachment__image);
  }


  // $this->belongsToMany('VideoMessageAttachment', 'VideoObjects@com_cajobboard', 'message_attachment__video', 'video_object_id', '#__cajobboard_messages_video_objects');
  public function message_attachment__video ($config, $faker)
  {
    $this->seedJoinTable ($faker, $config, 5, '#__cajobboard_messages_video_objects', 'message_id', 'VideoObjects', 'video_object_id');

    unset($this->message_attachment__video);
  }


  // $this->hasOne('ParentItem', 'Comments@com_cajobboard', 'parent_item', 'comment_id');
  public function about__foreign_model_id ($config, $faker)
  {
    $foreignModels = array(
      'JobPostings',
      'Organizations',
      'Places'
    );

    $this->about__foreign_model_name = $foreignModels[$faker->numberBetween(0, count($foreignModels) - 1 )];

    $this->about__foreign_model_id = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, $this->about__foreign_model_name);
  }


  public function about__foreign_model_name ($config, $faker)
  {
    return;
  }


  public function date_read ($config, $faker)
  {
    $dateTime = $faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now', $timezone = null);

    $this->date_read = $dateTime->format('Y-m-d H:i:s');
  }


  public function recipient ($config, $faker)
  {
    $this->recipient = $config->userIds[$faker->numberBetween( 0, count($config->userIds) - 1 )];
  }


  public function attachment_counts ($config, $faker)
  {
    $attachmentCounts = new \stdClass();

    $attachmentCounts->audio_objects = $faker->numberBetween(1, 10);
    $attachmentCounts->digital_documents = $faker->numberBetween(1, 10);
    $attachmentCounts->image_objects = $faker->numberBetween(1, 10);
    $attachmentCounts->video_objects = $faker->numberBetween(1, 10);

    $this->attachment_counts = json_encode($attachmentCounts);
  }


  public function is_part_of ($config, $faker)
  {
    $this->is_part_of = 1;
  }
}


