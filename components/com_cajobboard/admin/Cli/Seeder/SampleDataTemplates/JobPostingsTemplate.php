<?php
/**
 * POPO Object Template for Job Postings model sample data seeding
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

class JobPostingsTemplate extends CommonTemplate
{
  /**
	 * A Place entity associated with the job position.
	 *
	 * @var    string
   */
  public $job_location;

  /**
	 * Organization offering the job position.
	 *
	 * @var    string
   */
  public $hiring_organization;

  /**
	 * Type of employment (e.g. full-time, part-time, contract, temporary, seasonal, internship).
	 *
	 * @var    string
   */
  public $employment_type;

  /**
	 * The occupation of the job posting using BLS O*NET-SOC taxonomy.
	 *
	 * @var    string
   */
  public $occupational_category;

	/**
	 * The title of the job posting.
	 *
	 * @var    string
   */
  public $title;

	/**
	 * Short description of the job, used in cajobboard on job posting list pages, etc.
	 *
	 * @var    string
   */
  public $disambiguating_description;

	/**
	 * Educational background needed for the position or Occupation.
	 *
	 * @var    string
   */
  public $education_requirements;

	/**
	 * Description of skills and experience needed for the position or Occupation.
	 *
	 * @var    string
   */
  public $experience_requirements;

	/**
	 * Description of bonus and commission compensation aspects of the job. Supersedes incentives.
	 *
	 * @var    string
   */
  public $incentive_compensation;

  /**
	 * Description of benefits associated with the job. Supersedes benefits.
	 *
	 * @var    string
   */
  public $job_benefits;

  /**
	 * Specific qualifications required for this role or Occupation.
	 *
	 * @var    string
   */
  public $qualifications;

  /**
	 * Responsibilities associated with this role or Occupation.
	 *
	 * @var    string
   */
  public $responsibilities;

  /**
	 * Skills required to fulfill this role
	 *
	 * @var    string
   */
  public $skills;

  /**
	 * Any special commitments associated with this job posting. Valid entries include VeteranCommit, MilitarySpouseCommit, etc.
	 *
	 * @var    string
   */
  public $special_commitments;

  /**
	 * The typical working hours for this job (e.g. 1st shift, night shift, 8am-5pm).
	 *
	 * @var    string
   */
  public $work_hours;

  /**
	 * The job title.
	 *
	 * @var    string
   */
  public $relevant_occupation_name;

  /**
	 * The maximum salary of the job or of an employee in an EmployeeRole.
	 *
	 * @var    int
   */
  public $base_salary__max_value;

  /**
	 * The base salary of the job or of an employee in an EmployeeRole.
	 *
	 * @var    int
   */
  public $base_salary__value;

  /**
	 * The minimum salary of the job or of an employee in an EmployeeRole.
	 *
	 * @var    int
   */
  public $base_salary__min_value;

  /**
	 * Use ISO 4217 currency format e.g. USD.
	 *
	 * @var    string
   */
  public $base_salary__currency;

  /**
   * Period of time salary applies to, e.g. per hour, annual salary, etc.
   *
   * Use ISO 8601 duration format, e.g. P2W for bi-weekly.
	 *
	 * @var    string
   */
  public $base_salary__duration;

  /**
	 * Internal identifier used by the employer for this job posting.
	 *
	 * @var    string
   */
  public $identifier;

  /**
	 * URL of the job posting on the employer's website.
	 *
	 * @var    string
   */
  public $same_as;


  /**
	 * Setters for Answer fields
   */


  // $this->belongsTo('jobLocation', 'Places@com_cajobboard', 'job_location', 'place_id');
  public function job_location ($config, $faker)
  {
    $this->job_location = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'Places');
  }

  // $this->belongsTo('hiringOrganization', 'Organizations@com_cajobboard', 'hiring_organization', 'organization_id');
  public function hiring_organization ($config, $faker)
  {
    $this->hiring_organization = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'Organizations');
  }

  // $this->belongsTo('EmploymentType', 'EmploymentTypes@com_cajobboard', 'employment_type', 'employment_type_id');
  public function employment_type ($config, $faker)
  {
    $this->employment_type = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'EmploymentTypes');
  }

  // $this->belongsTo('OccupationalCategory', 'OccupationalCategories@com_cajobboard', 'occupational_category', 'occupational_category_id');
  public function occupational_category ($config, $faker)
  {
    $this->occupational_category = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'OccupationalCategories');
  }

  public function title ($config, $faker)
  {
    $this->title = implode(', ', $faker->words($faker->numberBetween(1, 5)));
  }

  public function disambiguating_description ($config, $faker)
  {
    $this->disambiguating_description = $faker->sentence($faker->numberBetween(6, 15));
  }

  public function education_requirements ($config, $faker)
  {
    $this->education_requirements = implode("\n", $faker->paragraphs($faker->numberBetween(1, 3)));
  }

  public function experience_requirements ($config, $faker)
  {
    $this->experience_requirements = implode("\n", $faker->paragraphs($faker->numberBetween(1, 3)));
  }

  public function incentive_compensation ($config, $faker)
  {
    $this->incentive_compensation = implode("\n", $faker->paragraphs($faker->numberBetween(1, 3)));
  }

  public function job_benefits ($config, $faker)
  {
    $this->job_benefits = implode("\n", $faker->paragraphs($faker->numberBetween(1, 3)));
  }

  public function qualifications ($config, $faker)
  {
    $this->qualifications = implode("\n", $faker->paragraphs($faker->numberBetween(1, 3)));
  }

  public function responsibilities ($config, $faker)
  {
    $this->responsibilities = implode("\n", $faker->paragraphs($faker->numberBetween(1, 3)));
  }

  public function skills ($config, $faker)
  {
    $this->skills = implode("\n", $faker->paragraphs($faker->numberBetween(1, 3)));
  }

  public function special_commitments ($config, $faker)
  {
    $this->special_commitments = implode(', ', $faker->words($faker->numberBetween(1, 5)));
  }

  public function work_hours ($config, $faker)
  {
    $workHours = array('1st shift', 'night shift', '8am-5pm');

    $this->work_hours = $workHours[$faker->numberBetween(0, 2)];
  }

  public function relevant_occupation_name ($config, $faker)
  {
    $this->relevant_occupation_name = implode(', ', $faker->words($faker->numberBetween(1, 5)));
  }

  public function base_salary__max_value ($config, $faker)
  {
    return;
  }

  public function base_salary__value ($config, $faker)
  {
    switch ( $faker->numberBetween(1, 3) )
    {
      case 1:
        $this->base_salary__duration = 'P2W'; // biweekly

        if ( $faker->numberBetween(0, 1) )
        {
          $this->base_salary__value = $faker->numberBetween(7, 35) * 100;
          $this->base_salary__min_value = null;
          $this->base_salary__max_value = null;
        }
        else
        {
          $this->base_salary__value = null;
          $this->base_salary__min_value = $faker->numberBetween(68, 72) * 10;
          $this->base_salary__max_value = $faker->numberBetween(34, 36) * 100;
        }

        break;

      case 2:
        $this->base_salary__duration = 'P1Y'; // yearly

        if ( $faker->numberBetween(0, 1) )
        {
          $this->base_salary__value = $faker->numberBetween(18, 42) * 1000;
          $this->base_salary__min_value = null;
          $this->base_salary__max_value = null;
        }
        else
        {
          $this->base_salary__value = null;
          $this->base_salary__min_value = $faker->numberBetween(16, 20) * 1000;
          $this->base_salary__max_value = $faker->numberBetween(40, 54) * 1000;
        }

        break;

      case 3:
        $this->base_salary__duration = 'PT1H'; // hourly

        if ( $faker->numberBetween(0, 1) )
        {
          $this->base_salary__value = $faker->numberBetween(12, 28);
          $this->base_salary__min_value = null;
          $this->base_salary__max_value = null;
        }
        else
        {
          $this->base_salary__value = null;
          $this->base_salary__min_value = $faker->numberBetween(11, 13);
          $this->base_salary__max_value = $faker->numberBetween(25, 29);
        }

        break;
    }
  }

  public function base_salary__min_value ($config, $faker)
  {
    return;
  }

  public function base_salary__currency ($config, $faker)
  {
    $this->base_salary__currency = 'USD';
  }

  public function base_salary__duration ($config, $faker)
  {
    return;
  }

  public function identifier ($config, $faker)
  {
    $this->identifier = implode(', ', $faker->words($faker->numberBetween(1, 5)));
  }

  public function same_as ($config, $faker)
  {
    $this->same_as = $faker->url();
  }
}
