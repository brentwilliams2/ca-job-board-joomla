<?php
/**
 * Admin Virus Scanner Helper
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
defined( '_JEXEC' ) or die;

class VirusScanner
{
  /*
   * Rewrite the image through Image Magick to prevent embedded script in the image file
   */
	public function reprocessImage()
	{
    try
    {
      $image = new Imagick($_FILES['my_files']['tmp_name']);

      // @TODO: How is EXIF data handled in the rewritten file?
      $image->writeImage($outFile);
    }
    catch (ImagickException)
    {
      //invalid image or something
    }
  }


  /*
   * Get the IPTC and EXIF headers for an image file
   *
   * EXIF contains the settings used to capture any given photograph. Includes ISO film speed,
   * aperture, shutter speed, orientation (landscape/portrait), mode (auto/manual), and GPS coordinates.
   * IPTC is user-entered metadata about the image.
   *
   * @param array $imageinfo  Out variable from getimagesize()
   */
	public function readMediaHeaders($imageinfo)
	{
    $iptcHeaderArray = array
    (
        '2#005'=>'DocumentTitle',
        '2#010'=>'Urgency',
        '2#015'=>'Category',
        '2#020'=>'Subcategories',
        '2#040'=>'SpecialInstructions',
        '2#055'=>'CreationDate',
        '2#080'=>'AuthorByline',
        '2#085'=>'AuthorTitle',
        '2#090'=>'City',
        '2#095'=>'State',
        '2#101'=>'Country',
        '2#103'=>'OTR',
        '2#105'=>'Headline',
        '2#110'=>'Source',
        '2#115'=>'PhotoSource',
        '2#116'=>'Copyright',
        '2#120'=>'Caption',
        '2#122'=>'CaptionWriter'
    );

    // IPTC tags
    if ( isset($imageinfo["APP13"]) )
    {
      $iptc = iptcparse( $imageinfo["APP13"] );

      if ($iptc)
      {
        // Get the image Caption
        $IPTC_Caption = str_replace( "\000", "", $iptc["2#120"][0] );

        // if IPTC tag CodedCharacterSet (marker "1#090") is set to "ESC % G", then Caption is UTF-8 encoded
        // @TODO: Are we handling and saving data in Joomla in UTF-8?
        if(isset($iptc["1#090"]) && $iptc["1#090"][0] == "\x1B%G")
        {
          $IPTC_Caption = utf8_decode($IPTC_Caption);
        }

        // @TODO: this prints out each key, could rebuild array using $iptcHeaderArray w/ human readable keys
        foreach (array_keys($iptc) as $s)
        {
          $c = count ($iptc[$s]);

          for ($i=0; $i <$c; $i++)
          {
              echo $s.' = '.$iptc[$s][$i].'<br>';
          }
        }
      }
    }

    // EXIF, XMP, and ExtendedXMP tags
    if ( isset($imageinfo["APP1"]) )
    {

    }
  }


  /*
   * Get the IPTC and EXIF headers for an image file
   *
   * @param array $imageinfo  Out variable from getimagesize()
   */
	public function getImageType($imageinfo)
	{
    $typeNames = array(
        0=>'UNKNOWN',
        1=>'GIF',
        2=>'JPEG',
        3=>'PNG',
        4=>'SWF',
        5=>'PSD',
        6=>'BMP',
        7=>'TIFF_II',
        8=>'TIFF_MM',
        9=>'JPC',
        10=>'JP2',
        11=>'JPX',
        12=>'JB2',
        13=>'SWC',
        14=>'IFF',
        15=>'WBMP',
        16=>'XBM',
        17=>'ICO',
        18=>'COUNT'
    );

    $type = $imageinfo[2];

    // or better:

    $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension

    $type = echo finfo_file($finfo, $filename); // e.g. text/html, image/gif, application/vnd.ms-excel, etc.

    finfo_close($finfo);
  }

  public function checkVideoObject($file)
  {
    /*
    Youtube accepts:


    .mpeg4
    .mp4
    .avi
    .wmv    // Windows Movie
    .mov    // Quicktime: vulnerable to embedded hyperlinks, executing arbitrary code
    .MPEGPS
    .flv
    Ogg Theora
    3GPP
    WebM
    DNxHR
    ProRes
    CineForm
    HEVC (h265)

    */
  }


  public function checkAudioObject($file)
  {
    /*
      mp3 - most popular format for podcasts and music. High compression, not that good for voice storage. Has metadata with id3 tags.
      ogg - container format supporting a variety of codecs, the most popular of which is the audio codec Vorbis.
      wma - Windows Audio Media, supports DRM.

      Not used for podcasting, due to file size:
      flac - a lossless compression codec.
      wav - standard audio file container format used mainly in Windows PCs. Commonly used for storing uncompressed, raw sound (PCM).

      alac - Apple's lossless format, used in iTunes and iOS.
      aiff - the standard lossy audio file format used by Apple.
    */
  }


  public function checkDigitalDocument($file)
  {
    /*
      Two avenues of attack: PDFs can embed Javascript, and also embed files (ActionScript/Flash)
      Convert to PDF/A, which forbids encryption - Javascript - and embedded files

      To create a PDF/A from a PDF, you need to:

        add XMP metadata,
        embed all fonts that were previously not embedded (usually you can't do this from the command line because you'll need to provide a path to a font file in case a font program isn't found),
        add a color profile,
        remove all encryption,
        remove JavaScript.

      "Ghostscript can convert a PDF to PDF/A (more accurately, it can take a PDF file as input
      and produce a visually equivalent PDF/A output file), and it can be done from the command
      line. However, the command line supplied is insufficient to do this, there are additional
      parameters/PostScript code required"

      // embedded JS can be used for PDFs which contain forms that can be filled in by the reader where one could choose from options, for example.

      pdfid checker gives output like this:

      PDF Header:% PDF-1.6
        obj 4175
        endobj 4174
        stream 3379
        endstream 3379
        xref 0
        trailer 0
        startxref 1

        / Page 794          Number of pages in document
        / Encrypt 0         Document has DRM or needs a password to be read
        / ObjStm 6          Number of object streams (stream objects that can contain other objects and can therefore obfuscate)
        / JS 3              Document contains JavaScript
        / JavaScript 0      Document contains JavaScript
        / AA 6              Automatic action to be performed when the page/document is viewed
        / OpenAction 0      Automatic action to be performed when the page/document is viewed
        / AcroForm 1
        / JBIG2Decode 0     Document uses JBIG2 compression
        / RichMedia 0       Embedded Flash
        / Launch 0          Counts launch actions
        / EmbeddedFile 0
        / XFA 0             XML Forms Architecture
        / Colors> 2 ^ 24 0
    */
  }

  // @TODO: Make sure Content-Disposition is handled ('inline', 'attachment', or with the "Save as" dialog box prefilled: 'attachment; filename="filename.jpg"')

  // @TODO: Make sure we have a  Content-Security-Policy header set

  public function setNoSniffHeader($file)
  {
    // IE and Firefox do MIME sniffing, using contextual clues (the HTML element that triggered the fetch)
    // or also inspects the initial bytes of media type loads to determine the correct content type. This
    // header prevents that behavior. Maybe move this earlier, to the dispatcher.

    // X-Content-Type-Options: nosniff
  }
}

// USAGE:

# apt-get update
# apt-get install clamav clamav-daemon -y
# systemctl stop clamav-freshclam

# manually update the virus database
# freshclam

# update the signature database in the background
# systemctl start clamav-freshclam

# Give up CPU time to higher priority tasks
# nice -n 15 clamscan && clamscan -ir /

# Limit CPU time
# cpulimit -z -e clamscan -l 50 & clamscan -ir /

$clamav = new Clamav(array('clamd_sock' => '/path/to/clamd.sock'));

if($clamav->scan("/path/to/file/to/scan.txt"))
{
  echo "YAY, file is safe\n";
}
else
{
  echo "BOO, file is a virus.  Message: " . $clamav->getMessage() . "\n";
}

class Clamav
{
  private $clamd_sock = "/var/run/clamav/clamd.sock";

  private $clamd_sock_len = 20000;

  private $clamd_ip = null;

  private $clamd_port = 3310;

  private $message = "";

  // Pass in an array of options to change the default settings.  You probably will only ever need to change the socket
  public function __construct($opts = array())
  {
    if(isset($opts['clamd_sock']))
    {
      $this->clamd_sock = $opts['clamd_sock'];
    }

    if(isset($opts['clamd_sock_len']))
    {
      $this->clamd_sock_len = $opts['clamd_sock_len'];
    }

    if(isset($opts['clamd_ip']))
    {
      $this->clamd_ip = $opts['clamd_ip'];
    }

    if(isset($opts['clamd_port']))
    {
      $this->clamd_port = $opts['clamd_port'];
    }
  }


  // Private function to open a socket to clamd based on the current options
  private function socket()
  {
    if(!empty($this->clamd_ip) && !empty($this->clamd_port))
    {
      // Attempt to use a network based socket
      $socket = socket_create(AF_INET, SOCK_STREAM, 0);

      if(socket_connect($socket, $this->clamd_ip, $this->clamd_port))
      {
        return $socket;
      }
    }
    else
    {
      // By default we just use the local socket
      $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);

      if(socket_connect($socket, $this->clamd_sock))
      {
        return $socket;
      }
    }

    return false;
  }


  // Get the last scan message
  public function getMessage()
  {
    return $this->message;
  }


  // Function to ping Clamd to make sure its functioning
  public function ping()
  {
    $ping = $this->send("PING");

    if($ping == "PONG")
    {
      return true;
    }
    return false;
  }


  // Function to scan the passed in file.  Returns true if safe, false otherwise.
  public function scan($file)
  {
    if(file_exists($file))
    {
      $scan = $this->send("SCAN $file");

      $scan = substr(strrchr($scan, ":"), 1);

      if($scan !== false)
      {
        $this->message = trim($scan);

        if($this->message == "OK")
        {
          return true;
        }
      }
      else
      {
        // return value from clamd: 1 is virus found, 2 is error
        $this->message = "Scan failed";
      }
    }
    else
    {
      $this->message = "File not found";
    }
    return false;
  }


  // Function to send a command to the Clamd socket.  In case you need to send any other commands directly.
  public function send($command)
  {
    if(!empty($command))
    {
      $socket = $this->socket();

      if($socket)
      {
        socket_send($socket, $command, strlen($command), 0);

        socket_recv($socket, $return, $this->clamd_sock_len, 0);

        socket_close($socket);

        return trim($return);
      }
    }
    return false;
  }
}


// Use Ghostscript to rewrite PDF files

// Check if ghostscript executable exists

// Import classes
use GravityMedia\Ghostscript\Ghostscript;

use Symfony\Component\Process\Process;

// Define input and output files
$inputFile = '/path/to/input/file.pdf';
$outputFile = '/path/to/output/file.pdf';

// Create Ghostscript object
$ghostscript = new Ghostscript([
  'quiet' => false
]);

// Create and configure the device
$device = $ghostscript->createPdfDevice($outputFile);

$device->setCompatibilityLevel(1.4);

// Create process
$process = $device->createProcess($inputFile);

// Print the command line
print '$ ' . $process->getCommandLine() . PHP_EOL;

// Run process
$process->run(function ($type, $buffer)
{
  if ($type === Process::ERR) {
    throw new \RuntimeException($buffer);
  }

  print $buffer;
});
