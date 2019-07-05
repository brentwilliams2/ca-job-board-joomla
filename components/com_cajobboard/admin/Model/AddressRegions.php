<?php
/**
 * Admin Address Region Model
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

use \FOF30\Container\Container;
use \Calligraphic\Cajobboard\Admin\Model\BaseListModel;

/*
 * Fields:
 *
 * @property int      $address_region_id      Surrogate primary key
 * @property string   $name                   The name of the region, e.g. California
 * @property string   $item_list_element      The abbreviation for the region, e.g. CA
 */
class AddressRegions extends BaseListModel
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
    $this->tableName = "#__cajobboard_address_regions";
    $this->idFieldName = "address_region_id";

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.address_regions';

    parent::__construct($container, $config);

    // Set an alias for the title field for DataModel's check() method's slug field auto-population
    $config['aliasFields'] = array('title' => 'name');
  }
}
