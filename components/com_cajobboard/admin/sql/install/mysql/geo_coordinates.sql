/**
 * Data model for GeoCoordinates data (MySQL Point type)
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

/**
 * GeoCoordinates SQL
 *
 * Uses schema https://schema.org/GeoCoordinates
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_geo_coordinates` (
  geo_coordinates_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key', /* FK to #__cajobboard_ucm(id) */
  /* SCHEMA: Place (geo) -> GeoCoordinates NOTE: https://schema.org/GeoCoordinates has separate latitude, longitude properties instead of using GIS point */
  geo POINT NOT NULL COMMENT 'latitude and longitude of place using MySQL GIS spatial data type. Example: INSERT INTO `j_cajobboard_geo_coordinates`(`geo`) VALUES (Point(1,2));',
  /* SQL DDL */
  PRIMARY KEY (geo_coordinates_id),
  SPATIAL INDEX spatial_index (geo)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;
