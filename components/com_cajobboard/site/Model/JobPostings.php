<?php
/**
 * Site Job Posting Model
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Model;

// no direct access
defined('_JEXEC') or die;

use FOF30\Container\Container;

/**
 * Fields:
 *
 * @property int      $job_posting_id             Surrogate primary key
 * @property string   $slug                       Alias for SEF URL
 * FOF "magic" fields
 * @property int      $asset_id                   FK to the #__assets table for access control purposes.
 * @property int      $access                     The Joomla! view access level.
 * @property int      $enabled                    Publish status: -2 for trashed and marked for deletion, -1 for archived, 0 for unpublished, and 1 for published.
 * @property string   $created_on                 Timestamp of record creation, auto-filled by save().
 * @property int      $created_by                 User ID who created the record, auto-filled by save().
 * @property string   $modified_on                Timestamp of record modification, auto-filled by save(), touch().
 * @property int      $modified_by                User ID who modified the record, auto-filled by save(), touch().
 * @property string   $locked_on                  Timestamp of record locking, auto-filled by lock(), unlock().
 * @property int      $locked_by                  User ID who locked the record, auto-filled by lock(), unlock().
 * SCHEMA: Joomla UCM fields, used by Joomla!s UCM when using the FOF ContentHistory behaviour
 * @property string   $publish_up                 Date and time to change the state to published, schema.org alias is datePosted.
 * @property string   $publish_down               Date and time to change the state to unpublished.
 * @property int      $version                    Version of this item.
 * @property int      $ordering                   Order this record should appear in for sorting.
 * @property object   $metadata                   JSON encoded metadata field for this item.
 * @property string   $metakey                    Meta keywords for this item.
 * @property string   $metadesc                   Meta description for this item.
 * @property string   $xreference                 A reference to enable linkages to external data sets, used to output a meta tag like FB open graph.
 * @property string   $params                     JSON encoded parameters for this item.
 * @property string   $language                   The language code for the article or * for all languages.
 * @property int      $cat_id                     Category ID for this item.
 * @property int      $hits                       Number of hits the item has received on the site.
 * @property int      $featured                   Whether this item is featured or not.
 * SCHEMA: JobPosting
 * @property string   $title                      The title of the job posting.
 * @property string   $disambiguating_description Short description of the job, used in cajobboard on job posting list pages, etc.
 * @property string   $description                Long description of the job posting.
 * @property string   $education_requirements     Educational background needed for the position or Occupation.
 * @property string   $experience_requirements    Description of skills and experience needed for the position or Occupation.
 * @property string   $incentive_compensation     Description of bonus and commission compensation aspects of the job. Supersedes incentives.
 * @property string   $job_benefits               Description of benefits associated with the job. Supersedes benefits.
 * @property string   $qualifications             Specific qualifications required for this role or Occupation.
 * @property string   $responsibilities           Responsibilities associated with this role or Occupation.
 * @property string   $skills                     Skills required to fulfill this role
 * @property string   $special_commitments        Any special commitments associated with this job posting. Valid entries include VeteranCommit, MilitarySpouseCommit, etc.
 * @property string   $work_hours                 The typical working hours for this job (e.g. 1st shift, night shift, 8am-5pm).
 * @property Places   $jobLocation                A (typically single) geographic location associated with the job position.
 * @property Organizations  $hiringOrganization   Organization offering the job position. FK to #__cajobboard_organizations
 * SCHEMA: JobPosting (relevantOccupation) -> Occupation (name)
 * @property string   $relevant_occupation_name   The job title.
 * SCHEMA: JobPosting (baseSalary) -> MonetaryAmount
 * @property int      $base_salary__max_value     The maximum salary of the job or of an employee in an EmployeeRole.
 * @property int      $base_salary__value         The base salary of the job or of an employee in an EmployeeRole.
 * @property int      $base_salary__min_value     The minimum salary of the job or of an employee in an EmployeeRole.
 * @property string   $base_salary__currency      Use ISO 4217 currency format e.g. USD.
 * SCHEMA: JobPosting (baseSalary) -> MonetaryAmount (additionalType) -> Duration
 * @property string   $base_salary__duration      Period of time salary applies to, e.g. per hour, annual salary, etc. Use ISO 8601 duration format, e.g. P2W for bi-weekly.
 * SCHEMA: Thing
 * @property string   $identifier                  Internal identifier used by the employer for this job posting.
 * @property string   $sameAs                      URL of the job posting on the employer\s website.
 * SCHEMA: https://calligraphic.design/schema/EmploymentType
 * @property JobEmploymentTypes  $employmentType  Type of employment (e.g. full-time, part-time, contract, temporary, seasonal, internship).
 * SCHEMA: https://calligraphic.design/schema/OccupationalCategoryBLS
 * @property OccupationalCategories  $occupationalCategory  The occupation of the job posting. Uses BLS O*NET-SOC taxonomy.
 */
class JobPostings extends \Calligraphic\Cajobboard\Admin\Model\JobPostings
{
	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);
  }
}
