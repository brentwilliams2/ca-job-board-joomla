<?php
/**
 * POPO Object Template for Occupational Categories model sample data seeding
 *
 * Uses returns in template properties so that all
 * properties can be loaded at once from real values
 *
 * @package   Calligraphic Job Board
 * @version   7 September, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates;

use Faker;
use \Joomla\CMS\User\UserHelper;

// no direct access
defined('_JEXEC') or die;

class OccupationalCategoriesTemplate extends CommonTemplate
{
  use \Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates\Mixins\Image;

	/**
	 * BLS code specifying this job category
	 *
	 * @property    string
   */
  public $code;


	/**
	 * Group this occupational category should be shown under e.g. office staff, FK to #__cajobboard_job_occupational_category_group
	 *
	 * @property    int
   */
  public $group;


  /**
	 * Setters for Comment fields
   */

  public function code ($config, $faker)
  {
    $this->setTemplateProperties($config, $faker);
  }


  public function group ($config, $faker)
  {
    return;
  }


  public function slug ($config, $faker)
  {
    return;
  }


  public function ordering ($config, $faker)
  {
    return;
  }


  public function name ($config, $faker)
  {
    return;
  }


  public function created_by ($config, $faker)
  {
    $this->created_by = UserHelper::getUserId('admin');
  }


 /**
  * Loads all values at once with real values (from audio file)
  */
  protected function setTemplateProperties ($config, $faker)
  {
    $record = $this->loadRecord($config->item_id);

    $this->slug = $record['slug'];

    $this->code = $record['code'];

    $this->ordering = $record['ordering'];

    $this->group = $record['group'];

    $this->name = $record['name'];
  }


  /**
   * Return metadata for an audio file saved on disk in the media/audio directory
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
        'slug' => 'general-and-operations-managers', 'code' => '11-1021.00', 'ordering' => 1, 'group' => 9, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_GENERAL_AND_OPERATIONS_MANAGERS'
      ),
      array(
        'slug' => 'property-and-community-managers', 'code' => '11-9141.00', 'ordering' => 2, 'group' => 9, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_PROPERTY_AND_COMMUNITY_MANAGERS'
      ),
      array(
        'slug' => 'regulatory-affairs-managers', 'code' => '11-9199.01', 'ordering' => 3, 'group' => 9, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_REGULATORY_AFFAIRS_MANAGERS'
      ),
      array(
        'slug' => 'other-managers', 'code' => '11-9199.00', 'ordering' => 4, 'group' => 9, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_OTHER_MANAGERS'
      ),
      array(
        'slug' => 'leasing-and-sales-managers-and-executives', 'code' => '11-2022.00', 'ordering' => 1, 'group' => 6, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_LEASING_AND_SALES_MANAGERS_AND_EXECUTIVES'
      ),
      array(
        'slug' => 'leasing-and-sales-agents', 'code' => '41-3099.00', 'ordering' => 2, 'group' => 6, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_LEASING_AND_SALES_AGENTS'
      ),
      array(
        'slug' => 'marketing-managers-and-executives', 'code' => '11-2021.00', 'ordering' => 1, 'group' => 7, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_MARKETING_MANAGERS_AND_EXECUTIVES'
      ),
      array(
        'slug' => 'marketing-specialists', 'code' => '13-1161.00', 'ordering' => 2, 'group' => 7, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_MARKETING_SPECIALISTS'
      ),
      array(
        'slug' => 'financial-managers-and-executives', 'code' => '11-3031.00', 'ordering' => 1, 'group' => 3, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_FINANCIAL_MANAGERS_AND_EXECUTIVES'
      ),
      array(
        'slug' => 'accountants', 'code' => '13-2011.01', 'ordering' => 2, 'group' => 3, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_ACCOUNTANTS'
      ),
      array(
        'slug' => 'bookkeepers-and-accounting-clerks', 'code' => '43-3031.00', 'ordering' => 3, 'group' => 3, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_BOOKKEEPERS_AND_ACCOUNTING_CLERKS'
      ),
      array(
        'slug' => 'information-technology-managers-and-executives', 'code' => '11-3021.00', 'ordering' => 1, 'group' => 5, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_INFORMATION_TECHNOLOGY_MANAGERS_AND_EXECUTIVES'
      ),
      array(
        'slug' => 'computer-programmers', 'code' => '15-1131.00', 'ordering' => 2, 'group' => 5, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_COMPUTER_PROGRAMMERS'
      ),
      array(
        'slug' => 'web-administrators', 'code' => '15-1199.03', 'ordering' => 3, 'group' => 5, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_WEB_ADMINISTRATORS'
      ),
      array(
        'slug' => 'human-resources-managers-and-executives', 'code' => '11-3121.00', 'ordering' => 1, 'group' => 4, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_HUMAN_RESOURCES_MANAGERS_AND_EXECUTIVES'
      ),
      array(
        'slug' => 'training-and-development-managers', 'code' => '11-3131.00', 'ordering' => 2, 'group' => 4, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_TRAINING_AND_DEVELOPMENT_MANAGERS'
      ),
      array(
        'slug' => 'human-resources-specialists', 'code' => '13-1071.00', 'ordering' => 3, 'group' => 4, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_HUMAN_RESOURCES_SPECIALISTS'
      ),
      array(
        'slug' => 'office-managers-and-executives', 'code' => '11-3011.00', 'ordering' => 1, 'group' => 8, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_OFFICE_MANAGERS_AND_EXECUTIVES'
      ),
      array(
        'slug' => 'secretaries-and-administrative-assistants', 'code' => '43-6014.00', 'ordering' => 2, 'group' => 8, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_SECRETARIES_AND_ADMINISTRATIVE_ASSISTANTS'
      ),
      array(
        'slug' => 'receptionists', 'code' => '43-4171.00', 'ordering' => 3, 'group' => 8, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_RECEPTIONISTS'
      ),
      array(
        'slug' => 'customer-service-representatives', 'code' => '43-4051.00', 'ordering' => 4, 'group' => 8, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_CUSTOMER_SERVICE_REPRESENTATIVES'
      ),
      array(
        'slug' => 'file-clerks', 'code' => '43-4071.00', 'ordering' => 5, 'group' => 8, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_FILE_CLERKS'
      ),
      array(
        'slug' => 'compliance-officers', 'code' => '13-1041.00', 'ordering' => 6, 'group' => 8, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_COMPLIANCE_OFFICERS'
      ),
      array(
        'slug' => 'equal-opportunity-representatives-and-officers', 'code' => '13-1041.03', 'ordering' => 7, 'group' => 8, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_EQUAL_OPPORTUNITY_REPRESENTATIVES_AND_OFFICERS'
      ),
      array(
        'slug' => 'housekeeping-and-janitorial-supervisors', 'code' => '37-1011.00', 'ordering' => 1, 'group' => 2, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_HOUSEKEEPING_AND_JANITORIAL_SUPERVISORS'
      ),
      array(
        'slug' => 'janitors-and-cleaners', 'code' => '37-2011.00', 'ordering' => 2, 'group' => 2, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_JANITORS_AND_CLEANERS'
      ),
      array(
        'slug' => 'landscaping-lawn-service-and-groundskeeping-supervisors', 'code' => '37-1012.00', 'ordering' => 3, 'group' => 2, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_LANDSCAPING_LAWN_SERVICE_AND_GROUNDSKEEPING_SUPERVISORS'
      ),
      array(
        'slug' => 'landscaping-and-groundskeeping-workers', 'code' => '37-3011.00', 'ordering' => 4, 'group' => 2, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_LANDSCAPING_AND_GROUNDSKEEPING_WORKERS'
      ),
      array(
        'slug' => 'maintenance-supervisors', 'code' => '49-1011.00', 'ordering' => 5, 'group' => 2, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_MAINTENANCE_SUPERVISORS'
      ),
      array(
        'slug' => 'maintenance-workers', 'code' => '49-9071.00', 'ordering' => 6, 'group' => 2, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_MAINTENANCE_WORKERS'
      ),
      array(
        'slug' => 'security-managers', 'code' => '11-9199.07', 'ordering' => 7, 'group' => 2, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_SECURITY_MANAGERS'
      ),
      array(
        'slug' => 'security-guards', 'code' => '33-9032.00', 'ordering' => 8, 'group' => 2, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_SECURITY_GUARDS'
      ),
      array(
        'slug' => 'pest-control-workers', 'code' => '37-2021.00', 'ordering' => 9, 'group' => 2, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_PEST_CONTROL_WORKERS'
      ),
      array(
        'slug' => 'project-and-construction-managers', 'code' => '11-9021.00', 'ordering' => 1, 'group' => 1, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_PROJECT_AND_CONSTRUCTION_MANAGERS'
      ),
      array(
        'slug' => 'construction-supervisors', 'code' => '47-1011.00', 'ordering' => 2, 'group' => 1, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_CONSTRUCTION_SUPERVISORS'
      ),
      array(
        'slug' => 'construction-workers-general', 'code' => '47-4099.00', 'ordering' => 3, 'group' => 1, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_CONSTRUCTION_WORKERS_GENERAL'
      ),
      array(
        'slug' => 'brickmasons-and-blockmasons', 'code' => '47-2021.00', 'ordering' => 4, 'group' => 1, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_BRICKMASONS_AND_BLOCKMASONS'
      ),
      array(
        'slug' => 'carpenters', 'code' => '47-2031.00', 'ordering' => 5, 'group' => 1, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_CARPENTERS'
      ),
      array(
        'slug' => 'carpet-installers', 'code' => '47-2041.00', 'ordering' => 6, 'group' => 1, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_CARPET_INSTALLERS'
      ),
      array(
        'slug' => 'construction-laborers', 'code' => '47-2061.00', 'ordering' => 7, 'group' => 1, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_CONSTRUCTION_LABORERS'
      ),
      array(
        'slug' => 'drywall-and-ceiling-tile-installers', 'code' => '47-2081.00', 'ordering' => 8, 'group' => 1, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_DRYWALL_AND_CEILING_TILE_INSTALLERS'
      ),
      array(
        'slug' => 'electricians', 'code' => '47-2111.00', 'ordering' => 9, 'group' => 1, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_ELECTRICIANS'
      ),
      array(
        'slug' => 'painters-construction-and-maintenance', 'code' => '47-2141.00', 'ordering' => 10, 'group' => 1, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_PAINTERS_CONSTRUCTION_AND_MAINTENANCE'
      ),
      array(
        'slug' => 'plumbers', 'code' => '47-2152.02', 'ordering' => 11, 'group' => 1, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_PLUMBERS'
      ),
      array(
        'slug' => 'roofers', 'code' => '47-2181.00', 'ordering' => 12, 'group' => 1, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_ROOFERS'
      ),
      array(
        'slug' => 'other', 'code' => '00-0000.00', 'ordering' => 1, 'group' => 10, 'name' => 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_OTHER'
      )
    );

    return $records[$recordId - 1];
  }
}


