<?php
 /**
  * Image Objects (photos) Item View Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // Framework classes
  // use JUri;

  // no direct access
  defined('_JEXEC') or die;

  // collection of review postings model objects for this list view
  $items = $this->getItems();

  // model data fields
  $imageID              = $items->image_object_id;
  $created_by           = $items->created_by;        // Userid of the creator of this answer.
  $createdOn            = $items->created_on;        // Date this answer was created.
  $featured             = $items->featured;          // Whether this answer is featured or not.
  $hits                 = $items->hits;              // Number of hits this answer has received.
  $imageSlug            = $items->slug;              // Alias for SEF URL
  $thumbnailFileName    = $items->thumbnail;         // Filename of the property image thumbnail
  $imageCaption         = $items->caption;           // Caption for the property image
  $imageExifData        = $items->exif_data;         // JSON-encoded exif data for this image
  $imageFileName        = $items->content_url;       // Filename of the property image
  $imageFileSize        = $items->content_size;      // File size in bytes
  $imageHeight          = $items->height;            // Height of the property image in px
  $imageWidth           = $items->width;             // Width of the property image in px
  $imageEncodingFormat  = $items->encoding_format;   // RFC 2045 mime type for this image to disambiguate different encodings of the same image, e.g. image/jpeg, image/png, image/gif
  $imageContentLocation = $items->contentLocation;   // Place depicted or described in the image, FK to #__cajobboard_places
  $imageName            = $items->name;              // A name for this image
  $imageDescription     = $items->description;       // A long description of this image
  $imageAuthor          = $items->author;            // The author of this content or rating, FK to #__users
  $modifiedBy           = $items->modified_b;        // Userid of person that last modified this answer.
  $modifiedOn           = $items->modified_o;        // Date this answer was last modified.
?>

Image Objects (photos) Item View Template
