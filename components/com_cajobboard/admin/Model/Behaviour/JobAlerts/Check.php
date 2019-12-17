<?php
/**
 * FOF model behavior class for Job Alert model validation
 *
 * @package   Calligraphic Job Board
 * @version   October 30, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model\Behaviour\JobAlerts;

// no direct access
defined( '_JEXEC' ) or die;

use \FOF30\Model\DataModel;
use \Calligraphic\Cajobboard\Admin\Model\Behaviour\Check as BaseCheck;

class Check extends BaseCheck
{
  /* Trait methods to include in class */
  use \Calligraphic\Cajobboard\Admin\Model\Behaviour\Mixin\Assertions;

  /**
	 * Add the category id field to the fieldsSkipChecks list of the model.
	 * it should be empty so that we can fill it in through this behaviour.
	 *
	 * @param   DataModel  $model
	 */
	public function onCheck(DataModel $model)
	{
    parent::onCheck($model);

    // The person this job alert belongs to, FK to #__cajobboard_persons
    $this->assertNotEmpty( $model->getFieldValue('about'), 'COM_CAJOBBOARD_JOB_ALERT_ERR_ABOUT');

    // The geographic coordinates of the center of the job seekers search radius, FK to #__cajobboard_geo_coordinates
    $this->assertNotEmpty( $model->getFieldValue('geo_coordinate'),    'COM_CAJOBBOARD_JOB_ALERT_ERR_GEO_COORDINATE');

    // The distance in miles to search for jobs from the job seekers search radius center point, SCHEMA: https://schema.org/geoRadius
    $this->assertNotEmpty( $model->getFieldValue('geo_radius'),     'COM_CAJOBBOARD_JOB_ALERT_ERR_GEO_RADIUS');

    // A category describing the job, FK to #__cajobboard_occupational_categories
    $this->assertNotEmpty( $model->getFieldValue('occupational_category'), 'COM_CAJOBBOARD_JOB_ALERT_ERR_OCCUPATIONAL_CATEGORY');

    // Used to filter jobs shown for this alert. Should be a case-insensitive array of keywords, e.g. [ "great customers", "friendly", "fun" ],  SCHEMA: https://schema.org/keywords
    $this->assertNotEmpty( $model->getFieldValue('keywords'),    'COM_CAJOBBOARD_JOB_ALERT_ERR_KEYWORDS');

    // Date this job alert is no long needed, SCHEMA: https://schema.org/expires
    $this->assertNotEmpty( $model->getFieldValue('expires'),     'COM_CAJOBBOARD_JOB_ALERT_ERR_EXPIRES');
  }
}
