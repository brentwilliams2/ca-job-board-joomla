<?php
/**
 * Site Organizational Types Model
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
 * @property int      $organization_type_id       Surrogate primary key

 * SCHEMA: Organizaton (OrganizationType) -> ItemList
 * @property string   $item_list_element          The type of organization, e.g. Employer, Recruiter, etc.
 * @property int      $item_list_order_type       The order this item should appear in the list.
 *
 * SCHEMA: Thing
 * @property string   $description                A description of the type of organization.
 * @property string   $url                        Link to schema for organization type, e.g. wikipedia page on Employer.
 */
class OrganizationTypes extends \Calligraphic\Cajobboard\Admin\Model\OrganizationTypes
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
