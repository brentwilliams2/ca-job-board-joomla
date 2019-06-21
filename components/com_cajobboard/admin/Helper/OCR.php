<?php
/**
 * Optical Character Recognition Helper using Tesseract OCR
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Helper;

// no direct access
defined('_JEXEC') or die;

use \FOF30\Container\Container;
use \thiagoalessio\TesseractOCR\TesseractOCR;

/*
  Intended use of this helper is to convert PDF or image formatted text documents to PHP string format

  This is for converting Resumes, Recommendation letters, Reference letters, Applications, and Application Letters

  @TODO: Need to make sure Tesseract OCR is installed on the host:
          sudo apt install tesseract-ocr

  https://github.com/thiagoalessio/tesseract-ocr-for-php
*/

/**
 *
 */
abstract class OCR
{
  public static function getText($image)
  {
    return (new TesseractOCR('text.png'))->run();
  }


  public static function convertPdfToJpeg($pdf)
  {
    // one approach using ImageMagick, ImageMagick uses GhostScript to process JPEGs
    // so could also exec GhostScript directly
    if ( extension_loaded('imagick') )
    {
      $fp_pdf = fopen($pdf, 'rb');

      $params=array();

      $img = new imagick();

      $img->readImageFile($fp_pdf);

      $img->setImageUnits(imagick::RESOLUTION_PIXELSPERINCH);

      $params=$img->identifyImage();

      $img->setImageFormat( "jpg" );

      $img->setImageCompression(imagick::COMPRESSION_JPEG);

      $img->setImageCompressionQuality(90);

      $img->setPage($params['geometry']['width'], $params['geometry']['height'], 0, 0)

      $img->setResolution($params['resolution']['x'], $params['resolution']['y']);

      $img->setImageUnits(imagick::RESOLUTION_PIXELSPERINCH);

      $data = $img->getImageBlob();
    }
  }
}
