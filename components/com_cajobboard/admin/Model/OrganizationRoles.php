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

use FOF30\Container\Container;
use \Calligraphic\Cajobboard\Admin\Model\BaseDataModel;

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
class OrganizationRoles extends BaseDataModel
{
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

    parent::__construct($container, $config);
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
    // @TODO: Finish validation checks
    $this->assertNotEmpty($this->title, 'COM_CAJOBBOARD_ORGANIZATION_ROLES_ERR_ROLE_NAME');
    $this->assertNotEmpty($this->title, 'COM_CAJOBBOARD_ORGANIZATION_ROLES_ERR_DESCRIPTION');
    $this->assertNotEmpty($this->title, 'COM_CAJOBBOARD_ORGANIZATION_ROLES_ERR_URL');

		parent::check();

    return $this;
  }
}
