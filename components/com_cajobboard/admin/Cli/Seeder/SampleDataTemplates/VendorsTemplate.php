<?php
/**
 * POPO Object Template for Vendors model sample data seeding
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

class VendorsTemplate extends CommonTemplate
{
	/**
	 * URL of vendor's website.
	 *
	 * @property   string
   */
  public $url;


	/**
	 * Additional metadata about this vendor: API secrets, payment limits, etc.
	 *
	 * @property    int
   */
  public $additional_type;


	/**
	 * The role of the organization e.g. Employer, Recruiter, etc.
	 *
	 * @property   int
   */
  public $role_name;


 	/**
	 * The official name of the vendor.
	 *
	 * @property   string
   */
  public $legal_name;


	/**
	 * RFC 3696 Email address.
	 *
	 * @property   string
   */
  public $email;


	/**
	 * The E.164 PSTN telephone number, array with required "default" key and optional alternative numbers
	 *
	 * @property   array
   */
  public $telephone;


	/**
	 *  The E.164 PSTN fax number.
	 *
	 * @property   string
   */
  public $fax_number;


	/**
	 * The two-letter ISO 3166-1 alpha-2 country code.
	 *
	 * @property    string
   */
  public $location__address__country;

	/**
	 * The locality, e.g. Mountain View.
	 *
	 * @property    string
   */
  public $location__address__locality;

	/**
	 * The postal code, e.g. 94043.
	 *
	 * @property    string
   */
  public $location__address__postal_code;

  /**
	 * The street address, e.g. 1600 Amphitheatre Pkwy.
	 *
	 * @property    string
   */
  public $location__address__street_address;

	/**
	 * The name of the region, e.g. California, FK to #__cajobboard_util_address_region
	 *
	 * @property    int
   */
  public $location__address__region;


  /**
	 * Setters for Vendor fields
   */


  public function url ($config, $faker)
  {
    $this->url = $faker->url();
  }


  public function additional_type ($config, $faker)
  {
    $this->additional_type = '{"api_key":"secret"}';
  }


  public function role_name ($config, $faker)
  {
    $roles = array(
      'BACKGROUND_CHECKS',
      'CREDIT_REPORTS',
      'OTHER'
    );

    $this->role_name = $roles[$faker->numberBetween(0, count($roles) - 1 )];
  }


  public function legal_name ($config, $faker)
  {
    $name = $faker->companyName();
    $this->legal_name = $name;
    $this->name = $name;
  }


  public function email ($config, $faker)
  {
    $this->email = $faker->email();
  }


  public function telephone ($config, $faker)
  {
    $this->telephone = $faker->phoneNumber();
  }


  public function fax_number ($config, $faker)
  {
    $this->fax_number = $faker->phoneNumber();
  }


  public function location__address__country ($config, $faker)
  {
    $this->location__address__country = 'US';
  }


  public function location__address__locality ($config, $faker)
  {
    $this->location__address__locality = $faker->city();
  }


  public function location__address__postal_code ($config, $faker)
  {
    $this->location__address__postal_code = $faker->postcode();
  }


  public function location__address__street_address ($config, $faker)
  {
    $this->location__address__street_address = $faker->streetAddress();
  }


  // $this->belongsTo('LocationAddressRegion', 'AddressRegions@com_cajobboard', 'location__address__region', 'address_region_id');
  public function location__address__region ($config, $faker)
  {
    $this->location__address__region = $faker->numberBetween(1, 59);
  }
}
