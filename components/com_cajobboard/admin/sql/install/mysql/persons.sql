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
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key',
  person_id BIGINT UNSIGNED NOT NULL COMMENT 'FK to #__cajobboard_persons',
  geo_id BIGINT UNSIGNED NOT NULL  COMMENT 'FK to #__cajobboard_geo_coordinates',

  INDEX person_index (person_id),
  INDEX geo_index (geo_id),
  PRIMARY KEY (id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;