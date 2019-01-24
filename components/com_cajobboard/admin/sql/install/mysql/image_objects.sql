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

  /* FOF "magic" fields */
  asset_id	INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Enable record-level access control.', /* FK to the #__assets */
  access INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'The Joomla! view access level.',
  enabled TINYINT NOT NULL DEFAULT '0' COMMENT 'Publish status: -2 for trashed and marked for deletion, -1 for archived, 0 for unpublished, and 1 for published.',
  created_on DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp of record creation, auto-filled by save().',
  created_by INT NOT NULL DEFAULT '0' COMMENT 'User ID who created the record, auto-filled by save().',
  modified_on DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp of record modification, auto-filled by save(), touch().',
  modified_by INT NOT NULL DEFAULT '0' COMMENT 'User ID who modified the record, auto-filled by save(), touch().',
  locked_on DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp of record locking, auto-filled by lock(), unlock().',
  locked_by INT DEFAULT '0' COMMENT 'User ID who locked the record, auto-filled by lock(), unlock().',

  /* Joomla UCM fields, used by Joomla!s UCM when using the FOF ContentHistory behaviour */
  publish_up DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date and time to change the state to published, schema.org alias is datePosted.',
  publish_down DATETIME COMMENT 'Date and time to change the state to unpublished.',
  version INT UNSIGNED NOT NULL DEFAULT '1' COMMENT 'Version of this item.',
  ordering INT NOT NULL DEFAULT '0' COMMENT 'Order this record should appear in for sorting.',
  metadata JSON COMMENT 'JSON encoded metadata field for this item.',
  metakey TEXT COMMENT 'Meta keywords for this item.',
  metadesc TEXT COMMENT 'Meta descriptionfor this item.',
  xreference TEXT COMMENT 'A reference to enable linkages to external data sets, used to output a meta tag like FB open graph.',
  params TEXT COMMENT 'JSON encoded parameters for the content item.',
  language CHAR(7) NOT NULL DEFAULT '*' COMMENT 'The language code for the article or * for all languages.',
  cat_id INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Category ID for this content item.',
  hits INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Number of hits the content item has received on the site.',
  featured TINYINT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Whether this content item is featured or not.',

  /* SCHEMA: Thing */
  name VARCHAR(255) COMMENT 'A name for this image.',
  description TEXT COMMENT 'A long description of this image.',
  author BIGINT UNSIGNED COMMENT 'The author of this content or rating.', /* FK to #__users */

  /* SCHEMA: ImageObject */
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


/**
 * Initial media object categories
 */
INSERT INTO `#__cajobboard_comments`(
  comment_id,
  slug,
  `text`,
  parentItem,
  about__model,
  about__id,
  upvoteCount,
  downvoteCount
)
VALUES
  (
    '1',
    'slow-internet',
    "Slow internet is my generation's Vietnam.",
    '0',
    'JobPostings',
    '1',
    '9',
    '3'
  ),
