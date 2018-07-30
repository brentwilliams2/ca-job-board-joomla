/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Media schemas use type-per-hierarchy inheritance for extending schema
 * https://schema.org/MediaObject and schema https://schema.org/CreativeWork
 * to avoid multiple joins on query
 */

 /**
 * Image media table
 *
 * schema https://schema.org/ImageObject
 */
CREATE TABLE IF NOT EXISTS '#__cajobboard_media_image' (
  'image_id' BIGINT UNSIGNED NOT NULL,
  'image' VARCHAR(255) NOT NULL COMMENT 'filename of the property image',
  'thumbnail' VARCHAR(255) COMMENT 'filename of the property image thumbnail',
  'caption' CHAR(255) COMMENT 'caption for the property image',
  'exif_data' JSON COMMENT 'exif data for this image in JSON format',
  /* SCHEMA: MediaObject */
  'height' SMALLINT COMMENT 'height of the property image',
  'width' SMALLINT COMMENT 'width of the property image',
  'encoding_format' CHAR(32) COMMENT 'mime type for this image to disambiguate different encodings of the same image',
  'requires_subscription' BOOLEAN COMMENT 'indicates if use of the media require a subscription, either paid or free',
  /* SCHEMA: CreativeWork */
  'about' BIGINT UNSIGNED COMMENT 'ucm_id this image represents, could be same as content_location or a different subject e.g. an organization', /* FK to #__cajobboard_ucm */
  'content_location' BIGINT UNSIGNED COMMENT ' location depicted or described in the image', /* FK to #__cajobboard_places */
  /* SCHEMA: Thing */
  'name' VARCHAR(255) COMMENT 'a name for this image',
  'description' TEXT COMMENT 'a long description of this image'
  PRIMARY KEY ('image_id'),
  /* FOREIGN KEY (image_id) REFERENCES #__cajobboard_ucm(id), */
  /* FOREIGN KEY (about) REFERENCES #__cajobboard_ucm(id), */
  /* FOREIGN KEY (content_location) REFERENCES #__cajobboard_places(places_id) */
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;

 /**
 * Join table for image media
 */
CREATE TABLE IF NOT EXISTS '#__cajobboard_media_image_join' (
  'id' BIGINT UNSIGNED NOT NULL, /* FK to #__cajobboard_ucm */
  'image_id' BIGINT UNSIGNED NOT NULL, /* FK to #__cajobboard_media_image */
  PRIMARY KEY ('id'),
  /* FOREIGN KEY (id) REFERENCES #__cajobboard_ucm(id), */
  /* FOREIGN KEY (image_id) REFERENCES #__cajobboard_media_image(image_id) */
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;
