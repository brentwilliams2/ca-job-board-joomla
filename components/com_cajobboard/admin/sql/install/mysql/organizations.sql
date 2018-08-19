/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

 /**
 * Organization Type table
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_organization_types` (
  /* UCM (unified content model) properties for internal record metadata */
  organization_type_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key',
  /* SCHEMA: Organizaton (OrganizationType) -> ItemList */
  itemListElement TEXT COMMENT 'The type of organization, e.g. Employer, Recruiter, etc.',
  itemListOrderType INT COMMENT 'The order this item should appear in the list',
  /* SCHEMA: Thing */
  description TEXT COMMENT 'A description of the type of organization',
  url VARCHAR(2083) NOT NULL COMMENT 'Link to schema for organization type, e.g. wikipedia page on Employer.',
  PRIMARY KEY (organization_type_id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;

 /**
 * Organization table
 *
 * Uses schema https://schema.org/Organization
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_organizations` (
  /* UCM (unified content model) properties for internal record metadata */
  organization_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key',
  slug CHAR(255) NOT NULL COMMENT 'alias for SEF URL',

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

  /* SCHEMA: Organization */
  legal_name VARCHAR(255) COMMENT 'The official name of the employer.',
  email VARCHAR(320) COMMENT 'RFC 3696 Email address.',
  telephone TEXT COMMENT 'The E.164 PSTN telephone number.',
  fax_number	VARCHAR(24) COMMENT 'The E.164 PSTN fax number.',
  number_of_employees VARCHAR(16)	COMMENT 'The number of employees in an organization e.g. business.', /* Can also be a QuantitativeValue, which has properties like value, minValue, maxValue, unitCode for unit of measurement */
  location BIGINT UNSIGNED COMMENT 'Where the organization is located', /* FK to Places */
  logo BIGINT UNSIGNED COMMENT 'An associated logo.',  /* FK to ImageObjects table */
  /* @TODO: contact_point ContactPoint COMMENT 'A contact point for a person or organization.' */
  diversity_policy BIGINT UNSIGNED COMMENT 'Statement on diversity policy of the employer.', /* FK to diversity_policies table */
  aggregate_rating BIGINT UNSIGNED COMMENT 'The overall rating, based on a collection of reviews or ratings, of the item.', /* FK to employer_reviews table */
  member_of BIGINT UNSIGNED COMMENT 'An Organization (or ProgramMembership) to which this Person or Organization belongs.', /* FK to organizations_organizations join table */
  parent_organization BIGINT UNSIGNED COMMENT 'The larger organization that this organization is a subOrganization of, if any.', /* FK to organizations table */

  /* SCHEMA: Thing */
  name CHAR(255) COMMENT 'The name of this organization.',
  disambiguating_description TEXT COMMENT 'A short description of the employer, for example to use on listing pages.',
  description TEXT COMMENT 'A description of the item.',
  url VARCHAR(2083) COMMENT 'URL of employer\'s website.',
  image BIGINT UNSIGNED COMMENT	'Images of the employer.', /* FK to images table */

  /* SCHEMA: Thing(additionalType) -> extended types in private namespace (default) */
  organization_type BIGINT UNSIGNED COMMENT 'The type of organization e.g. Employer, Recruiter, etc.', /* FK to #__cajobboard_organization_type */

  PRIMARY KEY (organization_id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;

 /**
 * Organization - Employee join table
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_organizations_employees` (
  id BIGINT UNSIGNED NOT NULL COMMENT 'Surrogate primary key',
  organization_id BIGINT UNSIGNED NOT NULL,
  employee_id BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;

 /**
 * Organizations - ImageObjects join table
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_organizations_images` (
  id BIGINT UNSIGNED NOT NULL COMMENT 'Surrogate primary key',
  image BIGINT UNSIGNED NOT NULL COMMENT 'FK to #__organizations',
  image_object_id BIGINT UNSIGNED NOT NULL COMMENT 'FK to #__cajobboard_image_objects',
  PRIMARY KEY (id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;

 /**
 * Organization - Organization join table
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_organizations_organizations` (
  id BIGINT UNSIGNED NOT NULL COMMENT 'Surrogate primary key',
  organization_id BIGINT UNSIGNED NOT NULL,
  member_of_organization_id BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;

/**
 * Initial organization types
 */
INSERT INTO `#__cajobboard_organization_types` (itemListElement, itemListOrderType, description, url) VALUES
  ('COM_CAJOBBOARD_ORGANIZATION_TYPE_SOLE_PROPRIETORSHIP', 1, 'COM_CAJOBBOARD_ORGANIZATION_TYPE_SOLE_PROPRIETORSHIP_DESC', 'https://en.wikipedia.org/wiki/Sole_proprietorship'),
  ('COM_CAJOBBOARD_ORGANIZATION_TYPE_PARTNERSHIP', 2, 'COM_CAJOBBOARD_ORGANIZATION_TYPE_PARTNERSHIP_DESC', 'https://en.wikipedia.org/wiki/Partnership'),
  ('COM_CAJOBBOARD_ORGANIZATION_TYPE_LIMITED_LIABILITY_COMPANY', 3, 'COM_CAJOBBOARD_ORGANIZATION_TYPE_LIMITED_LIABILITY_COMPANY_DESC', 'https://en.wikipedia.org/wiki/Limited_liability_company'),
  ('COM_CAJOBBOARD_ORGANIZATION_TYPE_CORPORATION', 4, 'COM_CAJOBBOARD_ORGANIZATION_TYPE_CORPORATION_DESC', 'https://en.wikipedia.org/wiki/Corporation'),
  ('COM_CAJOBBOARD_ORGANIZATION_TYPE_EDUCATIONAL_INSTITUTION', 5,'COM_CAJOBBOARD_ORGANIZATION_TYPE_EDUCATIONAL_INSTITUTION_DESC', 'https://en.wikipedia.org/wiki/Educational_institution'),
  ('COM_CAJOBBOARD_ORGANIZATION_TYPE_GOVERNMENT', 6, 'COM_CAJOBBOARD_ORGANIZATION_TYPE_GOVERNMENT_DESC', 'https://en.wikipedia.org/wiki/Government'),
  ('COM_CAJOBBOARD_ORGANIZATION_TYPE_NON_PROFIT_ORGANIZATION', 7, 'COM_CAJOBBOARD_ORGANIZATION_TYPE_NON_PROFIT_ORGANIZATION_DESC', 'https://en.wikipedia.org/wiki/Nonprofit_organization'),
  ('COM_CAJOBBOARD_ORGANIZATION_TYPE_FRANCHISE', 8, 'COM_CAJOBBOARD_ORGANIZATION_TYPE_FRANCHISE_DESC', 'https://en.wikipedia.org/wiki/Franchising'),
  ('COM_CAJOBBOARD_ORGANIZATION_TYPE_OTHER', 9, 'COM_CAJOBBOARD_ORGANIZATION_TYPE_OTHER_DESC', 'https://en.wiktionary.org/wiki/other');


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

/* `table` field in Joomla! is VARCHAR(255), and too narrow for this entry. https://github.com/joomla/joomla-cms/issues/21395 */
ALTER TABLE `#__content_types` MODIFY `table` VARCHAR(2048);

/*
 * Job Postings content type for history component
 */
INSERT INTO `#__content_types` (`type_id`, `type_title`, `type_alias`, `table`, `rules`, `field_mappings`, `router`, `content_history_options`)
VALUES(
  /* type_id */
  null,
  /* type_title */
  'Organizations',
  /* type_alias */
  'com_cajobboard.organizations',
  /* table NOTE: No spaces, Joomla! stupidly has this set as a VARCHAR(255) field, how do you add config in that space? */
  '{
    "special":{
      "dbtable":"#__cajobboard_organizations",
      "key":"organization_id",
      "type":"Organization",
      "prefix":"OrganizationsTable",
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
        "core_title":"name",
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
        "core_images":"logo",
        "core_urls":"url",
        "core_version":"version",
        "core_ordering":"null",
        "core_catid":"organization_type",
        "core_xreference":"xreference",
        "asset_id":"asset_id"
    },
    "special":{
        "legal_name": "legal_name",
        "email": "email",
        "telephone": "telephone",
        "fax_number": "fax_number",
        "number_of_employees": "number_of_employees",
        "location": "location",
        "diversity_policy": "diversity_policy",
        "aggregate_rating": "aggregate_rating",
        "member_of": "member_of",
        "parent_organization": "parent_organization",
        "disambiguating_description": "disambiguating_description",
        "image": "image"
    }
  }',
  /* router */
  '',
  /* content_history_options */
  '{
    "formFile":"administrator\\/components\\/com_cajobboard\\/Form\\/organization.xml",
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
