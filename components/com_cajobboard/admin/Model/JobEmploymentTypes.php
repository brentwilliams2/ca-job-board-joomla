<?php
/**
 * Admin Job Employment Types Model
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
use \Calligraphic\Cajobboard\Admin\Model\BaseModel;

/**
 * Fields:
 *
 * @property int      $job_employment_type_id   Surrogate primary key
 * SCHEMA: Thing
 * @property string   $name          Type of employment (e.g. full-time, part-time, contract, temporary, seasonal, internship)
 * @property string   $description   Detailed description about type of employment
 * @property string   $url           Link to schema for type of employment, e.g. wikipedia page on Full Time
 *
 * Filters / state:
 *
 * @method  $this  myField() typehint
 */
class JobEmploymentTypes extends BaseModel
{
	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    // Not using convention for table names or primary key field
		$config['tableName'] = '#__cajobboard_job_employment_types';
    $config['idFieldName'] = 'job_employment_type_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.employmenttypes';

    parent::__construct($container, $config);

    // Add behaviours to the model
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
    $this->assertNotEmpty($this->title, 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_ERR_TITLE');
    $this->assertNotEmpty($this->description, 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_ERR_DESCRIPTION');
    $this->assertNotEmpty($this->url, 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_ERR_URL');

		parent::check();

    return $this;
  }
}
