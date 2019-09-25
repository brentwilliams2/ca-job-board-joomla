<?php
/**
 * POPO Object Template for Image Objects model sample data seeding
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

class ImageObjectsTemplate extends CommonTemplate
{
  use \Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates\Mixins\Image;

	/**
	 * Caption for the image.
	 *
	 * @property    string
   */
  public $caption;


	/**
	 * System filename of the image file referred to by the record. MD5 hash of original image file, same filename is used in all size folders e.g. thumb, large, etc.
	 *
	 * @property    string
   */
  public $content_url;


	/**
	 * File size of the original image in bytes.
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
	 * MIME format of the image, e.g. image/gif, image/jpeg, image/png, image/svg+xml, or image/webp.
	 *
	 * @property    string
   */
  public $encoding_format;


	/**
	 * Place depicted or described in the image, FK to #__cajobboard_places.
	 *
	 * @property    int
   */
  public $content_location;


	/**
	 * The aspect ratio of the image, defined by ImageObjectAspectRatioEnum helper
	 *
	 * @property    int
   */
  public $aspect_ratio;


	/**
	 * JSON-encoded EXIF data for this image.
	 *
	 * @property    string
   */
  public $exif_data;



  /**
	 * Setters for Comment fields
   */


  public function caption ($config, $faker)
  {
    $this->setTemplateProperties($config, $faker);
  }


  public function content_url ($config, $faker)
  {
    return;
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


  public function content_location ($config, $faker)
  {
    return;
  }


  public function aspect_ratio ($config, $faker)
  {
    return;
  }


  public function exif_data ($config, $faker)
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

    $this->caption = $faker->sentence();

    $this->content_url = $record['content_url'];

    $this->content_size = $record['content_size'];

    $this->height = $record['height'];

    $this->width = $record['width'];

    $this->encoding_format = $record['encoding_format'];

    // $this->belongsTo('ContentLocation', 'Places@com_cajobboard', 'content_location', 'place_id');
    $this->content_location = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'Places');

    $this->aspect_ratio = $record['aspect_ratio'];

    $this->cat_id = $this->getCategoryId($record['category']);

    $this->exif_data = $this->getExifString($record);
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
        'content_url' => '9ce203d4cf9b44218b864f51e82c8ed4.jpg',  'content_size' => '10646',    'width' => '232',     'height' => '136',    'aspect_ratio' => 'STANDARD_LANDSCAPE',   'encoding_format' => 'image/jpeg',  'category' => 'organizations'
      ),
      array(
        'content_url' => '458b8334edf54c056392276cbf18ae4e.jpg',  'content_size' => '11966',    'width' => '234',     'height' => '134',    'aspect_ratio' => 'STANDARD_LANDSCAPE',   'encoding_format' => 'image/jpeg',  'category' => 'organizations'
      ),
      array(
        'content_url' => '48ceeada3a22ff130bb42b8bddf673f0.png',  'content_size' => '6394',     'width' => '256',     'height' => '256',    'aspect_ratio' => 'SQUARE',   'encoding_format' => 'image/png',   'category' => 'persons'
      ),
      array(
        'content_url' => '03079f1f0a7d5740404768bb5c051f75.jpg',  'content_size' => '48088',    'width' => '900',     'height' => '900',    'aspect_ratio' => 'SQUARE',   'encoding_format' => 'image/jpeg',  'category' => 'persons'
      ),
      array(
        'content_url' => '7295dba823ca6605f115a385517f8073.png',  'content_size' => '14682',    'width' => '400',     'height' => '400',    'aspect_ratio' => 'SQUARE',   'encoding_format' => 'image/png',   'category' => 'persons'
      ),
      array(
        'content_url' => '88545549392290bb7d136dbbbd13ec04.png',  'content_size' => '84472',    'width' => '400',     'height' => '400',    'aspect_ratio' => 'SQUARE',   'encoding_format' => 'image/png',   'category' => 'persons'
      ),
      array(
        'content_url' => 'd3cce8929e3a0525b453360a0d79f46c.gif',  'content_size' => '203938',   'width' => '500',     'height' => '500',    'aspect_ratio' => 'SQUARE',   'encoding_format' => 'image/gif',   'category' => 'persons'
      ),
      array(
        'content_url' => '43ed35cc279fa7604786bf6e3fef15f0.jpg',  'content_size' => '735372',   'width' => '2880',    'height' => '1600',   'aspect_ratio' => 'STANDARD_LANDSCAPE',   'encoding_format' => 'image/jpeg',  'category' => 'places'
      ),
      array(
        'content_url' => 'b2c2ab315002135c84b44ebe013a02c2.jpg',  'content_size' => '43855',    'width' => '550',     'height' => '412',    'aspect_ratio' => 'CAMERA_LANDSCAPE',   'encoding_format' => 'image/jpeg',  'category' => 'places'
      ),
      array(
        'content_url' => '2a437ddb71cdf1ea22f174ba456300db.jpg',  'content_size' => '730487',   'width' => '2880',    'height' => '1600',   'aspect_ratio' => 'STANDARD_LANDSCAPE',   'encoding_format' => 'image/jpeg',  'category' => 'places'
      ),
      array(
        'content_url' => 'c224252f7d79ab6b336d56d454db5368.jpg',  'content_size' => '290826',   'width' => '1000',    'height' => '665',    'aspect_ratio' => 'CAMERA_LANDSCAPE',   'encoding_format' => 'image/jpeg',  'category' => 'places'
      ),
      array(
        'content_url' => '4f57f3db2a08704af26214afa59c7586.jpg',  'content_size' => '536542',   'width' => '1798',    'height' => '1200',   'aspect_ratio' => 'CAMERA_LANDSCAPE',   'encoding_format' => 'image/jpeg',  'category' => 'places'
      ),
      array(
        'content_url' => 'b285824627c58872081271da2c4f3db3.jpg',  'content_size' => '739689',   'width' => '2880',    'height' => '1600',   'aspect_ratio' => 'CAMERA_LANDSCAPE',   'encoding_format' => 'image/jpeg',  'category' => 'places'
      ),
      array(
        'content_url' => '86b849756ba03e794f8cc7fec66edd69.jpg',  'content_size' => '322319',   'width' => '1300',    'height' => '865',    'aspect_ratio' => 'CAMERA_LANDSCAPE',   'encoding_format' => 'image/jpeg',  'category' => 'places'
      )
    );

    return $records[$recordId - 1];
  }


  public function getExifString ($record)
  {
   return '{
      "image": {
        "name": "' . $record['content_url'] . '",
        "format": "' . str_replace($record['encoding_format'], 'image/', '') . '",
        "formatDescription": "Joint Photographic Experts Group JFIF format",
        "mimeType": "' . $record['encoding_format'] . '",
        "class": "DirectClass",
        "geometry": {
          "width": ' . $record['width'] . ',
          "height": ' . $record['height'] . ',
          "x": 0,
          "y": 0
        },
        "resolution": {
          "x": "300",
          "y": "300"
        },
        "units": "PixelsPerInch",
        "type": "TrueColor",
        "endianess": "Undefined",
        "colorspace": "sRGB",
        "depth": 8,
        "baseDepth": 8,
        "channelDepth": {
          "red": 8,
          "green": 8,
          "blue": 8
        },
        "pixels": ' . $record['width'] * $record['height'] . ',
        "imageStatistics": {
          "all": {
            "min": "0",
            "max": "255",
            "mean": "120.794",
            "standardDeviation": "48.999",
            "kurtosis": "2.04928",
            "skewness": "0.518196"
          }
        },
        "channelStatistics": {
          "red": {
            "min": "10",
            "max": "255",
            "mean": "152.362",
            "standardDeviation": "49.3103",
            "kurtosis": "-0.459491",
            "skewness": "0.267462"
          },
          "green": {
            "min": "0",
            "max": "255",
            "mean": "132.752",
            "standardDeviation": "49.7499",
            "kurtosis": "-0.338396",
            "skewness": "0.29157"
          },
          "blue": {
            "min": "0",
            "max": "255",
            "mean": "77.2686",
            "standardDeviation": "47.918",
            "kurtosis": "2.32993",
            "skewness": "1.31755"
          }
        },
        "renderingIntent": "Perceptual",
        "gamma": 0.454545,
        "chromaticity": {
          "redPrimary": {
            "x": 0.64,
            "y": 0.33
          },
          "greenPrimary": {
            "x": 0.3,
            "y": 0.6
          },
          "bluePrimary": {
            "x": 0.15,
            "y": 0.06
          },
          "whitePrimary": {
            "x": 0.3127,
            "y": 0.329
          }
        },
        "backgroundColor": "#FFFFFF",
        "borderColor": "#DFDFDF",
        "matteColor": "#BDBDBD",
        "transparentColor": "#000000",
        "interlace": "None",
        "intensity": "Undefined",
        "compose": "Over",
        "pageGeometry": {
          "width": ' . $record['width'] . ',
          "height": ' . $record['height'] . ',
          "x": 0,
          "y": 0
        },
        "dispose": "Undefined",
        "iterations": 0,
        "compression": "JPEG",
        "quality": 75,
        "orientation": "TopLeft",
        "properties": {
          "date:create": "2019-01-12T02:51:28+00:00",
          "date:modify": "2019-01-12T02:51:28+00:00",
          "exif:ColorSpace": "1",
          "exif:ComponentsConfiguration": "1, 2, 3, 0",
          "exif:Contrast": "0",
          "exif:CustomRendered": "0",
          "exif:DateTime": "2008:11:01 21:15:07",
          "exif:DateTimeDigitized": "2008:10:22 16:28:39",
          "exif:DateTimeOriginal": "2008:10:22 16:28:39",
          "exif:DigitalZoomRatio": "0/100",
          "exif:ExifImageLength": "' . $record['width'] . '",
          "exif:ExifImageWidth": "' . $record['height'] . '",
          "exif:ExifOffset": "268",
          "exif:ExifVersion": "48, 50, 50, 48",
          "exif:ExposureBiasValue": "0/10",
          "exif:ExposureMode": "0",
          "exif:ExposureProgram": "2",
          "exif:ExposureTime": "4/300",
          "exif:FileSource": "3",
          "exif:Flash": "16",
          "exif:FlashPixVersion": "48, 49, 48, 48",
          "exif:FNumber": "59/10",
          "exif:FocalLength": "24/1",
          "exif:FocalLengthIn35mmFilm": "112",
          "exif:GainControl": "0",
          "exif:GPSAltitudeRef": "0",
          "exif:GPSDateStamp": "2008:10:23",
          "exif:GPSImgDirectionRef": null,
          "exif:GPSInfo": "926",
          "exif:GPSLatitude": "43/1, 28/1, 281400000/100000000",
          "exif:GPSLatitudeRef": "N",
          "exif:GPSLongitude": "11/1, 53/1, 645599999/100000000",
          "exif:GPSLongitudeRef": "E",
          "exif:GPSMapDatum": "WGS-84   ",
          "exif:GPSSatellites": "06",
          "exif:GPSTimeStamp": "14/1, 27/1, 724/100",
          "exif:ImageDescription": "                               ",
          "exif:InteroperabilityOffset": "896",
          "exif:ISOSpeedRatings": "64",
          "exif:LightSource": "0",
          "exif:Make": "NIKON",
          "exif:MakerNote": "78, 105, 107, 111, 110, 0, ..., 0, 0, 0, ",
          "exif:MaxApertureValue": "29/10",
          "exif:MeteringMode": "5",
          "exif:Model": "COOLPIX P6000",
          "exif:Orientation": "1",
          "exif:ResolutionUnit": "2",
          "exif:Saturation": "0",
          "exif:SceneCaptureType": "0",
          "exif:SceneType": "1",
          "exif:Sharpness": "0",
          "exif:Software": "Nikon Transfer 1.1 W",
          "exif:SubjectDistanceRange": "0",
          "exif:thumbnail:Compression": "6",
          "exif:thumbnail:InteroperabilityIndex": "R98",
          "exif:thumbnail:InteroperabilityVersion": "48, 49, 48, 48",
          "exif:thumbnail:JPEGInterchangeFormat": "4548",
          "exif:thumbnail:JPEGInterchangeFormatLength": "6702",
          "exif:thumbnail:ResolutionUnit": "2",
          "exif:thumbnail:XResolution": "72/1",
          "exif:thumbnail:YResolution": "72/1",
          "exif:UserComment": "65, 83, 67, 73, 73, 0, ...., 32, 32, 32, 0",
          "exif:WhiteBalance": "0",
          "exif:XResolution": "300/1",
          "exif:YCbCrPositioning": "1",
          "exif:YResolution": "300/1",
          "jpeg:colorspace": "2",
          "jpeg:sampling-factor": "2x1,1x1,1x1",
          "MicrosoftPhoto:Rating": "0",
          "signature": "55cbf121d52110cda7c785d97bf02f6a31bd0f5ac44c06f9b2f70c9c7d00ade4"
        },
        "profiles": {
          "exif": {
            "length": "11256"
          },
          "xmp": {
            "length": "4000"
          }
        },
        "artifacts": {
          "filename": "' . $record['content_url'] . '"
        },
        "tainted": false,
        "filesize": "' . $record['content_size'] . '",
        "numberPixels": "' . $record['width'] * $record['height'] . '",
        "pixelsPerSecond": "15.36MB",
        "userTime": "0.010u",
        "elapsedTime": "0:01.020",
        "version": "ImageMagick 6.9.5-9 Q16 x86_64 2016-10-21 http://www.imagemagick.org"
      }
    }';
  }
}
