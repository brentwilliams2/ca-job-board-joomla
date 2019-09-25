<?php
/**
 * POPO Object Template for Fair Credit Reporting Act model sample data seeding
 *
 * Uses returns in template properties so that all
 * properties can be loaded at once from real values
 *
 * @package   Calligraphic Job Board
 * @version   7 September, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates;

use Faker;

// no direct access
defined('_JEXEC') or die;

class FairCreditReportingActTemplate extends CommonTemplate
{
  use \Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates\Mixins\Image;

	/**
	 * The person the FCRA notice is sent to.
	 *
	 * @property    string
   */
  public $about;


	/**
	 * Status of the action, ENUM defined in \Calligraphic\Cajobboard\Admin\Helper\Enum\ActionStatusEnum.
	 *
	 * @property    int
   */
  public $action_status;


	/**
	 * The date the signed FCRA notice was received.
	 *
	 * @property    int
   */
  public $end_time;


	/**
	 * The date the FCRA notice was sent to the job seeker for signing.
	 *
	 * @property    string
   */
  public $start_time;


	/**
	 * System filename of the signed FCRA notice returned from the job seeker.
	 *
	 * @property    int
   */
  public $result__content_url;


	/**
	 * File size of the signed FCRA notice in bytes.
	 *
	 * @property    string
   */
  public $result__content_size;


	/**
	 * MIME format of the document, e.g. application/pdf.
	 *
	 * @property    string
   */
  public $result__encoding_format;


  /**
	 * Setters for Comment fields
   */

  public function about ($config, $faker)
  {
    $this->setTemplateProperties($config, $faker);
  }


  public function action_status ($config, $faker)
  {
    return;
  }


  public function end_time ($config, $faker)
  {
    return;
  }


  public function start_time ($config, $faker)
  {
    return;
  }


  public function result__content_url ($config, $faker)
  {
    return;
  }


  public function result__content_size ($config, $faker)
  {
    return;
  }


  public function result__encoding_format ($config, $faker)
  {
    return;
  }


  /**
   * over-ridden from CommonTemplate
   */
  public function cat_id ($config, $faker)
  {
    return;
  }


 /**
  * Loads all values at once with real values (from audio file)
  */
  protected function setTemplateProperties ($config, $faker)
  {
    $record = $this->loadRecord($config->item_id);

    // $this->belongsTo('About', 'Persons@com_cajobboard', 'about', 'id');
    $this->about = $config->userIds[$faker->numberBetween( 0, count($config->userIds) - 1 )];

    $this->action_status = $record['action_status'];

    $endDateTime = $faker->dateTimeBetween($startDate = '-5 days', $endDate = '-2 days', $timezone = null);

    $this->end_time = $endDateTime->format('Y-m-d H:i:s');

    $startDateTime = $faker->dateTimeBetween($startDate = '-50 days', $endDate = '-10 days', $timezone = null);

    $this->start_time = $startDateTime->format('Y-m-d H:i:s');

    $this->result__content_url = $record['result__content_url'];

    $this->result__content_size = $record['result__content_size'];

    $this->result__encoding_format = 'application/pdf';
  }


  /**
   * Return metadata for a FCRA file saved on disk in the media/fair_credit_reporting_act_notices directory
   *
   * NOTE: The number of records to generate in config.json for this template
   *       must match the number of elements in the returned array here
   *
   * @param   int   $recordId   The ID number of the record to get metadata for
   *
   * @return  array   An array of metadata for the record
   */
  public function loadRecord ($recordId)
  {
    $records = array(
      array(
        'result__content_url' => '092a968a85a7c41fd7a3c08a02b416d2.pdf',  'result__content_size' => '65015', 'action_status' => 2
      ),
      array(
        'result__content_url' => '6ff131aceb54a4ce3090c3030c0bfbd0.pdf',  'result__content_size' => '156529', 'action_status' => 2
      ),
      array(
        'result__content_url' => 'a9efdf2cf751bd11030c0ea7f0f60810.pdf',  'result__content_size' => '247900', 'action_status' => 2
      ),
      array(
        'result__content_url' => '39c9b2db2b78cd4b6291a8e3f524d642.pdf',  'result__content_size' => '7762', 'action_status' => 2
      )
    );

    return $records[$recordId - 1];
  }
}
