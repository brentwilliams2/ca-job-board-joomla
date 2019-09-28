<?php
/**
 * POPO Object Template for Background Checks model sample data seeding
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates;

use Faker;
use \Calligraphic\Cajobboard\Admin\Helper\Enum\ActionStatusEnum;

// no direct access
defined('_JEXEC') or die;

class BackgroundChecksTemplate extends CommonTemplate
{
	/**
	 * The person the background check is being conducted on', /* FK to #__cajobboard_persons
	 *
	 * @property    int
   */
  public $about;


  /**
	 * Status of the action, ENUM defined in \Calligraphic\Cajobboard\Admin\Helper\Enum\ActionStatusEnum.
	 *
	 * @property    int
   */
  public $action_status;


	/**
	 * The date the completed background check was received.
	 *
	 * @property    \DateTime
   */
  public $end_time;


  /**
	 * The digital document returned from the background checking service as a result, FK to #__cajobboard_digital_documents
	 *
	 * @property    int
   */
  public $result;


	/**
	 * The date the background check was requested.
	 *
	 * @property    \DateTime
   */
  public $start_time;


  /**
	 * The actual cost of the background check from the vendor.
	 *
	 * @property    int
   */
  public $price;


	/**
	 * The organization that will provide background check services for this item, FK to #__cajobboard_organizations
	 *
	 * @property    int
   */
  public $vendor;


  /**
	 * Setters for Background Check fields
   */


  // $this->belongsTo('About', 'Persons@com_cajobboard', 'about', 'id');
  public function about ($config, $faker)
  {
    $this->about = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'Persons');
  }


  public function action_status ($config, $faker)
  {
    $actionStatuses = array_keys( ActionStatusEnum::getActionStatusConstants() );

    $this->action_status = $actionStatuses[$faker->numberBetween(0, count($actionStatuses) - 1 )];
  }


  public function end_time ($config, $faker)
  {
    $dateTime = $faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now', $timezone = null);

    $this->end_time = $dateTime->format('Y-m-d H:i:s');
  }


  // $this->belongsTo('Result', 'DigitalDocuments@com_cajobboard', 'result', 'digital_document_id');
  public function result ($config, $faker)
  {
    $this->result = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'DigitalDocuments');
  }


  public function start_time ($config, $faker)
  {
    $dateTime = $faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now', $timezone = null);

    $this->start_time = $dateTime->format('Y-m-d H:i:s');
  }


  public function price ($config, $faker)
  {
    $this->price = $faker->numberBetween(25, 50);
  }


  // $this->belongsTo('Vendor', 'Vendors@com_cajobboard', 'vendor', 'vendor_id');
  public function vendor ($config, $faker)
  {
    $this->vendor = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'Vendors');
  }
}
