<?php
/**
 * POPO Object Template for Address Regions model sample data seeding
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates;

use Faker;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\User\UserHelper;

// no direct access
defined('_JEXEC') or die;

class AddressRegionsTemplate extends CommonTemplate
{
  /**
	 * The abbreviation for the region, e.g. CA
	 *
	 * @property    int
   */
  public $item_list_element;


	/**
	 * Class constructor
   *
   * @throws \Exception
	 */
  public function __construct()
  {
    $lang = Factory::getLanguage();

    $lang->load('address_regions', JPATH_ADMINISTRATOR . '/components/com_cajobboard', $lang->getTag(), true);
  }


  /**
	 * Setters for Address Region fields
   */


  public function item_list_element ($config, $faker)
  {
    $record = $this->loadRecord($config->item_id);

    $this->item_list_element = $record['item_list_element'];
    $this->name = $record['name'];
    $this->slug = $this->hyphenate( Text::_( $record['name'] ) );
  }


  public function name ($config, $faker)
  {
    return;
  }


  public function enabled ($config, $faker)
  {
    $this->enabled = 1;
  }


  public function slug ($config, $faker)
  {
    return;
  }


  public function created_by ($config, $faker)
  {
    $this->created_by = UserHelper::getUserId('admin');
  }


  /**
   * Return metadata for an address region
   *
   * NOTE: The number of records to generate in config.json for this template
   *       must match the number of elements in the returned array here
   *
   * @param   int   $recordId   The ID number of the record to get metadata for
   *
   * @return  array   An array of metadata for the record
   */
  public function loadRecord ($recordId)
  {
    $records = array(
      array(
        'item_list_element' => 'AL', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_ALABAMA'
      ),
      array(
        'item_list_element' => 'AK', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_ALASKA'
      ),
      array(
        'item_list_element' => 'AZ', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_ARIZONA'
      ),
      array(
        'item_list_element' => 'AR', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_ARKANSAS'
      ),
      array(
        'item_list_element' => 'CA', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_CALIFORNIA'
      ),
      array(
        'item_list_element' => 'CO', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_COLORADO'
      ),
      array(
        'item_list_element' => 'CT', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_CONNECTICUT'
      ),
      array(
        'item_list_element' => 'DE', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_DELAWARE'
      ),
      array(
        'item_list_element' => 'FL', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_FLORIDA'
      ),
      array(
        'item_list_element' => 'GA', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_GEORGIA'
      ),
      array(
        'item_list_element' => 'HI', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_HAWAII'
      ),
      array(
        'item_list_element' => 'ID', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_IDAHO'
      ),
      array(
        'item_list_element' => 'IL', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_ILLINOIS'
      ),
      array(
        'item_list_element' => 'IN', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_INDIANA'
      ),
      array(
        'item_list_element' => 'IA', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_IOWA'
      ),
      array(
        'item_list_element' => 'KS', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_KANSAS'
      ),
      array(
        'item_list_element' => 'KY', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_KENTUCKY'
      ),
      array(
        'item_list_element' => 'LA', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_LOUISIANA'
      ),
      array(
        'item_list_element' => 'ME', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_MAINE'
      ),
      array(
        'item_list_element' => 'MD', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_MARYLAND'
      ),
      array(
        'item_list_element' => 'MA', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_MASSACHUSETTS'
      ),
      array(
        'item_list_element' => 'MI', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_MICHIGAN'
      ),
      array(
        'item_list_element' => 'MN', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_MINNESOTA'
      ),
      array(
        'item_list_element' => 'MS', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_MISSISSIPPI'
      ),
      array(
        'item_list_element' => 'MO', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_MISSOURI'
      ),
      array(
        'item_list_element' => 'MT', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_MONTANA'
      ),
      array(
        'item_list_element' => 'NE', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_NEBRASKA'
      ),
      array(
        'item_list_element' => 'NV', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_NEVADA'
      ),
      array(
        'item_list_element' => 'NH', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_NEW_HAMPSHIRE'
      ),
      array(
        'item_list_element' => 'NJ', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_NEW_JERSEY'
      ),
      array(
        'item_list_element' => 'NM', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_NEW_MEXICO'
      ),
      array(
        'item_list_element' => 'NY', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_NEW_YORK'
      ),
      array(
        'item_list_element' => 'NC', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_NORTH_CAROLINA'
      ),
      array(
        'item_list_element' => 'ND', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_NORTH_DAKOTA'
      ),
      array(
        'item_list_element' => 'OH', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_OHIO'
      ),
      array(
        'item_list_element' => 'OK', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_OKLAHOMA'
      ),
      array(
        'item_list_element' => 'OR', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_OREGON'
      ),
      array(
        'item_list_element' => 'PA', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_PENNSYLVANIA'
      ),
      array(
        'item_list_element' => 'RI', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_RHODE_ISLAND'
      ),
      array(
        'item_list_element' => 'SC', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_SOUTH_CAROLINA'
      ),
      array(
        'item_list_element' => 'SD', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_SOUTH_DAKOTA'
      ),
      array(
        'item_list_element' => 'TN', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_TENNESSEE'
      ),
      array(
        'item_list_element' => 'TX', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_TEXAS'
      ),
      array(
        'item_list_element' => 'UT', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_UTAH'
      ),
      array(
        'item_list_element' => 'VT', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_VERMONT'
      ),
      array(
        'item_list_element' => 'VA', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_VIRGINIA'
      ),
      array(
        'item_list_element' => 'WA', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_WASHINGTON'
      ),
      array(
        'item_list_element' => 'WV', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_WEST_VIRGINIA'
      ),
      array(
        'item_list_element' => 'WI', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_WISCONSIN'
      ),
      array(
        'item_list_element' => 'WY', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_WYOMING'
      ),
      array(
        'item_list_element' => 'AS', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_AMERICAN_SAMOA'
      ),
      array(
        'item_list_element' => 'DC', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_DISTRICT_OF_COLUMBIA'
      ),
      array(
        'item_list_element' => 'FM', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_FEDERATED_STATES_OF_MICRONESIA'
      ),
      array(
        'item_list_element' => 'GU', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_GUAM'
      ),
      array(
        'item_list_element' => 'MH', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_MARSHALL_ISLANDS'
      ),
      array(
        'item_list_element' => 'MP', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_NORTHERN_MARIANA_ISLANDS'
      ),
      array(
        'item_list_element' => 'PW', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_PALAU'
      ),
      array(
        'item_list_element' => 'PR', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_PUERTO_RICO'
      ),
      array(
        'item_list_element' => 'VI', 'name' => 'COM_CAJOBBOARD_ADDRESS_REGION_VIRGIN_ISLANDS'
      )
    );

    return $records[$recordId - 1];
  }
}
