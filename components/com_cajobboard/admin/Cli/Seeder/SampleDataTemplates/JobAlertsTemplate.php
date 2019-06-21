<?php
/**
 * POPO Object Template for Job Alerts model sample data seeding
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

class JobAlertsTemplate extends CommonTemplate
{
	/**
	 * The geographic coordinates of the center of the job seeker's search radius, FK to #__cajobboard_geo_coordinates
	 *
	 * @property    int
   */
  public $geo_coordinate;

	/**
	 * The distance in miles to search for jobs from the job seeker's search radius center point.
	 *
	 * @property    int
   */
  public $geo_radius;

	/**
	 * A category describing the job, FK to #__cajobboard_occupational_categories
	 *
	 * @property    string
   */
  public $occupational_category;

	/**
	 * Used to filter jobs shown for this alert. Should be a case-insensitive array of keywords, e.g. [ "great customers", "friendly", "fun" ]
	 *
	 * @property    int
   */
  public $keywords;


  /**
	 * Setters for Answer fields
   */


  // $this->inverseSideOfHasOne('GeoCoordinates', 'GeoCoordinates@com_cajobboard', 'geo_coordinate', 'geo_coordinate_id');
  public function geo_coordinate ($config, $faker)
  {
    $this->geo_coordinate = $config->relationMapper->getFKValue('BelongsTo', $config, false, $faker, 'GeoCoordinates');
  }

  public function geo_radius ($config, $faker)
  {
    $this->geo_radius = $faker->numberBetween(2, 20) * 5;
  }

  public function occupational_category ($config, $faker)
  {
    $this->occupational_category = $faker->numberBetween(1, 45);
  }

  public function keywords ($config, $faker)
  {
    $this->keywords = $faker->words($faker->numberBetween(1, 5));
  }
}
