<?php
/**
 * POPO Object Template for Data Feed Templates model sample data seeding
 *
 * Uses returns in template properties so that all
 * properties can be loaded at once from real values
 *
 * @package   Calligraphic Job Board
 * @version   29 October, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates;

use Faker;
use \Joomla\CMS\User\UserHelper;

// no direct access
defined('_JEXEC') or die;

class DataFeedTemplatesTemplate extends CommonTemplate
{
	/**
	 * System filename of the document file referred to by the record. MD5 hash of original document file
	 *
	 * @property    string
   */
  public $xml_template;


  /**
	 * Setters for Comment fields
   */


  public function xml_template ($config, $faker)
  {
    $this->setTemplateProperties($config, $faker);
  }


  /**
   * over-ridden from CommonTemplate
   */
  public function name ($config, $faker)
  {
    return;
  }


  /**
   * over-ridden from CommonTemplate
   */
  public function slug ($config, $faker)
  {
    return;
  }


  /**
   * over-ridden from CommonTemplate
   */
  public function description ($config, $faker)
  {
    return;
  }


  public function created_by ($config, $faker)
  {
    $this->created_by = UserHelper::getUserId('admin');
  }


 /**
  * Loads all values at once with real values (from image file)
  */
  protected function setTemplateProperties ($config, $faker)
  {
    $record = $this->loadRecord($config->item_id);

    $this->name = $record['name'];
    $this->slug = $record['slug'];
    $this->description = $record['description'];
    $this->xml_template = $record['xml_template'];
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
        'name' => 'Indeed.com All Posts Daily', 'slug' => 'indeed-all-daily', 'description' => 'Daily job feed for Indeed.com', 'xml_template' => '<?xml version="1.0" encoding="utf-8"?><source><publisher>[site-name]</publisher><publisherurl>[site-url]</publisherurl><lastBuildDate>[date_created]</lastBuildDate><job><title><![CDATA[title]]></title><date><![CDATA[CURRENT_TIMESTAMP]]></date><referencenumber><![CDATA[reference-id]]></referencenumber><url><![CDATA[url]]></url><company><![CDATA[company]]></company><city><![CDATA[city]]></city><state><![CDATA[state]]></state><country><![CDATA[country]]></country><postalcode><![CDATA[postal-code]]></postalcode><description><![CDATA[description]]></description><salary><![CDATA[salary]]></salary><education><![CDATA[education-level]]></education><jobtype><![CDATA[job-type]]></jobtype><category><![CDATA[keywords]]></category><experience><![CDATA[experience]]></experience></job></source>'
      )
    );

    return $records[$recordId - 1];
  }
}






