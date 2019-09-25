<?php
/**
 * POPO Object Template for Audio Objects model sample data seeding
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

class AudioObjectsTemplate extends CommonTemplate
{
  use \Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates\Mixins\Image;

	/**
	 * System filename of the audio file referred to by the record. MD5 hash of original image file.
	 *
	 * @property    string
   */
  public $content_url;


	/**
	 * File size of the original audio in bytes.
	 *
	 * @property    int
   */
  public $content_size;


	/**
	 * MIME format of the audio, e.g. audio/mpeg for .mp3
	 *
	 * @property    string
   */
  public $encoding_format;


	/**
	 * The bitrate of the media object in Hz.
	 *
	 * @property    int
   */
  public $bitrate;


	/**
	 * The duration of the item (movie, audio recording, event, etc.) in ISO 8601 format, e.g. 00:00:32.
	 *
	 * @property    string
   */
  public $duration;


	/**
	 * The name of a subtitle file (.srt, HTML5 WebSRT as .vtt).
	 *
	 * @property    int
   */
  public $caption;


	/**
	 * The transcript of this audio object.
	 *
	 * @property    string
   */
  public $transcript;


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


  public function bitrate ($config, $faker)
  {
    return;
  }


  public function duration ($config, $faker)
  {
    return;
  }


  public function caption ($config, $faker)
  {
    $this->caption = implode(" ", $faker->words(3) );
  }


  public function transcript ($config, $faker)
  {
    $this->transcript = implode("\n", $faker->paragraphs($faker->numberBetween(1, 3)));
  }


  /**
   * over-ridden from CommonTemplate
   */
  public function cat_id ($config, $faker)
  {
    return;
  }

 /**
  * Loads all values at once with real values (from audio file)
  */
  protected function setTemplateProperties ($config, $faker)
  {
    $record = $this->loadRecord($config->item_id);

    //$this->caption = $faker->sentence();

    $this->content_url = $record['content_url'];

    $this->content_size = $record['content_size'];

    $this->encoding_format = $record['encoding_format'];

    $this->bitrate = $record['bitrate'];

    $this->duration = $record['duration'];

//    $this->cat_id = $this->getCategoryId($record['category']);
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
        'content_url' => '7d2b87ac833edfe73166274f7e1e968f.mp3',  'content_size' => '17466668',  'encoding_format' => 'mp3',  'duration' => '00:08:48',  'bitrate' => '256000'
      ),
      array(
        'content_url' => 'ca6bfd85e5e9ef868b0d6d6a731fbf64.mp3',  'content_size' => '37899005',  'encoding_format' => 'mp3',  'duration' => '00:19:26',  'bitrate' => '256000'
      ),
      array(
        'content_url' => '3a0dc3789c03ec02d2cb356035f06c32.mp3',  'content_size' => '22982973',  'encoding_format' => 'mp3',  'duration' => '00:31:10',  'bitrate' => '95884.325412069'
      ),
      array(
        'content_url' => '339bfbf12a79c96b0d7799e73f7329a5.mp3',  'content_size' => '16176970',  'encoding_format' => 'mp3',  'duration' => '00:22:43',  'bitrate' => '91581.137455774'
      ),
      array(
        'content_url' => 'b825dcf80e4e3e7c520ba2707c8ea29c.mp3',  'content_size' => '57321129',  'encoding_format' => 'mp3',  'duration' => '00:39:24',  'bitrate' => '192000'
      )
    );

    return $records[$recordId - 1];
  }
}
