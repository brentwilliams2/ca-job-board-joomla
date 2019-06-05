<?php
/**
 * POPO Object Template for Places model sample data seeding
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

class PlacesTemplate extends CommonTemplate
{
 	/**
	 * A short textual code that uniquely identifies a place of business.
	 *
	 * @property    string
   */
  public $branch_code;

 	/**
	 * The E.164 PSTN fax number.
	 *
	 * @property    string
   */
  public $fax_number;

  /**
	 * A flag to signal that the Place is open to public visitors. If this property is omitted there is no assumed default boolean value.
	 *
	 * @property    bool
   */
  public $public_access;

	/**
	 * latitude and longitude of place using MySQL GIS spatial data type. Example: INSERT INTO place(geo) VALUES (Point(1,2));
	 *
	 * @property    string
   */
  public $geo;

	/**
	 * The two-letter ISO 3166-1 alpha-2 country code.
	 *
	 * @property    string
   */
  public $address__address_country;

	/**
	 * The locality, e.g. Mountain View.
	 *
	 * @property    string
   */
  public $address__address_locality;

	/**
	 * The postal code, e.g. 94043.
	 *
	 * @property    string
   */
  public $address__postal_code;

  /**
	 * The street address, e.g. 1600 Amphitheatre Pkwy.
	 *
	 * @property    string
   */
  public $address__street_address;

	/**
	 * The name of the region, e.g. California, FK to #__cajobboard_util_address_region
	 *
	 * @property    int
   */
  public $address_region;

  /**
	 * The E.164 PSTN telephone number.
	 *
	 * @property    string
   */
  public $telephone;

	/**
	 * The days and times this location is open.
	 *
	 * @property    string
   */
  public $opening_hours_specification;

	/**
	 * A logo image that represents this place. FK to #__cajobboard_images(image_id)
	 *
	 * @property    int
   */
  public $logo;


  /**
	 * Setters for Review fields
   */

  public function branch_code ($config, $faker)
  {
    $this->branch_code = $faker->bothify('DEPT ##-??');
  }

  public function fax_number ($config, $faker)
  {
    $this->fax_number = $faker->phoneNumber();
  }

  public function public_access ($config, $faker)
  {
    $this->public_access = $faker->boolean($chanceOfGettingTrue = 80);
  }

  // $this->belongsTo('Geo', 'GeoCoordinates@com_cajobboard', 'geo', 'geo_coordinate_id');
  public function geo ($config, $faker)
  {
    $this->geo = $config->relationMapper->getFKValue('BelongsTo', $config, false, $faker, 'GeoCoordinates');
  }

  public function address__address_country ($config, $faker)
  {
    $this->address__address_country = 'US';
  }

  public function address__address_locality ($config, $faker)
  {
    $this->address__address_locality = $faker->city();
  }

  public function address__postal_code ($config, $faker)
  {
    $this->address__postal_code = $faker->postcode();
  }

  public function address__street_address ($config, $faker)
  {
    $this->address__street_address = $faker->streetAddress();
  }

  // $this->belongsTo('AddressRegions', 'AddressRegions@com_cajobboard', 'organization_type', 'address_region_id');
  public function address_region ($config, $faker)
  {
    $this->address_region = $faker->numberBetween(1, 50);
  }

  public function telephone ($config, $faker)
  {
    $this->telephone = $faker->phoneNumber();
  }

  public function opening_hours_specification ($config, $faker)
  {
    $this->opening_hours_specification = '8:00 - 5:00 Monday-Friday';
  }

  // $this->belongsTo('Logo', 'ImageObjects@com_cajobboard', 'logo', 'image_object_id');
  public function logo ($config, $faker)
  {
    $this->logo = $config->relationMapper->getFKValue('BelongsTo', $config, false, $faker, 'ImageObjects');
  }
}
