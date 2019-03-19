/**
 * Data model for Question and Answer Pages
 *
 * QAPage type is a subtype of WebPage. Question and Answer entities point to a QAPage.
 *
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
CREATE TABLE IF NOT EXISTS `#__cajobboard_qapage_categories` (
  qapage_category_id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key',

  /* SCHEMA: Thing */
  `name` CHAR(96) NOT NULL COMMENT 'Name of this group of question-and-answer pages.',
  description TEXT NOT NULL COMMENT 'Occupational category group description',

  /* SQL DDL */
  PRIMARY KEY (qapage_category_id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;

 /**
 * QAPage Question and Answer Web Page SQL
 *
 * Uses schema https://schema.org/QAPage
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_qapages` (
  qapage_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key', /* FK to #__cajobboard_ucm(id) */

  /* FOF "magic" fields */
  asset_id	INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Enable record-level access control.', /* FK to the #__assets */
  access INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'The Joomla! view access level.',
  enabled TINYINT NOT NULL DEFAULT '0' COMMENT 'Publish status: -2 for trashed and marked for deletion, -1 for archived, 0 for unpublished, and 1 for published.',
  created_on DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp of record creation, auto-filled by save().',
  created_by INT NOT NULL DEFAULT '0' COMMENT 'User ID who created the record, auto-filled by save().',
  modified_on DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp of record modification, auto-filled by save(), touch().',
  modified_by INT DEFAULT '0' COMMENT 'User ID who modified the record, auto-filled by save(), touch().',
  locked_on DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Timestamp of record locking, auto-filled by lock(), unlock().',
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
  note VARCHAR(255) COMMENT 'A note to save with this question-and-answer page in the back-end interface.',

  /* SCHEMA: Thing */
  name VARCHAR(255) COMMENT 'A name for this question and answer page.',
  description TEXT COMMENT 'A long description of this question and answer page.',
  main_entity_of_page BIGINT UNSIGNED COMMENT 'FK to question this page is about',

  /* SCHEMA: CreativeWork */
  about BIGINT UNSIGNED COMMENT 'The organization this question-and-answer page is about. FK to #__cajobboard_organizations(organization_id)',

  /* SCHEMA: QAPage */
  specialty BIGINT UNSIGNED COMMENT 'A category to which this question and answer page\'s content applies. FK to #__cajobboard_qapage_categories(qapage_category_id)',

  /* SQL DDL */
  PRIMARY KEY (qapage_id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;

 /**
 * Initial question-and-answer page categories
 *
 * @TODO: Should allow recursive categories if QA Page is extended outside of job board component
 *        context, so that categories can be grouped by component or other criteria
 */
INSERT INTO `#__cajobboard_qapage_categories` (qapage_category_id, `name`, description) VALUES
  ('1', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_BENEFITS', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_BENEFITS_DESCRIPTION'),
  ('2', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_CAREER_DEVELOPMENT', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_CAREER_DEVELOPMENT_DESCRIPTION'),
  ('3', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_COMMUNICATION', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_COMMUNICATION_DESCRIPTION'),
  ('4', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_COMPENSATION', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_COMPENSATION_DESCRIPTION'),
  ('5', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_CULTURE', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_CULTURE_DESCRIPTION'),
  ('6', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_DIVERSITY', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_DIVERSITY_DESCRIPTION'),
  ('7', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_ENVIRONMENTAL_FRIENDLINESS', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_ENVIRONMENTAL_FRIENDLINESS_DESCRIPTION'),
  ('8', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_HANDICAPPED_ACCESSIBILITY', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_HANDICAPPED_ACCESSIBILITY_DESCRIPTION'),
  ('9', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_IMPROVEMENT', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_IMPROVEMENT_DESCRIPTION'),
  ('10', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_JOB_SECURITY', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_JOB_SECURITY_DESCRIPTION'),
  ('11', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_MANAGEMENT', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_MANAGEMENT_DESCRIPTION'),
  ('12', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_PERKS', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_PERKS_DESCRIPTION'),
  ('13', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_TEAMWORK', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_TEAMWORK_DESCRIPTION'),
  ('14', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_WORK_ENVIRONMENT', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_WORK_ENVIRONMENT_DESCRIPTION'),
  ('15', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_WORK_LIFE_BALANCE', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_WORK_LIFE_BALANCE_DESCRIPTION'),
  ('16', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_WORKPLACE_SAFETY', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_WORKPLACE_SAFETY_DESCRIPTION'),
  ('17', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_OTHER', 'COM_CAJOBBOARD_QAPAGE_CATEGORY_OTHER_DESCRIPTION');


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
  'Question and Answer Pages',
  /* type_alias */
  'com_cajobboard.qapages',
  /* table NOTE: No spaces, Joomla! stupidly has this set as a VARCHAR(255) field, how do you add config in that space? */
  '{
    "special":{
      "dbtable":"#__cajobboard_qapages",
      "key":"qapage_id",
      "type":"QAPage",
      "prefix":"QAPagesTable",
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
        "name":"name",
        "description":"description",
        "main_entity_of_page":"main_entity_of_page",
        "about":"about"
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
