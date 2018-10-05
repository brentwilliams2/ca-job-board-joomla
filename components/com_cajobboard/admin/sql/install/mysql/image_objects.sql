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
CREATE TABLE IF NOT EXISTS `#__cajobboard_image_objects` (
  image_object_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key',
  slug CHAR(255) NOT NULL COMMENT 'alias for SEF URL',

  /* SCHEMA: Thing */
  name VARCHAR(255) COMMENT 'A name for this image.',
  description TEXT COMMENT 'A long description of this image.',
  author BIGINT UNSIGNED COMMENT 'The author of this content or rating.', /* FK to #__users */

  /* SCHEMA: ImageObject */
  thumbnail VARCHAR(255) COMMENT 'Filename of the property image thumbnail.',
  caption VARCHAR(255) COMMENT 'Caption for the property image.',
  exif_data TEXT COMMENT 'JSON-encoded EXIF data for this image.',

  /* SCHEMA: MediaObject */
  content_url VARCHAR(255) NOT NULL COMMENT 'Filename of the property image.',
  content_size BIGINT(20) COMMENT 'File size in bytes.',
  height INT COMMENT 'Height of the property image in px',
  width INT COMMENT 'Width of the property image in px',

  /* SCHEMA: CreativeWork */
  content_location BIGINT UNSIGNED COMMENT 'Place depicted or described in the image.', /* FK to #__cajobboard_places */

  PRIMARY KEY (image_object_id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;


