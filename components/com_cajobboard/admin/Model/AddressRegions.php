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

use FOF30\Container\Container;
use FOF30\Model\DataModel;
use JLog;

JLog::add('Address Regions model called', JLog::DEBUG, 'cajobboard');
/*
 * Address Regions model
 *
 * Enumerated list of regions (states)
 *
 * Fields:
 *
 * @property int      $address_region_id      Surrogate primary key
 * @property string   $name                   The name of the region, e.g. California
 * @property string   $item_list_element      The abbreviation for the region, e.g. CA
 */
class AddressRegions extends \FOF30\Model\DataModel
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

    // override default table names and primary key id
    $this->tableName = "#__cajobboard_address_regions";
    $this->idFieldName = "address_region_id";

    // Add behaviours to the model
    $this->addBehaviour('Language');
    $this->addBehaviour('Tags');
    $this->addBehaviour('Filters');
  }
}
