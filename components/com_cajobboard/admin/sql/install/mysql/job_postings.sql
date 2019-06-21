/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

/**
 * Job Postings table
 *
 * Uses schema https://schema.org/JobPosting
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_job_postings` (
  /* UCM (unified content model) properties for internal record metadata */
  job_posting_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key',
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
  version INT UNSIGNED NOT NULL DEFAULT '1' COMMENT 'Version of this item.',
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

  /* SCHEMA: JobPosting */
  title CHAR(255) COMMENT 'The title of the job posting.',
  disambiguating_description TEXT COMMENT 'Short description of the job, used in cajobboard on job posting list pages, etc.',
  description TEXT COMMENT 'Long description of the job posting.',
  education_requirements TEXT COMMENT 'Educational background needed for the position or Occupation.',
  experience_requirements TEXT COMMENT 'Description of skills and experience needed for the position or Occupation.',
  incentive_compensation TEXT COMMENT 'Description of bonus and commission compensation aspects of the job. Supersedes incentives.',
  job_benefits TEXT COMMENT 'Description of benefits associated with the job. Supersedes benefits.',
  qualifications TEXT COMMENT 'Specific qualifications required for this role or Occupation.',
  responsibilities TEXT COMMENT 'Responsibilities associated with this role or Occupation.',
  skills TEXT COMMENT 'Skills required to fulfill this role',
  special_commitments TEXT COMMENT 'Any special commitments associated with this job posting. Valid entries include VeteranCommit, MilitarySpouseCommit, etc.',
  work_hours TEXT COMMENT 'The typical working hours for this job (e.g. 1st shift, night shift, 8am-5pm).', /* OpeningHoursSpecification has a schema very close to something workHours could use */
  job_location BIGINT UNSIGNED NOT NULL COMMENT 'A (typically single) geographic location associated with the job position.', /* FK to #__cajobboard_places(place_id) */
  hiring_organization BIGINT UNSIGNED NOT NULL COMMENT 'Organization offering the job position.', /* FK to #__cajobboard_organizations(organization_id) */

  /* SCHEMA: JobPosting (relevantOccupation) -> Occupation (name) */
  relevant_occupation_name TEXT NOT NULL COMMENT 'The job title.',

  /* SCHEMA: JobPosting (baseSalary) -> MonetaryAmount */
  base_salary__max_value FLOAT COMMENT 'The maximum salary of the job or of an employee in an EmployeeRole.',
  base_salary__value FLOAT COMMENT 'The base salary of the job or of an employee in an EmployeeRole.',
  base_salary__min_value FLOAT COMMENT 'The minimum salary of the job or of an employee in an EmployeeRole.',
  base_salary__currency CHAR(6) COMMENT 'Use ISO 4217 currency format e.g. USD.',

  /* SCHEMA: JobPosting (baseSalary) -> MonetaryAmount (additionalType) -> Duration */
  base_salary__duration CHAR(32) COMMENT 'use ISO 8601 duration format, e.g. P2W for bi-weekly.',

  /* SCHEMA: Thing */
  identifier CHAR(255) COMMENT 'Internal identifier used by the employer for this job posting.',
  same_as VARCHAR(2083) COMMENT 'URL of the job posting on the employer\'s website',

  /* SCHEMA: https://calligraphic.design/schema/EmploymentType */
  employment_type BIGINT UNSIGNED NOT NULL COMMENT 'Type of employment (e.g. full-time, part-time, contract, temporary, seasonal, internship).', /* FK to #__cajobboard_employment_types(job_employment_type_id) */

  /* SCHEMA: https://calligraphic.design/schema/OccupationalCategoryBLS */
  occupational_category BIGINT UNSIGNED NOT NULL COMMENT 'The occupation of the job posting. Uses BLS O*NET-SOC taxonomy.', /* FK to #__cajobboard_occupational_categories(job_occupational_category_id) */

  /* SQL DDL */
  PRIMARY KEY (job_posting_id),
  INDEX jobposting_slug_index (slug),
  INDEX occupational_category_index (occupational_category),
  INDEX job_location_index (job_location),
  INDEX hiring_organization_index (hiring_organization)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;


/*
 * Create content types for relevant tables, mapping fields to the UCM standard fields for history feature
 *
 * type_id:     auto-increment id number.
 *
 * type_title:  descriptive title for this table.
 *
 * type_alias:  <component name>.<type name>. For example: "com_content.article" or "com_content.category".
 *              Used by the com_contenthistory component to find the row for each component in the #__content_types table
 *
 * table:       JSON string that contains the name of the JTable class and other information about the table.
                Gives the com_contenthistory component the information it needs to work with the JTable class for each component.
 * rules:       Not used as of Joomla version 3.2.
 *
 * field_mappings:    Used by the com_tags component to map database columns from the component table to the ucm_content table.
 *
 * router:      Optional location of the component's router, if any.
 *
 * content_history_options:   JSON string used to store information for rendering the pop-up windows in the content history component.
 *                            Structure:
 *
 *    formfile:       This is the path to the XML JForm file for this form. If you add this, the Preview and
 *                    Compare views will look up the labels from this XML file. This way the user will see
 *                    translated labels instead of the database column name.
 *
 *    hideFields:     Some database columns are not meaningful for the user when viewing the item. For example,
 *                    asset_id or check_out_time are not things that appear in the form and are not helpful to
 *                    the user when figuring out the contents of an item. This is entered as an array of column names.
 *
 *    ignoreChanges:  The content history component uses a "hash" calculation (Sha1) to determine whether an item
 *                    has changed. This allows you to see which version in history matches the current version. It
 *                    also prevents duplicate versions from being saved in the content history table (for example,
 *                    if you press the "save" button without making any changes). For this to work properly, we need
 *                    to exclude some columns from the hash calculate. The "ignoreChanges" lets you exclude some database
 *                    columns from the hash so that changes to these columns will not be considered real changes to the
 *                    item. For example, columns such as "hits" or "modified_time" will change with each save, even if
 *                    no meaningful data was changed in the item. This is an array of database column names.
 *
 *    convertToInt:   When the hash value is created, it uses a JSON array of the database column values. In some cases,
 *                    such as start and stop publishing dates, the value might be blank when a row is first created and
 *                    then a different value after the item is saved. To get a consistent hash value for the first and
 *                    subsequent saves, these values can be converted to integers before the hash is created. That way,
 *                    we don't think a value has changed when it really hasn't. This is an array of database column names.
 *
 *    displayLookup:  Here we can define how to display more meaningful data, for example, displaying a category title
 *                    or user name instead of the ID. This is stored as an array of PHP standard class objects. Each
 *                    object has the following fields:
 *
 *        sourceColumn:  The column in the form to replace. For example, the "created_user_id" or "catid".
 *        targetTable:   The database table to get the title or name. For example, "#__users" or "#__categories".
 *        targetColumn:  The column in the target table to use in the SQL query JOIN statement. For example, "id".
 *        displayColumn: The column in the target table to display in the Preview or Compare pop-up window. For example, "name" or "title".
 */

/*
 * Job Postings content type for history component
 */
INSERT INTO `#__content_types` (`type_id`, `type_title`, `type_alias`, `table`, `rules`, `field_mappings`, `router`, `content_history_options`)
VALUES(
  /* type_id */
  null,
  /* type_title */
  'Job Postings',
  /* type_alias */
  'com_cajobboard.jobpostings',
  /* table NOTE: No spaces, Joomla! stupidly has this set as a VARCHAR(255) field, how do you add config in that space? */
  '{
    "special":{
      "dbtable":"#__cajobboard_job_postings",
      "key":"job_posting_id",
      "type":"JobPosting",
      "prefix":"JobPostingsTable",
      "config":"array()"
    },
    "common":{
      "dbtable":"#__ucm_content",
      "key":"ucm_id",
      "type":"Corecontent",
      "prefix":"JTable",
      "config":"array()"}
    }',
  /* rules */
  '',
  /* field_mappings */
  '{
    "common":{
        "core_content_item_id":"job_posting_id",
        "core_title":"title",
        "core_state":"enabled",
        "core_alias":"slug",
        "core_created_time":"created_on",
        "core_modified_time":"modified_on",
        "core_body":"description",
        "core_hits":"hits",
        "core_publish_up":"publish_up",
        "core_publish_down":"publish_down",
        "core_access":"access",
        "core_params":"params",
        "core_featured":"featured",
        "core_metadata":"metadata",
        "core_metakey":"metakey",
        "core_metadesc":"metadesc",
        "core_language":"language",
        "core_images":"null",
        "core_urls":"null",
        "core_version":"version",
        "core_ordering":"null",
        "core_catid":"occupational_category",
        "core_xreference":"xreference",
        "asset_id":"asset_id"
    },
    "special":{
        "disambiguating_description":"disambiguating_description",
        "education_requirements":"education_requirementst",
        "experience_requirements":"experience_requirements",
        "incentive_compensation":"incentive_compensation",
        "job_benefits":"job_benefits",
        "qualifications":"qualifications",
        "responsibilities":"responsibilities",
        "skills":"skills",
        "special_commitments":"special_commitments",
        "work_hours":"work_hours",
        "job_location":"job_location",
        "relevant_occupation_name":"relevant_occupation_name",
        "base_salary__max_value":"base_salary__max_value",
        "base_salary__value":"base_salary__value",
        "base_salary__min_value":"base_salary__min_value",
        "base_salary__currency":"base_salary__currency",
        "base_salary__duration":"base_salary__duration",
        "hiring_organization":"hiring_organization",
        "employment_type":"employment_type"
    }
  }',
  /* router */
  '',
  /* content_history_options */
  '{
    "formFile":"administrator\\/components\\/com_cajobboard\\/Form\\/common.xml",
    "hideFields":[
      "asset_id",
      "version",
      "locked_by",
      "locked_on"
    ],
    "ignoreChanges":[
      "hits",
      "modified_by",
      "modified",
      "locked_by",
      "locked_on"
    ],
    "convertToInt":[
      "publish_up",
      "publish_down"
    ],
    "displayLookup":[
      {
        "sourceColumn":"created_by",
        "targetTable":"#__users",
        "targetColumn":"id",
        "displayColumn":"name"
      },
      {
        "sourceColumn":"access",
        "targetTable":"#__viewlevels",
        "targetColumn":"id",
        "displayColumn":"title"
      },
      {
        "sourceColumn":"modified_by",
        "targetTable":"#__users",
        "targetColumn":"id",
        "displayColumn":"name"
      }
    ]
  }'
);
