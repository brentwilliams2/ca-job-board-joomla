/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

 /**
 * Employment type table
 *
 * Used to enumerate types of employment, e.g. "full-time", "part-time",
 * "contract", "temporary", "seasonal", "internship"
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_employment_types` (
  employment_type_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key',
  slug CHAR(255) NOT NULL COMMENT 'alias for SEF URL',

  /* FOF "magic" fields */
  asset_id	INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Enable record-level access control.', /* FK to the #__assets */
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
  publish_down DATETIME COMMENT 'Date and time to change the state to unpublished.',
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
  note VARCHAR(255) COMMENT 'A note to save with this job posting in the back-end interface.',

  /* SCHEMA: Thing */
  `name` CHAR(96) NOT NULL COMMENT 'Type of employment (e.g. full-time, part-time, contract, temporary, seasonal, internship)',
  description TEXT NOT NULL COMMENT 'Detailed description about type of employment',
  description__intro VARCHAR(280) COMMENT 'Short description of the item, used for the text shown on browe views.',
  url VARCHAR(2083) NOT NULL COMMENT 'Link to schema for type of employment, e.g. wikipedia page on Full Time',

  /* SQL DDL */
  PRIMARY KEY (employment_type_id),
  UNIQUE KEY (`name`)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;


/**
 * Initial employment types
 */
INSERT INTO `#__cajobboard_employment_types` (slug, name, description, url) VALUES
  ('full-time', 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_FULL_TIME', 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_FULL_TIME_DESCRIPTION', 'https://en.wikipedia.org/wiki/Full-time'),
  ('part-time', 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_PART_TIME', 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_PART_TIME_DESCRIPTION', 'https://en.wikipedia.org/wiki/Part-time_contract'),
  ('flex-time', 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_FLEX-TIME', 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_FLEX-TIME_DESCRIPTION', 'https://en.wikipedia.org/wiki/Flextime'),
  ('contract', 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_CONTRACT', 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_CONTRACT_DESCRIPTION', 'https://en.wikipedia.org/wiki/Fixed-term_employment_contract'),
  ('temporary', 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_TEMPORARY', 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_TEMPORARY_DESCRIPTION', 'https://en.wikipedia.org/wiki/Temporary_work'),
  ('casual', 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_CASUAL', 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_CASUAL_DESCRIPTION', 'https://en.wikipedia.org/wiki/Casual_employment_(contract)'),
  ('internship', 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_INTERNSHIP', 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_INTERNSHIP_DESCRIPTION', 'https://en.wikipedia.org/wiki/Internship'),
  ('other', 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_OTHER', 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_OTHER_DESCRIPTION', 'https://en.wiktionary.org/wiki/other');
