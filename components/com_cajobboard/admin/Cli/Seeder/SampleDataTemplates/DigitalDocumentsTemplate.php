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

class DigitalDocumentsTemplate extends CommonTemplate
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


 /**
  * Loads all values at once with real values (from image file)
  */
  protected function setTemplateProperties ($config, $faker)
  {
    $record = $this->loadRecord($config->item_id);

    $this->content_url = $record['content_url'];

    $this->content_size = $record['content_size'];

    $this->encoding_format = 'application/pdf';
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
        'content_url' => '67323b81f4ae191d2b82f84a2e0dd08d.pdf',  'content_size' => '99392'
      ),
      array(
        'content_url' => '3f1be4b16c403875a5bff619934e2261.pdf',  'content_size' => '6249712'
      ),
      array(
        'content_url' => '6694b6d395f5080009ac4c4a28a2cbe1.pdf',  'content_size' => '149016'
      ),
      array(
        'content_url' => 'dc775461ef11f6df82faad7e9827eeb7.pdf',  'content_size' => '1653527'
      )
    );

    return $records[$recordId - 1];
  }
}
