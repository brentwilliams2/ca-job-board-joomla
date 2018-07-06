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

/*
 * Job Posting model
 *
 * Fields:
 *
 * @property  int			$job_posting_id           	    Surrogate unique key.
 * @property  string	$slug                           Alias for SEF URL.
 *
  'job_occupational_category_id' BIGINT UNSIGNED NOT NULL,
  /* UCM (unified content model) properties for internal record metadata */
  'ordering' SMALLINT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'order this job category should show in the group',
  /* SCHEMA: https://calligraphic.design/schema/OccupationalCategoryBLS */
  'title' CHAR(255) NOT NULL COMMENT 'occupational category title',
  'code' CHAR(10) NOT NULL DEFAULT '0' COMMENT 'BLS code specifying this job category',
  'group' BIGINT UNSIGNED NOT NULL COMMENT 'group this occupational category should be shown under e.g. office staff', /* FK to #__cajobboard_job_occupational_category_group(job_occupational_category_group_id) */
 */
class JobPostingOccupationalCategories extends \FOF30\Model\DataModel
{
	/**
	 * Public constructor. Adds behaviours and sets up the behaviours and the relations
	 *
	 * @param   Container  $container
	 * @param   array      $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);

    // override default table names and primary key id so we can use camelCase names
    $this->tableName = "#__cajobboard_job_occupational_categories";
    $this->idFieldName = "job_occupational_category_id";

		// Add the filtering behaviour
		$this->addBehaviour('Filters');
		$this->blacklistFilters([
			'publish_up',
			'publish_down',
		    'created_on',
    ]);

		// Set up relations
		$this->hasOne('user', 'Users', 'user_id', 'user_id');

		// Used for forms
		$this->addKnownField('_noemail', 0, 'int');
  }
