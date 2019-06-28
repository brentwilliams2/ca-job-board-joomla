<?php
/**
 * POPO Object Template for Reports model sample data seeding
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

class ReportsTemplate extends CommonTemplate
{
	/**
	 * How often this report should be generated. Use ISO 8601 duration format, e.g. PM1 for monthly, PW1 for weekly, PD1 for daily, PT0S for never-recurring.
	 *
	 * @property    string
   */
  public $repeat_frequency;

  /**
	 * Which day(s) of the week this report should be generated on. Auto-filled to current day for one-time reports. Uses DaysOfWeekEnum helper.
	 *
	 * @property    int
   */
  public $by_day;

  /**
	 * The number of times this report should be generated. Set to any non-positive integer value or null for recurring.
	 *
	 * @property    int
   */
  public $repeat_count;

  /**
	 * The user this report should be sent to.
	 *
	 * @property    int
   */
  public $to_recipient;

  /**
	 * The date the report was last sent.
	 *
	 * @property    string
   */
  public $date_sent;

  /**
	 * The URL of the Analytics view that should be used to generate the PDF file.
	 *
	 * @property    string
   */
  public $message_attachment;


  /**
	 * Setters for Report fields
   */

  public function repeat_frequency ($config, $faker)
  {
    $duration = array('PM1', 'PW1', 'PD1', 'PT0S');

    $this->repeat_frequency = $duration[ $faker->numberBetween( 0, count($duration) - 1 ) ];
  }

  public function by_day ($config, $faker)
  {
    $dayBitmask = array(2, 4, 8, 16, 32, 64, 128, 62);

    $this->by_day = $dayBitmask[ $faker->numberBetween( 0, count($dayBitmask) - 1 ) ];
  }

  public function repeat_count ($config, $faker)
  {
    $repeats = array(-1, null, 0, 1, 5, 10);

    $this->repeat_count = $repeats[ $faker->numberBetween( 0, count($repeats) - 1 ) ];
  }

  public function to_recipient ($config, $faker)
  {
    $this->to_recipient = $config->userIds[$faker->numberBetween( 0, count($config->userIds) - 1 )];
  }

  public function date_sent ($config, $faker)
  {
    $dateTime = $faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now', $timezone = null);

    $this->date_sent = $dateTime->format('Y-m-d H:i:s');
  }

  public function message_attachment ($config, $faker)
  {
    $this->message_attachment = 'http://joomla.test/administrator/index.php?option=com_cajobboard&view=Analytics&layout=' . $faker->slug;
  }
}
