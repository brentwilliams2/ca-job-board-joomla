<?php
/**
 * POPO Object Template for seeding sample data in model common fields.
 * Override any setters in child class to provide custom output.
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates;

use Calligraphic\Cajobboard\Admin\Cli\Seeder\JoinTableManager;

// no direct access
defined('_JEXEC') or die;

class GeoCoordinatesTemplate extends BaseTemplate
{
  /**
	 * Object to hold geolocation data, with latitude and longitude properties
	 *
   * @property    \stdClass
   */
  public $geo;


  /**
	 * Setter for geo field
   */
  public function geo ($config, $faker)
  {
    $this->geo = new \stdClass();

    $this->geo->latitude = $faker->numberBetween(-90, 90) . '.' . str_pad($faker->numberBetween(1, 999999), 6, "0", STR_PAD_RIGHT);
    $this->geo->longitude = $faker->numberBetween(-180, 180) . '.' . str_pad($faker->numberBetween(1, 999999), 6, "0", STR_PAD_RIGHT);
  }
}
