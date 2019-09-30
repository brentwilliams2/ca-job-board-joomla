<?php
/**
 * POPO Object Template for Interviews model sample data seeding
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates;

use Faker;

// no direct access
defined('_JEXEC') or die;

class DataFeedsTemplate extends CommonTemplate
{
	/**
	 * Relative URL of the data feed on this site, if the vendor pulls from this site.
	 *
	 * @property    string
   */
  public $url;


  /**
	 * The XML template to apply when generating this data feed, FK to #__cajobboard_data_feed_templates
	 *
	 * @property    int
   */
  public $data_feed_template;


	/**
	 * The date/time at which this data feed should be pushed to the audience,
   * as a  Calligraphic\Cajobboard\Admin\Helper\Enum\DaysOfWeekEnum value.
	 *
	 * @property    \Calligraphic\Cajobboard\Admin\Helper\Enum\DaysOfWeekEnum
   */
  public $send_dates;


	/**
	 * The Vendor that this data feed is for, e.g. Indeed.com, FK to #__cajobboard_vendors
	 *
	 * @property    int
   */
  public $audience__vendor;


  /**
	 * A JSON configuration describing Filter parameters to apply for the JobPostings included
   * in the feed, e.g. {"state variable":"job_posting_id","method":"between","from":"1","to":"10"}
	 *
	 * @property    string
   */
  public $data_feed_element;


	/**
	 * The data and time this data feed was last pushed to the vendor.
	 *
	 * @property    \DateTime
   */
  public $date_created;


  /**
	 * Setters for QAPage fields
   */


  public function url ($config, $faker)
  {
    $this->url = $faker->url;
  }


  // $this->inverseSideOfHasOne('DataFeedTemplate', 'DataFeedTemplates@com_cajobboard', 'data_feed_template', 'data_feed_template_id');
  public function data_feed_template ($config, $faker)
  {
    $this->data_feed_template = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'DataFeedTemplates');
  }


  public function send_dates ($config, $faker)
  {
    $this->send_dates = 62;
  }


  // $this->belongsTo('AudienceVendor', 'Vendors@com_cajobboard', 'audience__vendor', 'vendor_id');
  public function audience__vendor ($config, $faker)
  {
    $this->audience__vendor = $config->relationMapper->getFKValue('InverseSideOfHasOne', $config, true, $faker, 'Vendors');
  }


  public function data_feed_element ($config, $faker)
  {
    $this->data_feed_element = '{"state variable":"job_posting_id","method":"between","from":"1","to":"10"}';
  }


  public function date_created ($config, $faker)
  {
    $dateTime = $faker->dateTimeBetween('-30 hourss', '-1 hour');

    $this->date_created = $dateTime->format('Y-m-d H:i:s');
  }
}
