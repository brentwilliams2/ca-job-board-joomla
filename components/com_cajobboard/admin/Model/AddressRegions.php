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
use \Calligraphic\Cajobboard\Admin\Model\BaseModel;

/*
 * Fields:
 *
 * @property int      $address_region_id      Surrogate primary key
 * @property string   $name                   The name of the region, e.g. California
 * @property string   $item_list_element      The abbreviation for the region, e.g. CA
 */
class AddressRegions extends BaseModel
{
  use Mixin\Assertions;

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

    // Add behaviours to the model. Filters, Created, and Modified behaviours are added automatically.
    $config['behaviours'] = array(
      //'Access',     // Filter access to items based on viewing access levels
      //'Assets',     // Add Joomla! ACL assets support
      //'Category',   // Set category in new records
      'Check',      // Validation checks for model, over-rideable per model
      //'ContentHistory', // Add Joomla! content history support
      'Enabled',    // Filter access to items based on enabled status
      'Language',   // Filter front-end access to items based on language
      'Metadata',   // Set the 'metadata' JSON field on record save
      'Ordering',   // Order items owned by featured status and then descending by date
      //'Own',        // Filter access to items owned by the currently logged in user only
      //'PII',        // Filter access for items that have Personally Identifiable Information
      'Publish',    // Set the publish_on field for new records
      'Slug',       // Backfill the slug field with the 'title' property or its fieldAlias if empty
      'Tags'        // Add Joomla! Tags support
    );
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
    $this->assertNotEmpty($this->name, 'COM_CAJOBBOARD_ADDRESS_REGION_ERR_TITLE');
    $this->assertNotEmpty($this->item_list_element, 'COM_CAJOBBOARD_ADDRESS_REGION_ERR_ABBREVIATION');

		parent::check();

    return $this;
	}
}
