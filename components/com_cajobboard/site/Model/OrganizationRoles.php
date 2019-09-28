<?php
/**
 * Site Organizational Roles Model
 *
 * Example types are Corporation, Sole Proprietorship, Educational Institution
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Model;

// no direct access
defined( '_JEXEC' ) or die;

use FOF30\Container\Container;

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
class OrganizationRoles extends \Calligraphic\Cajobboard\Admin\Model\OrganizationRoles
{
	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);
  }
}
