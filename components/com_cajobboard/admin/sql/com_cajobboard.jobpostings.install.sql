/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * DEPENDS ON: #__cajobboard_ucm, #__cajobboard_places, #__cajobboard_organizations
 */

/**
 * Occupational category groups table
 *
 * Used to create general groups of job categories, e.g. "Office Staff",
 * "Leasing and Sales"
 */
CREATE TABLE IF NOT EXISTS '#__cajobboard_job_occupational_category_group' (
  /* SCHEMA: Thing */
  'description' CHAR(255) NOT NULL COMMENT 'occupational category group description',
  'url' VARCHAR(2083) NOT NULL COMMENT 'link to schema for occupational category, e.g. wikipedia page on Full Time',
  /* SCHEMA: https://calligraphic.design/schema/OccupationalCategoryBLS */
  'group' CHAR(50) NOT NULL COMMENT 'group this occupational category should be shown under e.g. office staff',
  /* SQL DDL */
  PRIMARY KEY ('group')
) ENGINE=innoDB DEFAULT CHARSET=utf8;

/**
 * BLS O*NET-SOC taxonomy table for occupational categories
 *
 * see http://www.onetcenter.org/taxonomy.html
 */
CREATE TABLE IF NOT EXISTS '#__cajobboard_job_occupational_category' (
  /* UCM (unified content model) properties for internal record metadata */
  'ordering' SMALLINT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'order this job category should show in the group',
  /* SCHEMA: https://calligraphic.design/schema/OccupationalCategoryBLS */
  'title' CHAR(255) NOT NULL COMMENT 'occupational category title',
 	'code' CHAR(10) NOT NULL DEFAULT '0' COMMENT 'BLS code specifying this job category',
  'group' CHAR(50) NOT NULL COMMENT 'group this occupational category should be shown under e.g. office staff', /* FK to #__cajobboard_job_occupational_category_group(group) */
  /* SQL DDL */
  PRIMARY KEY ('title'(10)), /* the (10) limits indexing to first ten characters in PK column */
  INDEX job_category_group_index (group),
) ENGINE=innoDB DEFAULT CHARSET=utf8;

/**
 * Employment type table
 *
 * Used to enumerate types of employment, e.g. "full-time", "part-time",
 * "contract", "temporary", "seasonal", "internship"
 */
CREATE TABLE IF NOT EXISTS '#__cajobboard_job_employment_type' (
  /* SCHEMA: Thing */
  'name' CHAR(20) NOT NULL COMMENT 'Type of employment (e.g. full-time, part-time, contract, temporary, seasonal, internship)',
  'description' CHAR(255) NOT NULL COMMENT 'details on type of employment',
  'url' VARCHAR(2083) NOT NULL COMMENT 'link to schema for type of employment, e.g. wikipedia page on Full Time',
  /* SQL DDL */
  PRIMARY KEY ('name')
) ENGINE=innoDB DEFAULT CHARSET=utf8;

/**
 * Job Postings table
 *
 * Uses schema https://schema.org/JobPosting
 */
CREATE TABLE IF NOT EXISTS '#__cajobboard_job_postings' (
  /* UCM (unified content model) properties for internal record metadata */
  'job_posting_id' BIGINT UNSIGNED NOT NULL,  /* FK to #__cajobboard_ucm(id) */
  'slug' CHAR(50) NOT NULL COMMENT 'alias for SEF URL',
  /* FOF "magic" fields */
  'asset_id'	INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table for access control purposes',
  'access' INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'The Joomla! view access level',
  'enabled' TINYINT(3) NOT NULL DEFAULT '0' COMMENT 'Publish status: -2 for trashed and marked for deletion, -1 for archived, 0 for unpublished, and 1 for published',
  'ordering' BIGINT(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'order this record should appear in for sorting',
  'created_on' DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Timestamp of record creation, auto-filled by save()',
  'created_by' INT(11) NOT NULL DEFAULT '0' COMMENT 'user ID who created the record, auto-filled by save()',
  'modified_on' DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Timestamp of record modification, auto-filled by save(), touch()',
  'modified_by' INT(11) NOT NULL DEFAULT '0' COMMENT 'user ID who modified the record, auto-filled by save(), touch()',
  'locked_on' DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'timestamp of record locking, auto-filled by lock(), unlock()',
  'locked_by' INT(11) NOT NULL DEFAULT '0' COMMENT 'user ID who locked the record, auto-filled by lock(), unlock()',
  /* Joomla UCM fields, used by Joomla!s UCM when using the FOF ContentHistory behaviour */
  'publish_up' DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'date and time to change the state to published, schema.org alias is datePosted',
  'publish_down' DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'date and time to change the state to unpublished',
  'version' INT(10) UNSIGNED NOT NULL DEFAULT '1' COMMENT '',
  'ordering' INT(11) NOT NULL DEFAULT '0' COMMENT '',
  'metadata' JSON COMMENT 'JSON encoded metadata field for this item',
  'metakey' MEDIUMTEXT NOT NULL COMMENT 'meta keywords for this item',
  'metadesc' MEDIUMTEXT NOT NULL COMMENT '',
  'xreference' VARCHAR(50) NOT NULL COMMENT 'A reference to enable linkages to external data sets, used to output a meta tag like FB open graph.',
  'params' MEDIUMTEXT NOT NULL COMMENT 'JSON encoded parameters for the content item.',
  'language' CHAR(7) NOT NULL COMMENT 'The language code for the article or * for all languages.',
  'cat_id' INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Category ID for this content item.',
  'hits' INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Number of hits the content item has received on the site.',
  'featured' TINYINT(4) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Whether this content item is featured or not.',
  /* SCHEMA: JobPosting */
  'title' CHAR(255) COMMENT 'The title of the job posting',
  'disambiguating_description' TEXT COMMENT 'Short description of the job, used in cajobboard on job posting list pages, etc.',
  'description' TEXT COMMENT 'Long description of the job posting',
  'education_requirements' TEXT COMMENT 'Educational background needed for the position or Occupation',
  'experience_requirements' TEXT COMMENT 'Description of skills and experience needed for the position or Occupation',
  'incentive_compensation' TEXT COMMENT 'Description of bonus and commission compensation aspects of the job. Supersedes incentives',
  'job_benefits' TEXT COMMENT 'Description of benefits associated with the job. Supersedes benefits',
  'qualifications' TEXT COMMENT 'Specific qualifications required for this role or Occupation',
  'responsibilities' TEXT COMMENT 'Responsibilities associated with this role or Occupation',
  'skills' TEXT COMMENT 'Skills required to fulfill this role',
  'special_commitments' TEXT COMMENT 'Any special commitments associated with this job posting. Valid entries include VeteranCommit, MilitarySpouseCommit, etc',
  'work_hours' TEXT COMMENT 'The typical working hours for this job (e.g. 1st shift, night shift, 8am-5pm)', /* OpeningHoursSpecification has a schema very close to something workHours could use */
  'job_location' BIGINT UNSIGNED 'A (typically single) geographic location associated with the job position', /* FK to #__cajobboard_places(place_id) */
  /* SCHEMA: JobPosting (relevantOccupation) -> Occupation (name) */
  'relevantOccupation_name' CHAR(255) NOT NULL COMMENT 'The job title',
  /* SCHEMA: JobPosting (baseSalary) -> MonetaryAmount */
  'base_salary__maxValue' INT UNSIGNED COMMENT 'The maximum salary of the job or of an employee in an EmployeeRole',
  'base_salary__value' INT UNSIGNED COMMENT 'The base salary of the job or of an employee in an EmployeeRole',
  'base_salary__minValue' INT UNSIGNED COMMENT 'The minimum salary of the job or of an employee in an EmployeeRole',
  'base_salary__currency' CHAR(6) COMMENT 'Use ISO 4217 currency format e.g. USD',
  /* SCHEMA: JobPosting (baseSalary) -> MonetaryAmount (additionalType) -> Duration */
  'base_salary__duration' CHAR(32) COMMENT 'use ISO 8601 duration format, e.g. P2W for bi-weekly',
  'hiring_organization' BIGINT UNSIGNED 'Organization offering the job position', /* FK to #__cajobboard_organizations(organization_id) */
  /* SCHEMA: https://calligraphic.design/schema/EmploymentType */
  'employment_type' CHAR(20) NOT NULL COMMENT 'Type of employment (e.g. full-time, part-time, contract, temporary, seasonal, internship)', /* FK to #__cajobboard_job_employment_type(name) */
  /* SCHEMA: https://calligraphic.design/schema/OccupationalCategoryBLS */
  'occupational_category' CHAR(255) NOT NULL COMMENT 'The occupation of the job posting. Uses BLS O*NET-SOC taxonomy', /* FK to #__cajobboard_job_occupational_category(title) */
  /* SQL DDL */
  PRIMARY KEY ('job_posting_id'),
  INDEX jobposting_slug_index (slug),
  INDEX occupational_category_index (occupational_category),
  INDEX job_location_index (job_location),
  INDEX hiring_organization_index (hiring_organization),
) ENGINE=innoDB DEFAULT CHARSET=utf8;

/**
 * Initial employment types
 */
INSERT INTO '#__cajobboard_job_employment_type' ('name', 'description', 'url') VALUES
  ('full-time', 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_DESCRIPTION_FULL_TIME', 'https://en.wikipedia.org/wiki/Full-time'),
  ('part-time', 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_DESCRIPTION_PART_TIME', 'https://en.wikipedia.org/wiki/Part-time_contract'),
  ('flex-time', 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_DESCRIPTION_FLEX-TIME', 'https://en.wikipedia.org/wiki/Flextime'),
  ('fixed-term contract', 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_DESCRIPTION_CONTRACT', 'https://en.wikipedia.org/wiki/Fixed-term_employment_contract'),
  ('temporary', 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_DESCRIPTION_TEMPORARY', 'https://en.wikipedia.org/wiki/Temporary_work'),
  ('casual', 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_DESCRIPTION_CASUAL', 'https://en.wikipedia.org/wiki/Casual_employment_(contract)'),
  ('flextime', 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_DESCRIPTION_FLEXTIME', 'https://en.wikipedia.org/wiki/Flextime'),
  ('internship', 'COM_CAJOBBOARD_EMPLOYMENT_TYPE_DESCRIPTION_INTERNSHIP', 'https://en.wikipedia.org/wiki/Internship');

/**
 * Initial occupational groups
 */
INSERT INTO '#__cajobboard_job_occupational_group' ('group', 'description', 'url') VALUES
  ('Construction', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_CONSTRUCTION', 'https://en.wikipedia.org/wiki/Construction'),
  ('Facilities and Grounds', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_FACILITIES', 'https://en.wikipedia.org/wiki/Facility_management'),
  ('Finance', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_FINANCE', 'https://en.wikipedia.org/wiki/Accounting'),
  ('Human Resources', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_HR', 'https://en.wikipedia.org/wiki/Human_resource_management'),
  ('Information Technology', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_IT', 'https://en.wikipedia.org/wiki/Information_technology'),
  ('Leasing and Sales', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_LEASING', 'https://en.wikipedia.org/wiki/Letting_agent'),
  ('Marketing', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_MARKETING', 'https://en.wikipedia.org/wiki/Marketing'),
  ('Office', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_OFFICE', 'https://en.wikipedia.org/wiki/Office_administration'),
  ('Senior Management', 'COM_CAJOBBOARD_JOB_OCCUPATIONAL_GROUP_MGMT', 'https://en.wikipedia.org/wiki/Management');

/**
 * Initial occupational categories
 */
INSERT INTO '#__cajobboard_job_occupational_category' ('code', 'order', 'group', 'title') VALUES
  ('11-1021.00', 1, 'Senior Management', 'General and Operations Managers'),
  ('11-9141.00', 2, 'Senior Management', 'Property and Community Managers'),
  ('11-9199.01', 3, 'Senior Management', 'Regulatory Affairs Managers'),
  ('11-9199.00', 4, 'Senior Management', 'Other Managers'),
  ('11-2022.00', 1, 'Leasing and Sales', 'Leasing and Sales Managers and Executives'),
  ('41-3099.00', 2, 'Leasing and Sales', 'Leasing and Sales Agents'),
  ('11-2021.00', 1, 'Marketing', 'Marketing Managers and Executives'),
  ('13-1161.00', 2, 'Marketing', 'Marketing Specialists'),
  ('11-3031.00', 1, 'Finance', 'Financial Managers and Executives'),
  ('13-2011.01', 2, 'Finance', 'Accountants'),
  ('43-3031.00', 3, 'Finance', 'Bookkeepers and Accounting Clerks'),
  ('11-3021.00', 1, 'Information Technology', 'Information Technology Managers and Executives'),
  ('15-1131.00', 2, 'Information Technology', 'Computer Programmers'),
  ('15-1199.03', 3, 'Information Technology', 'Web Administrators'),
  ('11-3121.00', 1, 'Human Resources', 'Human Resources Managers and Executives'),
  ('11-3131.00', 2, 'Human Resources', 'Training and Development Managers'),
  ('13-1071.00', 3, 'Human Resources', 'Human Resources Specialists'),
  ('11-3011.00', 1, 'Office', 'Office Managers and Executives'),
  ('43-6014.00', 2, 'Office', 'Secretaries and Administrative Assistants'),
  ('43-4171.00', 3, 'Office', 'Receptionists'),
  ('43-4051.00', 4, 'Office', 'Customer Service Representatives'),
  ('43-4071.00', 5, 'Office', 'File Clerks'),
  ('13-1041.00', 6, 'Office', 'Compliance Officers'),
  ('13-1041.03', 7, 'Office', 'Equal Opportunity Representatives and Officers'),
  ('37-1011.00', 1, 'Facilities and Grounds', 'Housekeeping and Janitorial Supervisors'),
  ('37-2011.00', 2, 'Facilities and Grounds', 'Janitors and Cleaners'),
  ('37-1012.00', 3, 'Facilities and Grounds', 'Landscaping, Lawn Service, and Groundskeeping Supervisors'),
  ('37-3011.00', 4, 'Facilities and Grounds', 'Landscaping and Groundskeeping Workers'),
  ('49-1011.00', 5, 'Facilities and Grounds', 'Maintenance Supervisors'),
  ('49-9071.00', 6, 'Facilities and Grounds', 'Maintenance Workers'),
  ('11-9199.07', 7, 'Facilities and Grounds', 'Security Managers'),
  ('33-9032.00', 8, 'Facilities and Grounds', 'Security Guards'),
  ('37-2021.00', 9, 'Facilities and Grounds', 'Pest Control Workers'),
  ('11-9021.00', 1, 'Construction', 'Project and Construction Managers'),
  ('47-1011.00', 2, 'Construction', 'Construction Supervisors'),
  ('47-4099.00', 3, 'Construction', 'Construction Workers, General'),
  ('47-2021.00', 4, 'Construction', 'Brickmasons and Blockmasons'),
  ('47-2031.00', 5, 'Construction', 'Carpenters'),
  ('47-2041.00', 6, 'Construction', 'Carpet Installers'),
  ('47-2061.00', 7, 'Construction', 'Construction Laborers'),
  ('47-2081.00', 8, 'Construction', 'Drywall and Ceiling Tile Installers'),
  ('47-2111.00', 9, 'Construction', 'Electricians'),
  ('47-2141.00', 10, 'Construction', 'Painters, Construction and Maintenance'),
  ('47-2152.02', 11, 'Construction', 'Plumbers'),
  ('47-2181.00', 12, 'Construction', 'Roofers'),
  ('47-3019.00', 13, 'Construction', 'Construction Laborers');

/*
 * Create content type for this table, mapping fields to the UCM standard fields for history feature
 */
INSERT INTO `#__content_types` (`type_id`, `type_title`, `type_alias`, `table`, `rules`, `field_mappings`, `router`, `content_history_options`)
VALUES(
  null, /* type_id */
  'Example Category', /* type_title */
  'com_cajobboard.category', /* type_alias */
  '{
    "common":{
      "dbtable":"#__ucm_content",
      "key":"ucm_id",
      "type":"Corecontent",
      "prefix":"JTable",
      "config":"array()"
    },
    "special":{
        "dbtable":"#__categories",
        "key":"id",
        "type":"Category",
        "prefix":"JTable",
        "config":"array()"
    }
  }', /* table */
  '', /* rules */
  '{
    "common":{
        "core_content_item_id":"id",
        "core_title":"title",
        "core_state":"published",
        "core_alias":"alias",
        "core_created_time":"created_time",
        "core_modified_time":"modified_time",
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
        "core_catid":"cat_id",
        "core_xreference":"xreference",
        "asset_id":"asset_id"
    },
    "special":{
        "parent_id":"parent_id",
        "lft":"lft",
        "rgt":"rgt",
        "level":"level",
        "path":"path",
        "extension":"extension",
        "note":"note"
    }
  }', /* field_mappings */
  'CajobboardHelperRoute::getCategoryRoute', /* router */
  '{
    "formFile":"administrator\\/components\\/com_categories\\/models\\/forms\\/category.xml",
    "hideFields":[
        "asset_id",
        "checked_out",
        "checked_out_time",
        "version",
        "lft",
        "rgt",
        "level",
        "path",
        "extension"
    ],
  }' /* content_history_options */
);

/*
 *
 */
INSERT INTO `#__content_types` (`type_id`, `type_title`, `type_alias`, `table`, `rules`, `field_mappings`, `router`, `content_history_options`)
VALUES(
  null, /* type_id */
  'Cajobboards', /* type_title */
  'com_cajobboard.subscription', /* type_alias */
  '{
    "special":{
        "dbtable":"#__cajobboard_example",
        "key":"id",
        "type":"Example",
        "prefix":"CajobboardTable"
    }
  }', /* table */
  '', '', '', ''
);

/*
 * Set up pop-up fields for history comparison screens in admin UI
 */
INSERT INTO `#__content_types` (`type_id`, `type_title`, `type_alias`, `table`, `rules`, `field_mappings`, `router`, `content_history_options`)
VALUES(
  null,
  'Example',
  'com_cajobboard.example',
  '{
   "special":{
      "dbtable":"#__cajobboard_example",
      "key":"id",
      "type":"Examplen",
      "prefix":"CajobboardTable"
   }
  }',
  '', '', '',
  '{
    "formFile":"administrator\\/components\\/com_joomprosubs\\/models\\/forms\\/example.xml",
    "hideFields":[
        "checked_out",
        "checked_out_time",
        "params",
        "language"
    ],
    "ignoreChanges":[
        "modified_by",
        "modified",
        "checked_out",
        "checked_out_time"
    ],
    "convertToInt":[
        "publish_up",
        "publish_down"
    ],
    "displayLookup":[
        {
          "sourceColumn":"catid",
          "targetTable":"#__categories",
          "targetColumn":"id",
          "displayColumn":"title"
        },
        {
          "sourceColumn":"group_id",
          "targetTable":"#__usergroups",
          "targetColumn":"id",
          "displayColumn":"title"
        },
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
