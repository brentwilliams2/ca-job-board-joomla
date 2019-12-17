<?php
/**
 * POPO Object Template for Occupational Category groups model sample data seeding
 *
 * Uses returns in template properties so that all
 * properties can be loaded at once from real values
 *
 * @package   Calligraphic Job Board
 * @version   31 October, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates;

use Faker;
use \Joomla\CMS\User\UserHelper;

// no direct access
defined('_JEXEC') or die;

class OccupationalCategoryGroupsTemplate extends CommonTemplate
{
  use \Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates\Mixins\Image;


	/**
	 * Name for this group of occupational categories, e.g. office staff
	 *
	 * @property    string
   */
  public $group;


  /**
	 * Link to schema for occupational category, e.g. wikipedia page on Management
	 *
	 * @property    string
   */
  public $url;


  /**
	 * Setters for Comment fields
   */

  public function slug ($config, $faker)
  {
    $this->setTemplateProperties($config, $faker);
  }


  public function group ($config, $faker)
  {
    return;
  }


  public function description ($config, $faker)
  {
    return;
  }


  public function url ($config, $faker)
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

    $this->group = $record['group'];

    $this->description = $record['description'];

    $this->url = $record['url'];
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
        'slug' => 'construction', 'group' => 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_CONSTRUCTION', 'description' => 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_CONSTRUCTION_DESCRIPTION', 'url' => 'https://en.wikipedia.org/wiki/Construction'
      ),
      array(
        'slug' => 'facilities', 'group' => 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_FACILITIES', 'description' => 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_FACILITIES_DESCRIPTION', 'url' => 'https://en.wikipedia.org/wiki/Facility_management'
      ),
      array(
        'slug' => 'finance', 'group' => 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_FINANCE', 'description' => 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_FINANCE_DESCRIPTION', 'url' => 'https://en.wikipedia.org/wiki/Accounting'
      ),
      array(
        'slug' => 'human-resources', 'group' => 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_HR', 'description' => 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_HR_DESCRIPTION', 'url' => 'https://en.wikipedia.org/wiki/Human_resource_management'
      ),
      array(
        'slug' => 'information-technology', 'group' => 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_IT', 'description' => 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_IT_DESCRIPTION', 'url' => 'https://en.wikipedia.org/wiki/Information_technology'
        ),
        array(
        'slug' => 'leasing', 'group' => 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_LEASING', 'description' => 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_LEASING_DESCRIPTION', 'url' => 'https://en.wikipedia.org/wiki/Letting_agent'
      ),
      array(
        'slug' => 'marketing', 'group' => 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_MARKETING', 'description' => 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_MARKETING_DESCRIPTION', 'url' => 'https://en.wikipedia.org/wiki/Marketing'
      ),
      array(
        'slug' => 'office', 'group' => 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_OFFICE', 'description' => 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_OFFICE_DESCRIPTION', 'url' => 'https://en.wikipedia.org/wiki/Office_administration'
      ),
      array(
        'slug' => 'management', 'group' => 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_MGMT', 'description' => 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_MGMT_DESCRIPTION', 'url' => 'https://en.wikipedia.org/wiki/Management'
      ),
      array(
        'slug' => 'other', 'group' => 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_OTHER', 'description' => 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_OTHER_DESCRIPTION', 'url' => 'https://en.wiktionary.org/wiki/other'
      )
    );

    return $records[$recordId - 1];
  }
}
