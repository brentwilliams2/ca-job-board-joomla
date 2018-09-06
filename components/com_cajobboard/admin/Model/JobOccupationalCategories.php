<?php
/**
 * Job Occupational Categories Model
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
use FOF30\Model\DataModel;
use JLog;

JLog::add('Job Occupational Categories model called', JLog::DEBUG, 'cajobboard');

/**
 * Model class description
 *
 * Fields:
 *
 * @property int      $job_occupational_category_id   Surrogate primary key', UCM (unified content model) properties for internal record metadata
 * @property int      $ordering     Order this job category should show in the group
 * SCHEMA: https://calligraphic.design/schema/OccupationalCategoryBLS
 * @property string   $title        Occupational category title
 * @property string   $code         BLS code specifying this job category
 * @property int      $jobGroup  Group this occupational category should be shown under e.g. office staff
 *
 * Filters / state:
 *
 * @method  $this  myField() typehint
 */
class JobOccupationalCategories extends DataModel
{
  use Mixin\Assertions;

	/**
	 * Public constructor. Overrides the parent constructor.
	 *
	 * @see DataModel::__construct()
	 *
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    // Not using convention for table names or primary key field
		$config['tableName'] = '#__cajobboard_job_occupational_categories';
    $config['idFieldName'] = 'job_occupational_category_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.job_categories';

    parent::__construct($container, $config);

    // many-to-one FK to #__cajobboard_job_occupational_category_group
    $this->belongsTo('jobGroup', 'JobOccupationalCategoryGroup@com_cajobboard', 'group', 'job_occupational_category_group_id');

    // Add behaviours to the model
    $this->addBehaviour('Filters');
    $this->addBehaviour('Language');
    $this->addBehaviour('Tags');
  }

	/**
	 * Perform checks on data for validity
	 *
	 * @return  static  Self, for chaining
	 *
	 * @throws \RuntimeException  When the data bound to this record is invalid
	 */
	public function check()
	{
    $this->assertNotEmpty($this->title, 'COM_CAJOBBOARD_JOB_CATEGORY_ERR_TITLE');
    $this->assertNotEmpty($this->code, 'COM_CAJOBBOARD_JOB_CATEGORY_ERR_CODE');
    $this->assertNotEmpty($this->JobCategory, 'COM_CAJOBBOARD_JOB_CATEGORY_ERR_GROUP');

		parent::check();

    return $this;
	}
}
