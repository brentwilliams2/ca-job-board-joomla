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
use FOF30\Model\DataModel;

/*
 * Places model
 *
 * Describes more of less fixed physical places
 *
 * Fields:
 *
 * @property int      $organization_type_id       Surrogate primary key

 * SCHEMA: Organizaton (OrganizationType) -> ItemList
 * @property string   $itemListElement            The type of organization, e.g. Employer, Recruiter, etc.
 * @property int      $itemListOrderType          The order this item should appear in the list.
 *
 * SCHEMA: Thing
 * @property string   $description                A description of the type of organization.
 * @property string   $url                        Link to schema for organization type, e.g. wikipedia page on Employer.
 */
class OrganizationRoles extends \FOF30\Model\DataModel
{
	/**
	 * Public constructor. Adds behaviours and sets up the behaviours and the relations
	 *
	 * @param   Container  $container
	 * @param   array      $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    // override default table names and primary key id
    $this->tableName = "#__cajobboard_organization_roles";
    $this->idFieldName = "organization_role_id";

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.organizational_roles';

    parent::__construct($container, $config);

    // Add behaviours to the model
    $this->addBehaviour('Language');
    $this->addBehaviour('Tags');
    $this->addBehaviour('Filters');
  }
}
