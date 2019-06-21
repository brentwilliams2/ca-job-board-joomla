/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

/**
 * Job Alerts data model SQL
 *
 * Job Seeker alerts by category, geographic proximity (e.g. within one mile)
 *
 * Uses schema https://calligraphic.design/schema/Alert
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_job_alerts` (
  job_alert_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key', /* FK to #__cajobboard_ucm(id) */
  slug CHAR(255) NOT NULL COMMENT 'alias for SEF URL',

  /* FOF "magic" fields */
  asset_id	INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Enable record-level access control.', /* FK to #__assets */
  access INT UNSIGNED NOT NULL DEFAULT '1' COMMENT 'The Joomla! view access level.',
  enabled TINYINT NOT NULL DEFAULT '1' COMMENT 'Publish status: -2 for trashed and marked for deletion, -1 for archived, 0 for unpublished, and 1 for published.',
  created_on DATETIME DEFAULT NULL COMMENT 'Timestamp of record creation, auto-filled by save().',
  created_by INT NOT NULL DEFAULT '0' COMMENT 'User ID who created the record, auto-filled by save().',
  modified_on DATETIME DEFAULT NULL COMMENT 'Timestamp of record modification, auto-filled by save(), touch().',
  modified_by INT DEFAULT '0' COMMENT 'User ID who modified the record, auto-filled by save(), touch().',
  locked_on DATETIME DEFAULT NULL COMMENT 'Timestamp of record locking, auto-filled by lock(), unlock().',
  locked_by INT DEFAULT '0' COMMENT 'User ID who locked the record, auto-filled by lock(), unlock().',

  /* Joomla UCM fields, used by Joomla!s UCM when using the FOF ContentHistory behaviour */
  publish_up DATETIME DEFAULT NULL COMMENT 'Date and time to change the state to published, schema.org alias is datePosted.',
  publish_down DATETIME DEFAULT NULL COMMENT 'Date and time to change the state to unpublished.',
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
  note VARCHAR(255) COMMENT 'A note to save with this alert in the back-end interface.',

  /* SCHEMA: Thing */
  name VARCHAR(255) COMMENT 'Aliased by title property. Used as <h1> header text and page title. The latter can be overridden in params (page_title).',
  description TEXT COMMENT 'Short description of the alert, used for the text shown on social media via shares and search engine results.',

  /* SCHEMA: https://schema.org/GeoCoordinates */
  geo_coordinate BIGINT UNSIGNED COMMENT 'The geographic coordinates of the center of the job seeker\'s search radius.', /* FK to #__cajobboard_geo_coordinates */

  /* SCHEMA: https://schema.org/geoRadius */
  geo_radius INT UNSIGNED COMMENT 'The distance in miles to search for jobs from the job seeker\'s search radius center point.',

  /* SCHEMA: https://schema.org/occupationalCategory */
  occupational_category BIGINT UNSIGNED COMMENT 'A category describing the job', /* FK to #__cajobboard_occupational_categories */

  /* SCHEMA: https://schema.org/keywords */
  keywords JSON COMMENT 'Used to filter jobs shown for this alert. Should be a case-insensitive array of keywords, e.g. [ "great customers", "friendly", "fun" ]',

  /* SCHEMA: https://schema.org/expires */
  expires DATETIME DEFAULT NULL COMMENT 'Date this job alert is no long needed',

  /* SQL DDL */
  PRIMARY KEY (job_alert_id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;
