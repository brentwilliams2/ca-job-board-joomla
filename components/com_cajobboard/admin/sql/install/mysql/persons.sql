/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

 /**
 * User Geo table, store user's coordinates in MySQL GIS for easy searching
 *
 * Uses schema https://schema.org/GeoCoordinates
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_person_geos` (
  person_geo_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key', /* FK to #__cajobboard_ucm(id) */

  /* SCHEMA: Place (geo) -> GeoCoordinates NOTE: https://schema.org/GeoCoordinates has separate latitude, longitude properties instead of using GIS point */
  geo POINT NOT NULL COMMENT 'latitude and longitude of place using MySQL GIS spatial data type. Example: INSERT INTO place(geo) VALUES (Point(1,2));',

  SPATIAL INDEX spatial_index (geo),
  PRIMARY KEY (person_geo_id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;

 /**
 * Join table for persons and organizations
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_persons_organizations` (
  id BIGINT UNSIGNED NOT NULL COMMENT 'Surrogate primary key',
  user_id BIGINT UNSIGNED NOT NULL COMMENT 'FK to #__users',
  organization_id BIGINT UNSIGNED NOT NULL COMMENT 'FK to #__cajobboard_organizations',
  PRIMARY KEY (id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;
