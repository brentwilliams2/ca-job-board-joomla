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

  /* SCHEMA: Thing */
  name VARCHAR(255) COMMENT 'A name for this question and answer page.',
  description TEXT COMMENT 'A long description of this question and answer page.',

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
 * Question SQL
 *
 * Uses schema https://schema.org/Question
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_questions` (
  question_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key', /* should be FK to #__cajobboard_ucm(id) */
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

  /* SCHEMA: Thing */
  name VARCHAR(255) COMMENT 'A title to use for the question.',
  description TEXT COMMENT 'Text of the question.',

  /* SCHEMA: CreativeWork */
  is_part_of BIGINT UNSIGNED COMMENT 'This property points to a QAPage entity associated with this question. FK to #__cajobboard_qapage(qapage_id)',
  publisher BIGINT UNSIGNED COMMENT 'The company that wrote this answer. FK to #__organizations(organization)id).',
  `text` TEXT COMMENT 'The actual text of the question itself.',

  /* SCHEMA: Question */
  accepted_answer BIGINT UNSIGNED COMMENT 'Use acceptedAnswer for the best answer to a question.  FK to #__cajobboard_answers(answer_id)',
  upvote_count INT COMMENT 'Upvote count for this item.',
  downvote_count INT COMMENT 'Downvote count for this item.',

  /* SQL DDL */
  PRIMARY KEY (question_id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;


/**
 * Answer SQL
 *
 * Uses schema https://schema.org/Answer
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_answers` (
  answer_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key', /* FK to #__cajobboard_ucm(id) */
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

  /* SCHEMA: Thing */
  name VARCHAR(255) COMMENT 'A title to use for the answer.',
  description TEXT COMMENT 'Text of the answer.',

  /* SCHEMA: CreativeWork */
  is_part_of BIGINT UNSIGNED COMMENT 'This property points to a QAPage entity associated with this answer. FK to #__cajobboard_qapage(qapage_id)',
  publisher BIGINT UNSIGNED COMMENT 'The company that wrote this answer. FK to #__organizations(organization)id).',
  `text` TEXT COMMENT 'The actual text of the answer itself.',

  /* SCHEMA: Answer */
  parent_item BIGINT UNSIGNED COMMENT 'The question this answer is intended for. FK to #__cajobboard_questionss(question_id)',
  upvote_count INT COMMENT 'Upvote count for this item.',
  downvote_count INT COMMENT 'Downvote count for this item.',

  /* SQL DDL */
  PRIMARY KEY (answer_id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;

/**
 * Initial question-and-answer page categories
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
