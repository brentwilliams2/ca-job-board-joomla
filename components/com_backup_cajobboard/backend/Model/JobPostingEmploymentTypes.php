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
  'name' CHAR(20) NOT NULL COMMENT 'Type of employment (e.g. full-time, part-time, contract, temporary, seasonal, internship)',
  'description' CHAR(255) NOT NULL COMMENT 'details on type of employment',
  'url' VARCHAR(2083) NOT NULL COMMENT 'link to schema for type of employment, e.g. wikipedia page on Full Time',
 *
 */
class JobPostingEmploymentTypes extends \FOF30\Model\DataModel
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
    $this->tableName = "#__cajobboard_job_employment_types";
    $this->idFieldName = "job_employment_type_id";

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
