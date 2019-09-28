<?php
/**
 * POPO Object Template for Offers model sample data seeding
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates;

// no direct access
defined('_JEXEC') or die;

class OffersTemplate extends CommonTemplate
{
	/**
	 * The person the job offer is extended to, FK to #__cajobboard_persons
	 *
	 * @property    int
   */
  public $about__person;


	/**
	 * The date this job offer is valid until.
	 *
	 * @property    \DateTime
   */
  public $valid_through;


	/**
	 * The Job Posting that this offer is being made for, FK to #__cajobboard_job_postings
	 *
	 * @property    int
   */
  public $item_offered;


	/**
	 * The Employer making this job offer, FK to #__cajobboard_organizations
	 *
	 * @property    int
   */
  public $offered_by;


	/**
	 * The offer letter document, FK to #__cajobboard_digital_documents
	 *
	 * @property    int
   */
  public $includes_object__digital_document;


	/**
	 * The email message extending the offer to the job seeker, FK to #__cajobboard_email_messages
	 *
	 * @property    int
   */
  public $includes_object__email_message;


	/**
	 * The base salary of the job.
	 *
	 * @property    int
   */
  public $price__base_salary__value;


	/**
	 * Currency the job is paid in, use ISO 4217 currency format e.g. USD.
	 *
	 * @property    string
   */
  public $price__base_salary__currency;


	/**
	 * Pay period for the job, use ISO 8601 duration format, e.g. P2W for bi-weekly.
	 *
	 * @property    string
   */
  public $price__base_salary__duration;


  /**
	 * Setters for QAPage fields
   */

  // $this->belongsTo('AboutPerson', 'Persons@com_cajobboard', 'about__person', 'id');
  public function about__person ($config, $faker)
  {
    $this->about__person = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'Persons');
  }


  public function valid_through ($config, $faker)
  {
    $dateTime = $faker->dateTimeBetween($startDate = '1 week', $endDate = '4 weeks', $timezone = null);

    $this->valid_through = $dateTime->format('Y-m-d H:i:s');
  }


  // $this->belongsTo('ItemOffered', 'JobPostings@com_cajobboard', 'item_offered', 'job_posting_id');
  public function item_offered ($config, $faker)
  {
    $this->item_offered = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'JobPostings');
  }


  // $this->belongsTo('OfferedBy', 'Organizations@com_cajobboard', 'offered_by', 'organization_id');
  public function offered_by ($config, $faker)
  {
    $this->offered_by = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'Organizations');
  }


  // $this->belongsTo('IncludesObjectDigitalDocument', 'DigitalDocuments@com_cajobboard', 'includes_object__digital_document', 'digital_document_id');
  public function includes_object__digital_document ($config, $faker)
  {
    $this->includes_object__digital_document = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'DigitalDocuments');
  }


  // $this->belongsTo('IncludesObjectEmailMessage', 'EmailMessages@com_cajobboard', 'includes_object__email_message', 'email_message_id');
  public function includes_object__email_message ($config, $faker)
  {
    $this->includes_object__email_message = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'EmailMessages');
  }


  public function price__base_salary__value ($config, $faker)
  {
     $this->price__base_salary__value = $faker->numberBetween(8, 40) * 100;
   }


  public function price__base_salary__currency ($config, $faker)
  {
    $this->price__base_salary__currency = 'USD';
  }


  public function price__base_salary__duration ($config, $faker)
  {
    $this->price__base_salary__duration = 'P2W';
  }
}
