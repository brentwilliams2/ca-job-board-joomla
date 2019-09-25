/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

/**
 * Analytic Aggregates data model SQL
 *
 * Uses schema https://calligraphic.design/schema/AnalyticAggregate
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_analytic_aggregates` (
  analytic_aggregate_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key', /* FK to #__cajobboard_ucm(id) */
  slug CHAR(255) NOT NULL COMMENT 'alias for SEF URL',

  /* FOF "magic" fields */
  asset_id	INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Enable record-level access control.', /* FK to #__assets */
  access INT UNSIGNED NOT NULL DEFAULT '1' COMMENT 'The Joomla! view access level.',
  created_on DATETIME DEFAULT NULL COMMENT 'Timestamp of record creation, auto-filled by save().',
  created_by INT NOT NULL DEFAULT '0' COMMENT 'User ID who created the record, auto-filled by save().',
  modified_on DATETIME DEFAULT NULL COMMENT 'Timestamp of record modification, auto-filled by save(), touch().',
  modified_by INT DEFAULT '0' COMMENT 'User ID who modified the record, auto-filled by save(), touch().',
  locked_on DATETIME DEFAULT NULL COMMENT 'Timestamp of record locking, auto-filled by lock(), unlock().',
  locked_by INT DEFAULT '0' COMMENT 'User ID who locked the record, auto-filled by lock(), unlock().',

  /* Joomla UCM fields, used by Joomla!s UCM when using the FOF ContentHistory behaviour */
  ordering INT NOT NULL DEFAULT '0' COMMENT 'Order this record should appear in for sorting.',
  params TEXT COMMENT 'JSON encoded parameters for the content item.',
  cat_id INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Category ID for this content item.',
  note VARCHAR(255) COMMENT 'A note to save with this analytic aggregate in the back-end interface.',

  /* SCHEMA: Thing */
  name VARCHAR(255) COMMENT 'Aliased by title property. Used as <h1> header text and page title. The latter can be overridden in params (page_title).',
  description TEXT COMMENT 'Description of the analytic aggregate.',
  description__intro VARCHAR(280) COMMENT 'Short description of the item, used for the text shown on browse views.',
  about__foreign_model_id BIGINT UNSIGNED COMMENT 'The primary key of the foreign model item that this comment belongs to.',
  about__foreign_model_name VARCHAR(255) COMMENT 'The name of the foreign model this comment belongs to, discriminator field for single-table inheritance',

  /* SCHEMA: Thing(additionalType) -> StructuredValue */
  structured_value JSON COMMENT 'The values for this analytic aggregate, in a JSON string',

  /* SQL DDL */
  PRIMARY KEY (analytic_aggregate_id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;


/*
  @TODO: Need to track costs for incoming traffic by job (indeed.com, etc.)
*/
