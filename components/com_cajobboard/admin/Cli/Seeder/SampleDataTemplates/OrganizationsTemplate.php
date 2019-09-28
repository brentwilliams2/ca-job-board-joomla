<?php
/**
 * POPO Object Template for Organizations model sample data seeding
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

class OrganizationsTemplate extends CommonTemplate
{
	/**
	 * The E.164 PSTN telephone number, array with required "default" key and optional alternative numbers
	 *
	 * @property   array
   */
  public $telephone;


  /**
	 * A description of the item.
	 *
	 * @property   string
   */
  public $description;


	/**
	 * A short description of the employer, for example to use on listing pages.
	 *
	 * @property   string
   */
  public $disambiguating_description;


	/**
	 * RFC 3696 Email address.
	 *
	 * @property   string
   */
  public $email;


	/**
	 *  The E.164 PSTN fax number.
	 *
	 * @property   string
   */
  public $fax_number;


	/**
	 * The official name of the employer.
	 *
	 * @property   string
   */
  public $legal_name;


	/**
	 * The number of employees in an organization e.g. business.
	 *
	 * @property   string
   */
  public $number_of_employees;


	/**
	 * URL of employer's website.
	 *
	 * @property   string
   */
  public $url;


	/**
	 * Where the organization is located.
	 *
	 * @property   int
   */
  public $location;


	/**
	 * A logo for this organization.
	 *
	 * @property   int
   */
  public $logo;


	/**
	 * Statement on diversity policy of the employer.
	 *
	 * @property   int
   */
  public $diversity_policy;


	/**
	 * The overall rating, based on a collection of reviews or ratings, of the item.
	 *
	 * @property   int
   */
  public $aggregate_rating;


	/**
	 * The larger organization that this organization is a subOrganization of, if any.
	 *
	 * @property   int
   */
  public $parent_organization;


	/**
	 * The type of organization e.g. Employer, Recruiter, etc.
	 *
	 * @property   int
   */
  public $organization_type;


	/**
	 * The role of the organization e.g. Employer, Recruiter, etc.
	 *
	 * @property   int
   */
  public $role_name;


  /**
	 * Setters for Answer fields
   */

  public function telephone ($config, $faker)
  {
    $this->telephone = $faker->phoneNumber();
  }


  public function description ($config, $faker)
  {
    $this->description = implode("\n", $faker->paragraphs($faker->numberBetween(1, 3)));
  }


  public function disambiguating_description ($config, $faker)
  {
    $this->disambiguating_description = $faker->paragraph();
  }


  public function email ($config, $faker)
  {
    $this->email = $faker->email();
  }


  public function fax_number ($config, $faker)
  {
    $this->fax_number = $faker->phoneNumber();
  }


  public function legal_name ($config, $faker)
  {
    $name = $faker->companyName();
    $this->legal_name = $name;
    $this->name = $name;
  }


  public function number_of_employees ($config, $faker)
  {
    $this->number_of_employees = $faker->numberBetween(1, 30);
  }


  public function url ($config, $faker)
  {
    $this->url = $faker->url();
  }


  // $this->belongsTo('Location', 'Places@com_cajobboard', 'location', 'place_id');
  public function location ($config, $faker)
  {
    $this->location = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'Places');
  }


  // $this->belongsTo('Logo', 'ImageObjects@com_cajobboard', 'logo', 'image_object_id');
  public function logo ($config, $faker)
  {
    $this->logo = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'ImageObjects');
  }


  // $this->belongsTo('DiversityPolicy', 'DiversityPolicies@com_cajobboard', 'diversity_policy', 'diversity_policy_id');
  public function diversity_policy ($config, $faker)
  {
    $this->diversity_policy = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'DiversityPolicies');
  }


  // $this->belongsTo('RoleName', 'OrganizationRoles@com_cajobboard', 'role_name', 'organization_role_id');
  public function role_name ($config, $faker)
  {
    $this->role_name = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'OrganizationRoles');
  }


  // $this->belongsTo('OrganizationType', 'OrganizationTypes@com_cajobboard', 'organization_type', 'organization_type_id');
  public function organization_type ($config, $faker)
  {
    $this->organization_type = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'OrganizationTypes');
  }


  // $this->inverseSideOfHasOne('AggregateRating', 'EmployerAggregateRatings@com_cajobboard', 'aggregate_rating', 'employer_aggregate_rating_id');
  public function aggregate_rating ($config, $faker)
  {
    $this->aggregate_rating = $config->relationMapper->getFKValue('InverseSideOfHasOne', $config, true, $faker, 'EmployerAggregateRatings');
  }


  // $this->inverseSideOfHasOne('ParentOrganization', 'Organizations@com_cajobboard', 'parent_organization', 'organization_id');
  public function parent_organization ($config, $faker)
  {
    $this->parent_organization = $config->relationMapper->getFKValue('InverseSideOfHasOne', $config, true, $faker, 'Organizations');
  }
}
