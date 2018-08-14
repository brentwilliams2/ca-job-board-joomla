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
  id BIGINT UNSIGNED NOT NULL COMMENT 'Surrogate primary key',
  photo BIGINT UNSIGNED NOT NULL COMMENT 'FK to #__places',
  image_object_id BIGINT UNSIGNED NOT NULL COMMENT 'FK to #__cajobboard_image_objects',
  PRIMARY KEY (id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;
