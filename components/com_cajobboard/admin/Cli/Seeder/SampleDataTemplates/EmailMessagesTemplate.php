<?php
/**
 * POPO Object Template for EmailMessages model sample data seeding
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

class EmailMessagesTemplate extends CommonTemplate
{
	/**
	 *  Body field of the e-mail.
	 *
	 * @property    string
   */
  public $text;

	/**
	 *  The date/time at which the message was sent.
	 *
	 * @property    string
   */
  public $date_sent;

	/**
	 *  A DigitalDocument attachment for this e-mail message, e.g. a PDF file for an analytics report. FK to #__cajobboard_digital_documents
	 *
	 * @property    int
   */
  public $message_attachment__document;

	/**
	 *  An additional name for  of the recipient, can be used for a middle name.
	 *
	 * @property    string
   */
  public $recipient__additional_name;

	/**
	 *  Email address of the recipient.
	 *
	 * @property    string
   */
  public $recipient__email;

	/**
	 *  Family name of the recipient. In the U.S., the last name of an Person.
	 *
	 * @property    string
   */
  public $recipient__family_name;

	/**
	 *  Given name of the recipient. In the U.S., the first name of a Person.
	 *
	 * @property    string
   */
  public $recipient__given_name;

  /**
	 *  An honorific prefix preceding the recipient\'s name such as Dr. / Mrs. / Mr.
   *
	 * @property    string
   */
  public $recipient__honorific_prefix;

	/**
	 *  An honorific suffix preceding the recipient\'s name such as M.D. / PhD / MSCSW.
	 *
	 * @property    string
   */
  public $recipient__honorific_suffix;

	/**
	 *  Optional, the organization that sent this message. Use created_by to query by the Person that sent this message.' FK to #__cajobboard_organizations
	 *
	 * @property    int
   */
  public $sender;

  /**
	 *  The template to apply when generating this message.' FK to #__cajobboard_email_message_templates
	 *
	 * @property    int
   */
  public $email_message_template;


  /**
	 * Setters for Answer fields
   */

  public function text ($config, $faker)
  {
    $this->text = implode("\n", $faker->paragraphs($faker->numberBetween(2, 4)));
  }

  public function date_sent ($config, $faker)
  {
    // Set in 'enabled'
    return;
  }

  // $this->belongsTo('DigitalDocument', 'DigitalDocuments@com_cajobboard', 'message_attachment__document', 'digital_document_id');
  public function message_attachment__document ($config, $faker)
  {
    $chance = $faker->numberBetween( 1, 2 );

    if ($chance > 1)
    {
      $this->message_attachment__document = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'DigitalDocuments');
    }
  }

  public function recipient__additional_name ($config, $faker)
  {
    $this->recipient__additional_name = $faker->lastName();
  }

  public function recipient__email ($config, $faker)
  {
    $this->recipient__email = $faker->email();
  }

  public function recipient__family_name ($config, $faker)
  {
    $this->recipient__family_name = $faker->lastName();
  }

  public function recipient__given_name ($config, $faker)
  {
    $this->recipient__given_name = $faker->firstName();
  }

  public function recipient__honorific_prefix ($config, $faker)
  {
    $this->recipient__honorific_prefix = $faker->title();
  }

  public function recipient__honorific_suffix ($config, $faker)
  {
    $this->recipient__honorific_suffix = $faker->suffix();
  }

  // $this->belongsTo('Sender', 'Organizations@com_cajobboard', 'sender', 'id');
  public function sender ($config, $faker)
  {
    $this->sender = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'Organizations');
  }

  // $this->inverseSideOfHasOne('EmailMessageTemplate', 'EmailMessageTemplates@com_cajobboard', 'email_message_template', 'email_message_template_id');
  public function email_message_template ($config, $faker)
  {
    $this->email_message_template = $config->relationMapper->getFKValue('InverseSideOfHasOne', $config, true, $faker, 'EmailMessageTemplates');
  }
}
