<?php
 /**
  * Image Objects (photos)  List Item Detail View Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */
  // no direct access
  defined('_JEXEC') or die;

  // $imageID              = $items->image_object_id;
  // $imageSlug            = $items->slug              // Alias for SEF URL
  // $thumbnailFileName    = $items->thumbnail         // Filename of the property image thumbnail
  // $imageCaption         = $items->caption           // Caption for the property image
  // $imageExifData        = $items->exif_data         // JSON-encoded exif data for this image
  // $imageFileName        = $items->content_url       // Filename of the property image
  // $imageFileSize        = $items->content_size      // File size in bytes
  // $imageHeight          = $items->height            // Height of the property image in px
  // $imageWidth           = $items->width             // Width of the property image in px
  // $imageEncodingFormat  = $items->encoding_format   // RFC 2045 mime type for this image to disambiguate different encodings of the same image, e.g. image/jpeg, image/png, image/gif
  // $imageContentLocation = $items->contentLocation   // Place depicted or described in the image, FK to #__cajobboard_places
  // $imageName            = $items->name              // A name for this image
  // $imageDescription     = $items->description       // A long description of this image
  // $imageAuthor          = $items->author            // The author of this content or rating, FK to #__users
?>

<a href="https://unsplash.it/1200/768.jpg?image=251" data-toggle="lightbox" data-gallery="example-gallery" class="col-sm-4">
  <img
    class ="img-fluid"
    {{-- srcset uses w unit instead of px, this is actual width in pixels of image. Can use Nx syntax also for relative scaling  --}}
    srcset="media://com_cajobboard/images/places/thumbs/10003e84a62ba007664ca4ec4ffdb930.4x.jpg 4x,
            media://com_cajobboard/images/places/thumbs/10003e84a62ba007664ca4ec4ffdb930.3x.jpg 3x,
            media://com_cajobboard/images/places/thumbs/10003e84a62ba007664ca4ec4ffdb930.2x.jpg 2x,
            media://com_cajobboard/images/places/thumbs/10003e84a62ba007664ca4ec4ffdb930.1-5x.jpg 1.5x,
            media://com_cajobboard/images/places/thumbs/10003e84a62ba007664ca4ec4ffdb930.1x.jpg 1x"
    {{-- sizes are media conditions to break at for different display sizes. Also min-width,  --}}
    sizes ="(max-width: 320px) 280px,
            (max-width: 480px) 440px,
            800px"
    src   ="https://unsplash.it/600.jpg?image=251"
    alt   ="Elva dressed as a fairy"
  >
</a>


