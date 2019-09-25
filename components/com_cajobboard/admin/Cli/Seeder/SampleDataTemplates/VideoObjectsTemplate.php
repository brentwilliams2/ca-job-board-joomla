<?php
/**
 * POPO Object Template for Video Objects model sample data seeding
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

class VideoObjectsTemplate extends CommonTemplate
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
	 * Height of the original image in px.
	 *
	 * @property    int
   */
  public $height;


	/**
	 * Width of the original image in px.
	 *
	 * @property    int
   */
  public $width;


	/**
	 * MIME format of the audio, e.g. audio/mpeg for .mp3
	 *
	 * @property    string
   */
  public $encoding_format;


	/**
	 * The frame rate of the media object in frames per second (fps).
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
	 * Aspect ratio of the video file, using VideoObjectAspectRatiosEnum values.
	 *
	 * @property    string
   */
  public $video_frame_size;


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


  public function height ($config, $faker)
  {
    return;
  }


  public function width ($config, $faker)
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


  public function video_frame_size ($config, $faker)
  {
    return;
  }


  public function caption ($config, $faker)
  {
    $this->caption = implode(" ", $faker->words(3) );
  }


  public function transcript ($config, $faker)
  {
    $this->transcript = implode("\n", $faker->paragraphs($faker->numberBetween(2, 3)));
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

    $this->height = $record['height'];

    $this->width = $record['width'];

    $this->encoding_format = $record['encoding_format'];

    $this->bitrate = $record['bitrate'];

    $this->duration = $record['duration'];

    $this->video_frame_size = $record['video_frame_size'];
  }


  /**
   * Return metadata for a video file saved on disk in the media/video directory
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
        'content_url' => 'd55bddf8d62910879ed9f605522149a8.mp4',  'content_size' => '1055736',  'encoding_format' => 'video/mp4',  'width' => '1280',  'height' => '720',  'duration' => '00:00:05',  'bitrate' => '25',  'video_frame_size' => 'WIDE_LANDSCAPE'
      ),
      array(
        'content_url' => '097f31ae0978732346f54b2c687f2da3.mp4',  'content_size' => '10530208',  'encoding_format' => 'video/mp4',  'width' => '640',  'height' => '480',  'duration' => '00:01:06',  'bitrate' => '25',  'video_frame_size' => 'STANDARD_LANDSCAPE'
      ),
      array(
        'content_url' => '24592cf91289a12e834af106a3b0ded2.mp4',  'content_size' => '1057149',  'encoding_format' => 'video/mp4',  'width' => '640',  'height' => '480',  'duration' => '00:00:05',  'bitrate' => '25',  'video_frame_size' => 'STANDARD_LANDSCAPE'
      ),
      array(
        'content_url' => '9d2cd2d5b8b1571b613f107af7fbed65.mp4',  'content_size' => '2097619',  'encoding_format' => 'video/mp4',  'width' => '640',  'height' => '480',  'duration' => '00:00:15',  'bitrate' => '25',  'video_frame_size' => 'STANDARD_LANDSCAPE'
      ),
      array(
        'content_url' => '5f2a6568b070eee0629934752c36d6b7.mp4',  'content_size' => '5243244',  'encoding_format' => 'video/mp4',  'width' => '640',  'height' => '480',  'duration' => '00:00:30',  'bitrate' => '25',  'video_frame_size' => 'STANDARD_LANDSCAPE'
      )
    );

    return $records[$recordId - 1];
  }
}
