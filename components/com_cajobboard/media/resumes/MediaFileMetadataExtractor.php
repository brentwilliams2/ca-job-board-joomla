<?php

/**
 * Scratch utilities to extract metadata from videoObject files and print out as array for sample data seeders
 * 
 * Get hashed filename with md5sum *
 */

$videoObjectFiles = array(
  'ccf15af9de4bdf47213744dbbc44cbf8.pdf',
  '40b0c12d6666c71e3ff133296b27a304.pdf',
  'a230d31691ea0b6afa90dea544a82e69.pdf',
  '857efe3a1350ad6efa8d25365747b7ea.pdf',
  '854158c179184c6c4431440891f9084e.pdf'
);

/*
download library of getID3 using below link (also added to lib_cajobboard as composer require):

https://github.com/JamesHeinrich/getID3/archive/master.zip
*/

//include("getID3-master/getid3/getid3.php");

//include 'pdfparser-0.14.0/vendor/autoload.php';

foreach ($videoObjectFiles as $videoObjectFilename)
{
  // VIDEO OBJECTS:
  /*
  $getID3 = new getID3;

  $file = $getID3->analyze($videoObjectFilename);
  echo "array(\n";
  echo "  'content_url' => '" . $file['filename'] . "',";
  echo "  'content_size' => '" . $file['filesize'] . "',";
  echo "  'encoding_format' => '" . $file['mime_type'] . "',";
  echo "  'width' => '" . $file['video']['resolution_x'] . "',";
  echo "  'height' => '" . $file['video']['resolution_y'] . "',";
  echo "  'duration' => '" . gmdate("H:i:s", $file['playtime_seconds']) . "',";
  echo "  'bitrate' => '" . $file['video']['frame_rate'] . "',";
  echo "  'video_frame_size' => ''";
  echo ")\n";
  */
  // DIGITAL DOCUMENTS:


  echo "array(\n";
  echo "  'content_url' => '" . $videoObjectFilename . "',";
  echo "  'content_size' => '" . filesize($videoObjectFilename) . "',";
  echo ")\n";


  // AUDIO OBJECTS:

  /*
  $getID3 = new getID3;

  $file = $getID3->analyze($videoObjectFilename);

  echo "array(\n";
  echo "  'content_url' => '" . $videoObjectFilename . "',";
  echo "  'content_size' => '" . $file['filesize'] . "',";
  echo "  'encoding_format' => '" . $file['fileformat'] . "',";
  echo "  'duration' => '" . gmdate("H:i:s", $file['playtime_seconds']) . "',";
  echo "  'bitrate' => '" . $file['bitrate'] . "',";
  echo ")\n";
  */

  // IMAGE OBJECTS:

  /*
  list($width, $height, $type, $attr) = getimagesize ('original/' . $imageFilename);

  switch ($type) {
    case IMAGETYPE_GIF:
      $type = 'image/gif';
      break;
    case IMAGETYPE_JPEG:
      $type = 'image/jpeg';
      break;
    case IMAGETYPE_PNG:
      $type = 'image/png';
      break;
  }

  $size = filesize('original/' . $imageFilename);

  echo "array(\n";
  echo "  'content_url' => '" . $imageFilename . "',";
  echo "  'content_size' => '" . $size . "',";
  echo "  'width' => '" . $width . "',";
  echo "  'height' => '" . $height . "',";
  echo "  'encoding_format' => '" . $type . "',";
  echo "  'category' => '" . $category . "',";
  echo ")\n";
  */
/*
  $size = getimagesize('original/' . $imageFilename, $info);

  if (isset($info["APP13"]))
  {
    $iptc = iptcparse($info["APP13"]);

    echo $imageFilename . "\n";
    var_dump($iptc);
  }
*/
}
