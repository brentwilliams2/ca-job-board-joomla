<?php
/**
 * Job Occupational Category Groups Model
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
use JFactory;
use JText;

/**
 * Model class description
 *
 * Fields:
 *
 * @property int      $job_occupational_category_group_id    Surrogate primary key
 * SCHEMA: Thing
 * @property string   $description  Occupational category group description
 * @property string   $url          Link to schema for occupational category, e.g. wikipedia page on Full Time
 * SCHEMA: https://calligraphic.design/schema/OccupationalCategoryBLS
 * @property string   $group        Name this occupational category should be shown under e.g. office staff
 *
 * Filters / state:
 *
 * @method  $this  myField() typehint
 */
class JobOccupationalCategoryGroups extends DataModel
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
		$config['tableName'] = '#__cajobboard_job_occupational_category_groups';
    $config['idFieldName'] = 'job_occupational_category_group_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.jobgroups';

    parent::__construct($container, $config);

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
    $this->assertNotEmpty($this->description, 'COM_CAJOBBOARD_JOB_CATEGORY_ERR_TITLE');
    $this->assertNotEmpty($this->url, 'COM_CAJOBBOARD_JOB_CATEGORY_ERR_CODE');
    $this->assertNotEmpty($this->group, 'COM_CAJOBBOARD_JOB_CATEGORY_ERR_GROUP');

		parent::check();

    return $this;
	}
}
