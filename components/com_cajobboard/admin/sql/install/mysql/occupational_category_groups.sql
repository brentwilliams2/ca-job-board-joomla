/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

 /**
 * Occupational category groups table
 *
 * Used to create general groups of job categories, e.g. "Office Staff",
 * "Leasing and Sales"
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_occupational_category_groups` (
  occupational_category_group_id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key',
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

  /* SCHEMA: https://calligraphic.design/schema/OccupationalCategoryBLS */
  `group` CHAR(96) NOT NULL COMMENT 'Name for this group of occupational categories, e.g. office staff',

  /* SCHEMA: Thing */
  description TEXT NOT NULL COMMENT 'Occupational category group description',
  url VARCHAR(2083) NOT NULL COMMENT 'link to schema for occupational category, e.g. wikipedia page on Management',

  /* SQL DDL */
  PRIMARY KEY (occupational_category_group_id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;


/**
 * Initial occupational groups
 */
INSERT INTO `#__cajobboard_occupational_category_groups` (occupational_category_group_id, slug, `group`, description, url) VALUES
  (1, 'construction', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_CONSTRUCTION', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_CONSTRUCTION_DESCRIPTION', 'https://en.wikipedia.org/wiki/Construction'),
  (2, 'facilities', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_FACILITIES', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_FACILITIES_DESCRIPTION', 'https://en.wikipedia.org/wiki/Facility_management'),
  (3, 'finance', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_FINANCE', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_FINANCE_DESCRIPTION', 'https://en.wikipedia.org/wiki/Accounting'),
  (4, 'human-resources', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_HR', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_HR_DESCRIPTION', 'https://en.wikipedia.org/wiki/Human_resource_management'),
  (5, 'information-technology', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_IT', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_IT_DESCRIPTION', 'https://en.wikipedia.org/wiki/Information_technology'),
  (6, 'leasing', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_LEASING', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_LEASING_DESCRIPTION', 'https://en.wikipedia.org/wiki/Letting_agent'),
  (7, 'marketing', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_MARKETING', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_MARKETING_DESCRIPTION', 'https://en.wikipedia.org/wiki/Marketing'),
  (8, 'office', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_OFFICE', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_OFFICE_DESCRIPTION', 'https://en.wikipedia.org/wiki/Office_administration'),
  (9, 'management', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_MGMT', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_MGMT_DESCRIPTION', 'https://en.wikipedia.org/wiki/Management'),
  (10, 'other', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_OTHER', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_OTHER_DESCRIPTION', 'https://en.wiktionary.org/wiki/other');
