<?php
/**
 * CLI Script for processing media files - encoding, transforming, etc.
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 *  Usage, from command prompt in job board package root directory:
 *
 *   composer seed <model name>
 */

include realpath(__DIR__ . '/../CliApplication.php');

use \FOF30\Container\Container;
use \Joomla\CMS\Input\Cli;
use \Joomla\Registry\Registry;


/**
 * Calligraphic Job Board Sample Data Seeder CLI Application
 *
 * @var    \JInput                       $input
 * @var    \Joomla\Registry\Registry    $config
 */
class MediaProcessor extends CliApplication
{
	/**
	 * Class constructor
	 */
  public function __construct()
  {
    parent::__construct();
  }


  /**
	 * Main method of class
   *
   * @return void
	 */
  public function execute()
  {
    // Create the FOF Container object
    parent::execute();
  }

  // @TODO: race condition if media processor is called by a client, and the redirect tries to get the file before processing is finished
  //        maybe could be handled by setting the MediaObject to unpublished, then set MediaObject to published when this async task is completed?
  //        How to handle delaying the client's request to load the MediaObject on redirect until the async processing is finished (instead
  //        of returning an unpublished error)?

  // @TODO: this system should use this CLI script for async processing, a plugin for sync processing if this script is unavailable (e.g.
  //        due to permissions), and a helper for code shared in common between the two, like the Email system.

  /*
    Joomla! libraries:

    libraries/src/Utility/BufferStreamHandler.php

      This class provides a generic buffer stream.  It can be used to store/retrieve/manipulate string buffers with the standard PHP filesystem I/O methods.

    Joomla\CMS\Utility\Utility::getMaxUploadSize($custom)

      if the PHP settings are all above $custom then $custom will be used
  */
}


  /**
	 * Checks if PCNTL support is available for parallel async processing of tasks with spatie/async, not available in Windows environment
   *
   * @return boolean
	 */
  public function isPcntlAvailable()
  {
    // Need
    return extension_loaded('pcntl');

    /*
      The following is code to call this script. Should be added to BaseModel, the same code is
      used in the plg_cajobboard_mail though to handle calling the MailProcessor CLI script

      // handle making sure there's permission to run the script
      whoiam()

      if ( substr( php_uname(), 0, 7 ) == "Windows" )
      {
        // Windows doesn't have Pcntl
        pclose( popen("start /B ". $cmd, "r") );
      }
      else
      {
        // Run the script as a background process so that it's async, and redirect STDOUT and STDERR with double-redirect
        exec($cmd . " &> /dev/null &");
      }
    */
  }
}

// Execute this CLI application
$app = CliApplication::getInstance('MediaProcesor');
\JFactory::$application = $app;
$app->execute();
?>



<?php


// if multiple file format used, each key is an array: $_FILES["file_upload"]["name"][0], etc.

 /**
	* View helpers for job postings
	*/
  class ImageObject {
    /**
    * Handle saving an image
    *
    * @param    $image    A JImage object of the image to be saved
    *
    * @return   boolean  True on success
    */
    public function saveImage($image) {
      // Do this all on an async or cron job?
      // 1. Needs to check if image is the right size
      // 2. Needs to generate md5 hash of image and save with that filename
      // 3. Needs to generate thumbnail
      // 4. Needs to generate md5 hash of thumbnail and save with that filename
      // 5. handle slug, setting data for it in model.
      // 6. save everything in the model in correct fields


/* Image Optimization:

    1.  Name your images descriptively and in plain language.
    2.  Optimize your alt text for SEO. Title text is optional
    3.  Optimize caption text for SEO.
    4.  Constrain image dimensions. Make sure image dimensions match the image size as displayed
    5.  Choose the right file type.
    6.  Optimize your thumbnails.
    7.  Use XML image sitemaps.
    8.  Use Twitter cards
    9.  Use Facebook Open Graph. Simple as adding in <head>:
          <meta property="og:image" content="http://example.com/link-to-image.jpg" />
    10. Use responsive images with srcset
*/

      return true;
    }
  }

/*
  get md5 hash:

  $string =  md5(string $str)

  resize image with Joomla!:

      // Set the path to the file
      $file = '/Absolute/Path/To/File';

      // Instantiate our JImage object
      $image = new JImage($file);

      // Get the file's properties
      $properties = JImage::getImageFileProperties($file);

      // Declare the size of our new image
      $width = 100;
      $height = 100;

      // Resize the file as a new object
      $resizedImage = $image->resize($width, $height, true);

      // Determine the MIME of the original file to get the proper type for output
      $mime = $properties->mime;

      if ($mime == 'image/jpeg')
      {
          $type = IMAGETYPE_JPEG;
      }
      elseif ($mime = 'image/png')
      {
          $type = IMAGETYPE_PNG;
      }
      elseif ($mime = 'image/gif')
      {
          $type = IMAGETYPE_GIF;
      }

      // Store the resized image to a new file
      $resizedImage->toFile('/Absolute/Path/To/New/File', $type);

  If two operations at once:

      $image_one = new JImage($filepath);

      $image_one
          ->filter('grayscale')
          ->toFile($path_one, IMAGETYPE_JPEG, array('quality' => 60));

      $image_two = new JImage($filePath);

      $image_two
          ->filter('limitcolors', array('limit' => 160))
          ->toFile($path_two, IMAGETYPE_GIF);

  Joomla! image methods:

    createThumbs(mixed $thumbSizes, integer $creationMethod = self::SCALE_INSIDE, string $thumbsFolder = null) : array

      $thumbSizes = array('150x75','250x150');
      $creationMethod = 1-3 resize $scaleMethod | 4 create cropping
      $thumbsFolder = destination folder for thumbs

    crop(mixed $width, mixed $height, integer $left = null, integer $top = null, boolean $createNew = true) : \Joomla\Image\Image

      $createNew   boolean If true the current image will be cloned, cropped and returned; else the current image will be cropped and returned.

    cropResize(integer $width, integer $height, integer $createNew = true) : \Joomla\Image\Image

    flip(integer $mode, boolean $createNew = true) : \Joomla\Image\Image

    getImageFileProperties(string $path) : \stdClass

    getHeight() : integer

    getWidth() : integer

    getOrientation() : mixed

      returns null or string with image's orientation (landscape, portrait or square).

    isTransparent() : boolean

      whether or not the image has transparency

    resize(mixed $width, mixed $height, boolean $createNew = true, integer $scaleMethod = self::SCALE_INSIDE) : \Joomla\Image\Image

    rotate(mixed $angle, integer $background = -1, boolean $createNew = true) : \Joomla\Image\Image

    watermark(\Joomla\Image\Image $watermark, integer $transparency = 50, integer $bottomMargin, integer $rightMargin) : \Joomla\Image\Image

    toFile(mixed $path, integer $type = IMAGETYPE_JPEG, array $options = array()) : boolean

    filter(string $type, array $options = array()) : \Joomla\Image\Image

      Filter Types: Emboss, Brightness, Sketchy, Edgedetect, Backgroundfill, Grayscale

*/
