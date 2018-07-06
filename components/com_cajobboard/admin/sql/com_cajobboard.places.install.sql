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
CREATE TABLE IF NOT EXISTS '#__cajobboard_places' (
  'place_id' BIGINT UNSIGNED NOT NULL, /* FK to #__cajobboard_ucm(id) */
  'branch_code' CHAR(50) COMMENT 'A short textual code that uniquely identifies a place of business',
  'fax_number'CHAR(16) COMMENT 'The fax number',
  'public_access' 	BOOLEAN COMMENT 'A flag to signal that the Place is open to public visitors. If this property is omitted there is no assumed default boolean value',
  /* Place (geo) -> GeoCoordinates NOTE: https://schema.org/GeoCoordinates has separate latitude, longitude properties instead of using GIS point */
  'geo' POINT COMMENT 'latitude and longitude of place using MySQL GIS spatial data type. Example: INSERT INTO place(geo) VALUES (Point(1,2));',
  /* Place (address) -> PostalAddress */
/* @TODO: Normalize PostalAddress into its own table. PostalAddress is referenced in Organization table. */
  'address__address_country' CHAR(2) COMMENT 'The two-letter ISO 3166-1 alpha-2 country code',
  'address__address_locality' CHAR(50) COMMENT 'The locality, e.g. Mountain View',
  'address__postal_code' CHAR(12) COMMENT 'The postal code, e.g. 94043',
  'address__street_address' VARCHAR(255) COMMENT 'The street address, e.g. 1600 Amphitheatre Pkwy',
  'address_region' CHAR(18) COMMENT 'The name of the region, e.g. California', /* FK to #__cajobboard_util_address_region(address_region) */

  'telephone' CHAR(16) COMMENT 'The telephone number', /* FK to #__cajobboard_util_telephone(telephone) */
  'logo' BIGINT UNSIGNED COMMENT 'an associated logo image', /* FK to #__cajobboard_media_image(image_id) */
/* M:M relationship in  #__cajobboard_media_image_join Place (photo) -> ImageObject */
  PRIMARY KEY ('places_id'),
/* @TODO: set indexes */ INDEX par_index (parent_id),
  /* FOREIGN KEY (place_id) REFERENCES #__cajobboard_ucm(id), */
  /* FOREIGN KEY (address_region) REFERENCES #__cajobboard_util_address_region(address_region), */
  /* FOREIGN KEY (telephone) REFERENCES #__cajobboard_util_telephone(telephone), */
  /* FOREIGN KEY (logo) REFERENCES  #__cajobboard_media_image(image_id) */
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;


/**
 * Open hours table
  *
 * Uses schema https://schema.org/OpeningHoursSpecification
 */
CREATE TABLE IF NOT EXISTS '#__cajobboard_places_open_hours' (
  'places_id' BIGINT UNSIGNED NOT NULL AUTO_INCREMENT=0, /* FK to #__cajobboard_places */
  'day_of_week' CHAR(16) NOT NULL COMMENT 'The day of the week for which these opening hours are valid', /* FK to #__cajobboard_util_day_of_week */
  'opens' DATETIME DEFAULT '0000-00-00 00:00:00'  COMMENT 'The opening hour of the place or service on the given day(s) of the week',
  'closes' DATETIME DEFAULT '0000-00-00 00:00:00' COMMENT 'The closing hour of the place or service on the given day(s) of the week',
  PRIMARY KEY ('id'),
  /* FOREIGN KEY (places_id) REFERENCES #__cajobboard_places(places_id), */
  /* FOREIGN KEY (day_of_week) REFERENCES #__cajobboard_util_day_of_week(day) */
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;
