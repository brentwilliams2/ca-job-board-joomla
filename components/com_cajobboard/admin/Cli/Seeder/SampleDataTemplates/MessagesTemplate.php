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

class MessagesTemplate extends BaseTemplate
{
	/**
	 * Category ID for this item.
	 *
	 * @var    int
   */
  public $cat_id;

	/**
	 * Alias for SEF URL.
	 *
	 * @var    string
   */
  public $slug;

	/**
	 * FK to the #__viewlevels table for access view control purposes.
	 *
	 * @var    int
  */
  public $access;

  /**
	 * Send status: -2 for trashed and marked for deletion, -1 for mail
   * delivery failure, 0 for not yet mailed, and 1 for mailed.
	 *
	 * @var    int
   */
  public $enabled;

  /**
	 * JSON encoded parameters for this item.
	 *
	 * @var    string
   */
  public $params;

	/**
	 * Used by the outgoing mail processor to save any information about mail delivery status.
	 *
	 * @var    string
   */
  public $note;

	/**
	 * A title to use for this item.
	 *
	 * @var    string
   */
  public $name;

	/**
	 * A description of the item.
	 *
	 * @var    string
   */
  public $description;

  /**
	 * Date the item was created
	 *
	 * @var    \DateTime
   */
  public $created_on;

  /**
	 * Userid of the creator of this item.
	 *
	 * @var    \JUser
   */
  public $created_by;

  /**
	 * Userid of person that last modified this item.
	 *
   * @var    \JUser
   */
  public $modified_by;

	/**
	 *  The date/time at which the message was sent.
	 *
	 * @property    string
   */
  public $date_read;

	/**
	 *  The recipient for this message. FK to #__cajobboard_persons
	 *
	 * @property    string
   */
  public $recipient;


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
	 * Setters for Answer fields
   */

  public function cat_id ($config, $faker)
  {
    // need to get model name being worked on, normalized to human-readable form e.g. "Job Postings"
    $className = explode( '\\', get_class($this) );
    $modelName = preg_replace('/Template$/', '', array_pop($className) );
    $normalModelName = preg_replace('/(?<!^)[A-Z]/', ' $0', $modelName);

    foreach ($config->categories as $category)
    {
      if ($category->title == $normalModelName)
      {
        $this->cat_id = $category->id;

        return;
      }
    }

    $this->cat_id = null;
  }

  public function slug ($config, $faker)
  {
    $this->slug = $faker->slug();
  }

  // Set to a view level for this item: 1 is "Public", 2 is "Registered", etc.
  public function access ($config, $faker)
  {
    $this->access = 1;
  }

  // Set 10% of records to trashed (-2), 10% to mail delivery failure (-1),
  // 10% to  not yet mailed (0), and rest to mailed (1).
  public function enabled ($config, $faker)
  {
    switch ($faker->numberBetween(1, 10)) {
      case 1:
        $this->enabled = -2;
        break;
      case 2:
        $this->enabled = -1;
        break;
      case 2:
        $this->enabled = 0;
        break;
      default:
        $this->enabled = 1;
    }
  }

  public function params ($config, $faker)
  {
    $this->params = '{"image":"","image_alt":""}';
  }

  public function note ($config, $faker)
  {
    $this->note = $faker->paragraph;
  }

  public function name ($config, $faker)
  {
    $this->name = $faker->sentence;
  }

  public function description ($config, $faker)
  {
    $this->description = $faker->paragraph;
  }

  public function created_by ($config, $faker)
  {
    $this->created_by = $config->userIds[$faker->numberBetween( 0, count($config->userIds) - 1 )];
  }

  public function created_on ($config, $faker)
  {
    $dateTime = $faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now', $timezone = null);

    $this->created_on = $dateTime->format('Y-m-d H:i:s');
  }

  public function modified_by ($config, $faker)
  {
    $this->modified_by = 0;
  }

  public function date_read ($config, $faker)
  {
    $dateTime = $faker->dateTimeBetween($startDate = '-1 days', $endDate = 'now', $timezone = null);
    $this->date_read = $dateTime->format('Y-m-d H:i:s');
  }

  public function recipient ($config, $faker)
  {
    $this->recipient = $config->userIds[$faker->numberBetween( 0, count($config->userIds) - 1 )];
  }

  // $this->belongsToMany('DigitalDocumentAttachment', 'DigitalDocuments@com_cajobboard', 'message_attachment__digital_document', 'digital_document_id', '#__cajobboard_messages_digital_documents');
  public function message_attachment__document ($config, $faker)
  {
    $this->seedJoinTable ($faker, $config, 2, '#__cajobboard_messages_digital_documents', 'message_id', 'DigitalDocuments', 'digital_document_id');

    unset($this->message_attachment__document);
  }

  // $this->belongsToMany('AudioMessageAttachment', 'AudioObjects@com_cajobboard', 'message_attachment__audio', 'audio_object_id', '#__cajobboard_messages_audio_objects');
  public function message_attachment__audio ($config, $faker)
  {
    $this->seedJoinTable ($faker, $config, 2, '#__cajobboard_messages_audio_objects', 'message_id', 'AudioObjects', 'audio_object_id');

    unset($this->message_attachment__audio);
  }

  // $this->belongsToMany('ImageMessageAttachment', 'ImageObjects@com_cajobboard', 'message_attachment__image', 'image_object_id', '#__cajobboard_messages_image_objects');
  public function message_attachment__image ($config, $faker)
  {
    $this->seedJoinTable ($faker, $config, 2, '#__cajobboard_messages_image_objects', 'message_id', 'ImageObjects', 'image_object_id');

    unset($this->message_attachment__image);
  }

  // $this->belongsToMany('VideoMessageAttachment', 'VideoObjects@com_cajobboard', 'message_attachment__video', 'video_object_id', '#__cajobboard_messages_video_objects');
  public function message_attachment__video ($config, $faker)
  {
    $this->seedJoinTable ($faker, $config, 2, '#__cajobboard_messages_video_objects', 'message_id', 'VideoObjects', 'video_object_id');

    unset($this->message_attachment__video);
  }

  /*
   * Seed a join table with sample data
   *
   * @property Faker  $faker
   * @property array  $config                 This template's configuration object
   * @property int    $chance                 Number between 0 and 10 indicating probability a record should be generated. 0 is no chance, 10 is 100%.
   * @property string $pivotTableName         The name of the join table
   * @property string $pivotLocalKeyName      The name of the local key field in the join table
   * @property string $foreignModelName       The name of the foreign model being joined to
   * @property string $pivotForeignKeyName    The name of the foreign key field in the join table
   */
  public function seedJoinTable ($faker, $config, $chance, $pivotTableName, $pivotLocalKeyName, $foreignModelName, $pivotForeignKeyName)
  {
    $randomInt = $faker->numberBetween( 1, 10 );

    if ($chance > $randomInt)
    {
      return;
    }

    // Get the name of this model
    $className = explode( '\\', get_class($this) );
    $modelName = preg_replace('/Template$/', '', array_pop($className) );

    $localKeyValue = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, $modelName);

    $foreignKeyValue = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, $foreignModelName);

    $profile = new \stdClass();

    $profile->$pivotLocalKeyName = $localKeyValue;
    $profile->$pivotForeignKeyName = $foreignKeyValue;

    \JFactory::getDbo()->insertObject($pivotTableName, $profile);
  }
}
