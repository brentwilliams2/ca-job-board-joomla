<?php
/**
 * Admin Job Posting Model
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model;

// no direct access
defined('_JEXEC') or die;

use FOF30\Container\Container;
use \Calligraphic\Cajobboard\Admin\Model\BaseDataModel;

/**
 * Fields:
 *
 * @property int      $job_posting_id             Surrogate primary key
 * @property string   $slug                       Alias for SEF URL
 *
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
 *
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
 * @property string   $note                       A note to save with this item for use in the back-end interface.
 *
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
 * @property Organizations  $hiringOrganization   Organization offering the job position. FK to #__cajobboard_organizations.
 *
 * SCHEMA: JobPosting (relevantOccupation) -> Occupation (name)
 * @property string   $relevant_occupation_name   The job title.
 *
 * SCHEMA: JobPosting (baseSalary) -> MonetaryAmount
 * @property int      $base_salary__max_value     The maximum salary of the job or of an employee in an EmployeeRole.
 * @property int      $base_salary__value         The base salary of the job or of an employee in an EmployeeRole.
 * @property int      $base_salary__min_value     The minimum salary of the job or of an employee in an EmployeeRole.
 * @property string   $base_salary__currency      Use ISO 4217 currency format e.g. USD.
 *
 * SCHEMA: JobPosting (baseSalary) -> MonetaryAmount (additionalType) -> Duration
 * @property string   $base_salary__duration      Period of time salary applies to, e.g. per hour, annual salary, etc. Use ISO 8601 duration format, e.g. P2W for bi-weekly.
 *
 * SCHEMA: Thing
 * @property string   $identifier                  Internal identifier used by the employer for this job posting.
 * @property string   $sameAs                      URL of the job posting on the employer\s website.
 *
 * SCHEMA: https://calligraphic.design/schema/EmploymentType
 * @property EmploymentTypes  $employmentType  Type of employment (e.g. full-time, part-time, contract, temporary, seasonal, internship).
 *
 * SCHEMA: https://calligraphic.design/schema/OccupationalCategoryBLS
 * @property OccupationalCategories  $occupationalCategory  The occupation of the job posting. Uses BLS O*NET-SOC taxonomy.
 *
 * Filters / state:
 *
 * @method  $this  myField() typehint
 */
class JobPostings extends BaseDataModel
{
  use \FOF30\Model\Mixin\Assertions;

	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    /* Set up config before parent constructor */

    // @TODO: Add this to call the content history methods during create, save and delete operations. CHECK SYNTAX
    // JObserverMapper::addObserverClassToClass('JTableObserverContenthistory', 'JobPostings', array('typeAlias' => 'com_cajobboard.jobpostings'));

    // Not using convention for table names or primary key field
		$config['tableName'] = '#__cajobboard_job_postings';
    $config['idFieldName'] = 'job_posting_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.jobpostings';

    // Add behaviours to the model. Filters, Created, and Modified behaviours are added automatically.
    $config['behaviours'] = array(
      'Access',     // Filter access to items based on viewing access levels
      'Assets',     // Add Joomla! ACL assets support
      'Category',   // Set category in new records
      'Check',      // Validation checks for model, over-rideable per model
      //'ContentHistory', // Add Joomla! content history support
      'Enabled',    // Filter access to items based on enabled status
      'Language',   // Filter front-end access to items based on language
      'Metadata',   // Set the 'metadata' JSON field on record save
      'Ordering',   // Order items owned by featured status and then descending by date
      //'Own',        // Filter access to items owned by the currently logged in user only
      //'PII',        // Filter access for items that have Personally Identifiable Information
      'Publish',    // Set the publish_on field for new records
      'Slug',       // Backfill the slug field with the 'title' property or its fieldAlias if empty
      //'Tags'        // Add Joomla! Tags support
    );

    parent::__construct($container, $config);

    /* Set up relations after parent constructor */

    // many-to-one FK to  #__cajobboard_places
    $this->belongsTo('JobLocation', 'Places@com_cajobboard', 'job_location', 'place_id');

    // many-to-one FK to  #__cajobboard_organizations
    $this->belongsTo('HiringOrganization', 'Organizations@com_cajobboard', 'hiring_organization', 'organization_id');

    // many-to-one FK to  #__cajobboard_employment_types
    $this->belongsTo('EmploymentType', 'EmploymentTypes@com_cajobboard', 'employment_type', 'employment_type_id');

    // many-to-one FK to #__cajobboard_occupational_categories
    $this->belongsTo('OccupationalCategory', 'OccupationalCategories@com_cajobboard', 'occupational_category', 'occupational_category_id');

    // one-to-one FK to #__cajobboard_employer_aggregate_ratings
    $this->hasOne('AggregateReviews', 'EmployerAggregateRatings@com_cajobboard', 'job_posting_id', 'employer_aggregate_rating_id');
  }

  public function notifyConnectorsOnNewJobPosting()
  {
    /*
    @TODO: At some point want to send connectors an email saying, "Do you happen to know anyone
           who would be interested in this job?", so we will need to give them a way to opt out
           of that type of email.
    */
  }

 /*
  @TODO: add ability for employers to add custom template, from spec:
  Plan on having a template system where employers can create standard templates for their job listings.
  */

  /*
  @TODO: from specs -  What if we start building content pages for "Property Management Jobs in XYZ city"?
  Maybe have the system do that automatically when a new job is posted in a new city?  Things to include:
    a. Jobs in that city
    b. Employers who have historically posted jobs in that city
    c. Networking opportunities, maybe?  Maybe list Insiders in that area?
    d. Press releases about acquisitions/etc in that area.
  */

  /*
  @TODO: Need to check and bill the client when the job posting is set to "published", but allow "draft" job postings w/o billing

  @TODO: Also the issue of job posting templates, so button to copy a job posting
  */

  /*
  @TODO: implement a "Do you know someone who might like this job?" feature like Quora (email to users) for job postings,
         also "Share this job with User x" button to message / email a request
  */

  /**
	 * Perform checks on data for validity
	 *
	 * @return  static  Self, for chaining
	 *
	 * @throws \RuntimeException  When the data bound to this record is invalid
	 */
	public function check()
	{
    // @TODO: Finish validation checks
    $this->assertNotEmpty($this->title, 'COM_CAJOBBOARD_JOB_POSTING_ERR_TITLE');

		parent::check();

    return $this;
  }
}
