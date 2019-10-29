<?php
/**
 * POPO Object Template for Employment Types model sample data seeding
 *
 * @package   Calligraphic Job Board
 * @version   October 26, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates;

use \Faker;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;

class EmploymentTypesTemplate extends CommonTemplate
{
  /**
	 * Link to schema for type of employment, e.g. wikipedia page on Full Time
	 *
	 * @property    int
   */
  public $url;


	/**
	 * Class constructor
   *
   * @throws \Exception
	 */
  public function __construct()
  {
    $lang = Factory::getLanguage();

    $lang->load('employment_types', JPATH_ADMINISTRATOR . '/components/com_cajobboard', $lang->getTag(), true);
  }


  /**
	 * Setters for Answer fields
   */


  public function url ($config, $faker)
  {
    $record = $this->loadRecord($config->item_id);

    $this->url = $record['url'];
    $this->name = $record['name'];
    $this->description = $record['description'];
    $this->description__intro = $record['description__intro'];

    $this->slug = strtolower( $this->hyphenate( Text::_( $record['name'] )));
  }


  public function slug ($config, $faker)
  {
    return;
  }


  public function name ($config, $faker)
  {
    return;
  }


  public function description ($config, $faker)
  {
    return;
  }


  public function description__intro ($config, $faker)
  {
    return;
  }


  /**
   * Return metadata for an image file saved on disk in the media/images/user_uploads directory
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
        'description__intro' => 'full-time', 'name' => 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_FULL_TIME', 'description' => 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_FULL_TIME_DESCRIPTION', 'url' => 'https://en.wikipedia.org/wiki/Full-time'
      ),
      array(
        'description__intro' => 'part-time', 'name' => 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_PART_TIME', 'description' => 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_PART_TIME_DESCRIPTION', 'url' => 'https://en.wikipedia.org/wiki/Part-time_contract'
      ),
      array(
        'description__intro' => 'flex-time', 'name' => 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_FLEX-TIME', 'description' => 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_FLEX-TIME_DESCRIPTION', 'url' => 'https://en.wikipedia.org/wiki/Flextime'
      ),
      array(
        'description__intro' => 'contract', 'name' => 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_CONTRACT', 'description' => 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_CONTRACT_DESCRIPTION', 'url' => 'https://en.wikipedia.org/wiki/Fixed-term_employment_contract'
      ),
      array(
        'description__intro' => 'temporary', 'name' => 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_TEMPORARY', 'description' => 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_TEMPORARY_DESCRIPTION', 'url' => 'https://en.wikipedia.org/wiki/Temporary_work'
      ),
      array(
        'description__intro' => 'casual', 'name' => 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_CASUAL', 'description' => 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_CASUAL_DESCRIPTION', 'url' => 'https://en.wikipedia.org/wiki/Casual_employment_(contract)'
      ),
      array(
        'description__intro' => 'internship', 'name' => 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_INTERNSHIP', 'description' => 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_INTERNSHIP_DESCRIPTION', 'url' => 'https://en.wikipedia.org/wiki/Internship'
      ),
      array(
        'description__intro' => 'other', 'name' => 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_OTHER', 'description' => 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_OTHER_DESCRIPTION', 'url' => 'https://en.wiktionary.org/wiki/other'
      )
    );

    return $records[$recordId - 1];
  }
}
