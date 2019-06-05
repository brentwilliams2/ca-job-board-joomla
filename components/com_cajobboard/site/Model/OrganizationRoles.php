<?php
/**
 * Site Organization Roles Model
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
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
 * @property int            $organization_id      Surrogate primary key
 * SCHEMA: Thing(additionalType) -> extended types in private namespace (default)
 *
 * @property string         $OrganizationType     The type of organization e.g. Employer, Recruiter, etc., FK to #__cajobboard_organization_types
 *
 * SCHEMA: Thing(additionalType) -> extended types in private namespace (default)
 *
 * @property string         $Branches             Properties managed by this organization, FK to #__cajobboard_places
 */
class OrganizationRoles extends \Calligraphic\Cajobboard\Admin\Model\OrganizationRoles
{
	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);
  }
}
