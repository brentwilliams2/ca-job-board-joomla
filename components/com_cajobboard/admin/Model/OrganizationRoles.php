<?php
/**
 * Admin Organizational Roles Model
 *
 * Example types are Corporation, Sole Proprietorship, Educational Institution
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
defined( '_JEXEC' ) or die;

use \Calligraphic\Cajobboard\Admin\Model\Helper\TableFields;
use \FOF30\Container\Container;
use \FOF30\Model\DataModel;

/*
 * Fields:
 *
 * @property int      $organization_role_id       Surrogate primary key
 *
 * SCHEMA: Organizaton (additionalType) -> Role(roleName)
 * @property string   $role_name      The role of the organization, e.g. Employer, Recruiter, etc.
 *
 * SCHEMA: Thing
 * @property string   $description    A description of the role of the organization
 * @property string   $url            Link to schema for organization type, e.g. wikipedia page on Employer, Recruiter, etc.
 */
class OrganizationRoles extends DataModel
{
  /* Traits to include in the class */

  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Constructor;          // Refactored base-class constructor, called from __construct method
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Core;                 // Utility methods
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Patches;              // Over-ridden FOF30 DataModel methods (some with PRs)
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\TableFields;          // Use an array of table fields instead of database reads on each table
	use \Calligraphic\Cajobboard\Admin\Model\Mixin\Validation;           // Provides over-ridden 'check' method

	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    // override default table names and primary key id
		$config['tableName'] = '#__cajobboard_organization_roles';
    $config['idFieldName'] = 'organization_role_id';

    // Define a contentType to enable the Tags behaviour
		$config['contentType'] = 'com_cajobboard.organizational_roles';

		// Set an alias for the title field for DataModel's check() method's slug field auto-population
		$config['aliasFields'] = array('title' => 'name');

    // Add behaviours to the model. Filters behaviour is added automatically.
    $behaviours = array(
      /* Validation checks. Single slash is escaped to a double slash in over-ridden addBehaviour() method in Model/Mixin/Core.php */
      'Check',            // Validation checks for model, over-rideable per model
      'Check/Title',      // Check length and titlecase the 'metadata' JSON field on record save
    );

    /* Overridden constructor */
    $this->constructor($container, $config);
  }
}
