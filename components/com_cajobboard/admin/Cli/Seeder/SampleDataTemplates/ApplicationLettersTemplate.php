<?php
/**
 * POPO Object Template for Digital Documents model sample data seeding
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

// no direct access
defined('_JEXEC') or die;

class ApplicationLettersTemplate extends CommonTemplate
{
  use \Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates\Mixins\Image;

	/**
	 * System filename of the document file referred to by the record. MD5 hash of original document file
	 *
	 * @property    string
   */
  public $content_url;


	/**
	 * File size of the original document in bytes.
	 *
	 * @property    int
   */
  public $content_size;


	/**
	 * MIME format of the image, e.g. application/pdf.
	 *
	 * @property    string
   */
  public $encoding_format;


	/**
	 * MIME format of the image, e.g. application/pdf.
	 *
	 * @property    string
   */
  public $about__organization_id;


  /**
	 * Setters for Comment fields
   */


  public function content_url ($config, $faker)
  {
    $this->setTemplateProperties($config, $faker);
  }


  public function content_size ($config, $faker)
  {
    return;
  }


  public function encoding_format ($config, $faker)
  {
    return;
  }


  public function about__organization_id ($config, $faker)
  {
    return;
  }


  /**
   * over-ridden from CommonTemplate
   */
  public function cat_id ($config, $faker)
  {
    return;
  }

 /**
  * Loads all values at once with real values (from image file)
  */
  protected function setTemplateProperties ($config, $faker)
  {
    $record = $this->loadRecord($config->item_id);

    $this->content_url = $record['content_url'];

    $this->content_size = $record['content_size'];

    $this->encoding_format = 'application/pdf';

    // $this->belongsTo('About', 'Organizations@com_cajobboard', 'about__organization_id', 'organization_id');
    $this->about__organization_id = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'Organizations');
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
        'content_url' => '55a25e85ab0d44a25566c96f200665ca.pdf',  'content_size' => '25709'
      ),
      array(
        'content_url' => '1d0ee1558573daba6cf0cb7c97c2e611.pdf',  'content_size' => '26125'
      ),
      array(
        'content_url' => '36853f66d31f616be8d4e9e8d61d19c5.pdf',  'content_size' => '23747'
      ),
      array(
        'content_url' => 'd5c594631a0a5c1b78f7e70c6f804acc.pdf',  'content_size' => '32283'
      )
    );

    return $records[$recordId - 1];
  }
}
