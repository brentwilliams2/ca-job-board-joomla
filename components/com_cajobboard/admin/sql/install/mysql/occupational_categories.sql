/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

 /**
 * BLS O*NET-SOC taxonomy table for occupational categories
 *
 * see http://www.onetcenter.org/taxonomy.html
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_occupational_categories` (
  occupational_category_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key',
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
  publish_up DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date and time to change the state to published, schema.org alias is datePosted.',
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
  title CHAR(96) NOT NULL COMMENT 'occupational category title',
 	`code` CHAR(10) NOT NULL DEFAULT '0' COMMENT 'BLS code specifying this job category',
  `group` BIGINT UNSIGNED NOT NULL COMMENT 'Group this occupational category should be shown under e.g. office staff', /* FK to #__cajobboard_job_occupational_category_group(job_occupational_category_group_id) */

  /* SQL DDL */
  PRIMARY KEY (occupational_category_id),
  UNIQUE KEY (title),
  INDEX job_category_group_index (`group`)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;


/**
 * Initial occupational categories
 */
INSERT INTO `#__cajobboard_occupational_categories` (slug, `code`, ordering, `group`, title) VALUES
  ('general-and-operations-managers', '11-1021.00', 1, 9, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_GENERAL_AND_OPERATIONS_MANAGERS'),
  ('property-and-community-managers', '11-9141.00', 2, 9, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_PROPERTY_AND_COMMUNITY_MANAGERS'),
  ('regulatory-affairs-managers', '11-9199.01', 3, 9, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_REGULATORY_AFFAIRS_MANAGERS'),
  ('other-managers', '11-9199.00', 4, 9, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_OTHER_MANAGERS'),
  ('leasing-and-sales-managers-and-executives', '11-2022.00', 1, 6, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_LEASING_AND_SALES_MANAGERS_AND_EXECUTIVES'),
  ('leasing-and-sales-agents', '41-3099.00', 2, 6, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_LEASING_AND_SALES_AGENTS'),
  ('marketing-managers-and-executives', '11-2021.00', 1, 7, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_MARKETING_MANAGERS_AND_EXECUTIVES'),
  ('marketing-specialists', '13-1161.00', 2, 7, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_MARKETING_SPECIALISTS'),
  ('financial-managers-and-executives', '11-3031.00', 1, 3, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_FINANCIAL_MANAGERS_AND_EXECUTIVES'),
  ('accountants', '13-2011.01', 2, 3, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_ACCOUNTANTS'),
  ('bookkeepers-and-accounting-clerks', '43-3031.00', 3, 3, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_BOOKKEEPERS_AND_ACCOUNTING_CLERKS'),
  ('information-technology-managers-and-executives', '11-3021.00', 1, 5, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_INFORMATION_TECHNOLOGY_MANAGERS_AND_EXECUTIVES'),
  ('computer-programmers', '15-1131.00', 2, 5, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_COMPUTER_PROGRAMMERS'),
  ('web-administrators', '15-1199.03', 3, 5, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_WEB_ADMINISTRATORS'),
  ('human-resources-managers-and-executives', '11-3121.00', 1, 4, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_HUMAN_RESOURCES_MANAGERS_AND_EXECUTIVES'),
  ('training-and-development-managers', '11-3131.00', 2, 4, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_TRAINING_AND_DEVELOPMENT_MANAGERS'),
  ('human-resources-specialists', '13-1071.00', 3, 4, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_HUMAN_RESOURCES_SPECIALISTS'),
  ('office-managers-and-executives', '11-3011.00', 1, 8, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_OFFICE_MANAGERS_AND_EXECUTIVES'),
  ('secretaries-and-administrative-assistants', '43-6014.00', 2, 8, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_SECRETARIES_AND_ADMINISTRATIVE_ASSISTANTS'),
  ('receptionists', '43-4171.00', 3, 8, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_RECEPTIONISTS'),
  ('customer-service-representatives', '43-4051.00', 4, 8, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_CUSTOMER_SERVICE_REPRESENTATIVES'),
  ('file-clerks', '43-4071.00', 5, 8, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_FILE_CLERKS'),
  ('compliance-officers', '13-1041.00', 6, 8, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_COMPLIANCE_OFFICERS'),
  ('equal-opportunity-representatives-and-officers', '13-1041.03', 7, 8, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_EQUAL_OPPORTUNITY_REPRESENTATIVES_AND_OFFICERS'),
  ('housekeeping-and-janitorial-supervisors', '37-1011.00', 1, 2, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_HOUSEKEEPING_AND_JANITORIAL_SUPERVISORS'),
  ('janitors-and-cleaners', '37-2011.00', 2, 2, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_JANITORS_AND_CLEANERS'),
  ('landscaping-lawn-service-and-groundskeeping-supervisors', '37-1012.00', 3, 2, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_LANDSCAPING_LAWN_SERVICE_AND_GROUNDSKEEPING_SUPERVISORS'),
  ('landscaping-and-groundskeeping-workers', '37-3011.00', 4, 2, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_LANDSCAPING_AND_GROUNDSKEEPING_WORKERS'),
  ('maintenance-supervisors', '49-1011.00', 5, 2, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_MAINTENANCE_SUPERVISORS'),
  ('maintenance-workers', '49-9071.00', 6, 2, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_MAINTENANCE_WORKERS'),
  ('security-managers', '11-9199.07', 7, 2, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_SECURITY_MANAGERS'),
  ('security-guards', '33-9032.00', 8, 2, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_SECURITY_GUARDS'),
  ('pest-control-workers', '37-2021.00', 9, 2, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_PEST_CONTROL_WORKERS'),
  ('project-and-construction-managers', '11-9021.00', 1, 1, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_PROJECT_AND_CONSTRUCTION_MANAGERS'),
  ('construction-supervisors', '47-1011.00', 2, 1, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_CONSTRUCTION_SUPERVISORS'),
  ('construction-workers-general', '47-4099.00', 3, 1, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_CONSTRUCTION_WORKERS_GENERAL'),
  ('brickmasons-and-blockmasons', '47-2021.00', 4, 1, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_BRICKMASONS_AND_BLOCKMASONS'),
  ('carpenters', '47-2031.00', 5, 1, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_CARPENTERS'),
  ('carpet-installers', '47-2041.00', 6, 1, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_CARPET_INSTALLERS'),
  ('construction-laborers', '47-2061.00', 7, 1, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_CONSTRUCTION_LABORERS'),
  ('drywall-and-ceiling-tile-installers', '47-2081.00', 8, 1, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_DRYWALL_AND_CEILING_TILE_INSTALLERS'),
  ('electricians', '47-2111.00', 9, 1, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_ELECTRICIANS'),
  ('painters-construction-and-maintenance', '47-2141.00', 10, 1, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_PAINTERS_CONSTRUCTION_AND_MAINTENANCE'),
  ('plumbers', '47-2152.02', 11, 1, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_PLUMBERS'),
  ('roofers', '47-2181.00', 12, 1, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_ROOFERS'),
  ('other', '00-0000.00', 1, 10, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_OTHER');
