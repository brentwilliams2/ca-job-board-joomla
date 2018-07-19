<?php
/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model;

// no direct access
defined( '_JEXEC' ) or die;

use FOF30\Container\Container;
use FOF30\Model\DataModel;
use JLoader;

/*
 * Job Posting model
 *
 * Fields:
 *
 * @property  int			$job_posting_id           	    Surrogate unique key.
 * @property  string	$slug                           Alias for SEF URL.
 *
 * SCHEMA: JobPosting
 * @property  string	$title                          The title of the job posting.
 * @property  string	$disambiguating_description     Short description of the job, used in cajobboard on job posting list pages, etc.
 * @property  string	$description                    Long description of the job posting.
 * @property  string	$education_requirements         Educational background needed for the position or Occupation.
 * @property  string	$experience_requirements        Description of skills and experience needed for the position or Occupation.
 * @property  string	$incentive_compensation         Description of bonus and commission compensation aspects of the job.
 * @property  string	$job_benefits                   Description of benefits associated with the job.
 * @property  string	$qualifications                 Specific qualifications required for this role or Occupation.
 * @property  string	$responsibilities               Responsibilities associated with this role or Occupation.
 * @property  string	$skills                         Skills required to fulfill this role.
 * @property  string	$special_commitments            Any special commitments associated with this job posting. Valid entries include VeteranCommit, MilitarySpouseCommit, etc.
 * @property  string	$work_hours                     The typical working hours for this job, e.g. 1st shift, night shift, 8am-5pm.
 *
 * SCHEMA: JobPosting (relevantOccupation) -> Occupation (name)
 * @property  string	$relevant_occupation_name       The job title
 *
 * SCHEMA: JobPosting (baseSalary) -> MonetaryAmount
 * @property  int			$base_salary__max_value         The maximum salary of the job or of an employee in an EmployeeRole
 * @property  int			$base_salary__value             The base salary of the job or of an employee in an EmployeeRole
 * @property  int			$base_salary__min_value         The minimum salary of the job or of an employee in an EmployeeRole
 * @property  int			$base_salary__currency          Currency the salary is denominated in. Use ISO 4217 currency format e.g. USD.
 *
 * SCHEMA: JobPosting (baseSalary) -> MonetaryAmount (additionalType) -> Duration
 * @property  string	$base_salary__duration          Period the salary is paid for. Use ISO 8601 duration format, e.g. P2W for bi-weekly.
 *
 * Relations:
 *
 * SCHEMA: JobPosting
 * @property-read  Users	 	$user		The
 * @property-read  int			$job_location             A typically single geographic location associated with the job position.   FK to #__cajobboard_places(place_id)
 * @property-read  int			$hiring_organization      Organization offering the job position.   FK to #__cajobboard_organizations(organization_id)

 * SCHEMA: https://calligraphic.design/schema/EmploymentType
 * @property-read  string	  $employment_type          Type of employment (e.g. full-time, part-time, contract, temporary, seasonal, internship)',    FK to #__cajobboard_job_employment_type(name)
 *
 * SCHEMA: https://calligraphic.design/schema/OccupationalCategoryBLS
 * @property-read  string	  $occupational_category    The occupation of the job posting. Uses BLS O*NET-SOC taxonomy',    FK to #__cajobboard_job_occupational_category(title)
 *
 */
class JobPostings extends \FOF30\Model\DataModel
{
	/**
	 * Public constructor. Adds and configure behaviours, and set up relations.
	 *
	 * @param   Container  $container
	 * @param   array      $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    // Override behaviours set in the model
    $config['behaviours'] = ['Filters', 'Access', 'Assets', 'Enabled', 'ContentHistory'];

    parent::__construct($container, $config);

    // Override default table names and primary key id so we can use camelCase names
    $this->tableName = "#__cajobboard_job_postings";
    $this->idFieldName = "job_posting_id";

    // Set up relations
    $this->belongsTo('job_location', 'Places', 'job_location');
    $this->belongsTo('hiring_organization', 'Organizations', 'hiring_organization');
    $this->belongsTo('employment_type', 'JobPostingEmploymentTypes', 'employment_type');
    $this->belongsTo('occupational_category', 'JobPostingOccupationalCategories', 'occupational_category');
  }

// check method needs to verify that a SEF-friendly URL 'alias' or 'slug' is URL safe. The alias may
// be auto generated from the title, or entered by the user.
// The 'slug' is used to quickly find table rows from the router: it uses the 'alias', a colon, and the record id
// like '1:about-us'. The reason to use it is build-in Joomla! methods automatically strip the slug part off,
// such as the JInput::int filter.
function check()
{
    jimport('joomla.filter.output');
    if (empty($this->alias))
    {
	    $this->alias = $this->title;
    }
    $this->alias = JFilterOutput::stringURLSafe($this->alias);

    /* All your other checks */
    return true;
}


  protected function onBeforeDoSomething()
  {
    // Do something here...
  }
}
