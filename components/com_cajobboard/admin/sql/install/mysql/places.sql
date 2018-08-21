/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * DEPENDS ON: #__cajobboard_ucm, #__cajobboard_util_day_of_week
 */

 /**
 * Places table
 *
 * Uses schema https://schema.org/Places
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_places` (
  place_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key', /* FK to #__cajobboard_ucm(id) */
  slug CHAR(255) NOT NULL COMMENT 'alias for SEF URL',

  /* FOF "magic" fields */
  asset_id	INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Enable record-level access control.', /* FK to the #__assets */
  access INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'The Joomla! view access level.',
  enabled TINYINT NOT NULL DEFAULT '0' COMMENT 'Publish status: -2 for trashed and marked for deletion, -1 for archived, 0 for unpublished, and 1 for published.',
  created_on DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp of record creation, auto-filled by save().',
  created_by INT NOT NULL DEFAULT '0' COMMENT 'User ID who created the record, auto-filled by save().',
  modified_on DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp of record modification, auto-filled by save(), touch().',
  modified_by INT DEFAULT '0' COMMENT 'User ID who modified the record, auto-filled by save(), touch().',
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

  /* SCHEMA: PostalAddress */
  branch_code VARCHAR(50) COMMENT 'A short textual code that uniquely identifies a place of business',
  fax_number VARCHAR(30) COMMENT 'The E.164 PSTN fax number',
  public_access BOOLEAN COMMENT 'A flag to signal that the Place is open to public visitors. If this property is omitted there is no assumed default boolean value',

  /* SCHEMA: Place (geo) -> GeoCoordinates NOTE: https://schema.org/GeoCoordinates has separate latitude, longitude properties instead of using GIS point */
  geo POINT NOT NULL COMMENT 'latitude and longitude of place using MySQL GIS spatial data type. Example: INSERT INTO place(geo) VALUES (Point(1,2));',

  /* Place (address) -> PostalAddress */
  address__street_address VARCHAR(255) COMMENT 'The street address, e.g. 1600 Amphitheatre Pkwy',
  address__address_locality VARCHAR(50) COMMENT 'The locality, e.g. Mountain View',
  address_region BIGINT UNSIGNED NOT NULL COMMENT 'The name of the region, e.g. California', /* FK to #__cajobboard_util_address_region(address_region) */
  address__postal_code VARCHAR(12) COMMENT 'The postal code, e.g. 94043',
  address__address_country VARCHAR(2) COMMENT 'The two-letter ISO 3166-1 alpha-2 country code',
  telephone VARCHAR(30) COMMENT 'The E.164 PSTN telephone number',
  openingHoursSpecification TEXT COMMENT 'The days and times this location is open.',
  logo BIGINT UNSIGNED COMMENT 'A logo image that represents this place.', /* FK to #__cajobboard_images(image_id) */
  photo BIGINT UNSIGNED COMMENT 'A photograph of this place.', /* FK M:M relationship in to #__cajobboard_images(image_id) */
  SPATIAL INDEX spatial_index (geo),
  PRIMARY KEY (place_id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;

 /**
 * Join table for places and image objects
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_places_images` (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key',
  photo BIGINT UNSIGNED NOT NULL COMMENT 'FK to #__places',
  image_object_id BIGINT UNSIGNED NOT NULL COMMENT 'FK to #__cajobboard_image_objects',
  PRIMARY KEY (id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;
