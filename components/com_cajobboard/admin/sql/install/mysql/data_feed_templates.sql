/**
 * @package   Calligraphic Job Board
 * @version   September 28, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

/**
 * Email Message Templates data model SQL
 *
 * Uses schema https://schema.org/EmailMessage
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_data_feed_templates` (
  data_feed_template_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key', /* FK to #__cajobboard_ucm(id) */
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
  version INT UNSIGNED NOT NULL DEFAULT '1' COMMENT 'Version of this item.',
  params TEXT COMMENT 'JSON encoded parameters for the content item.',
  language CHAR(7) NOT NULL DEFAULT '*' COMMENT 'The language code for the article or * for all languages.',
  cat_id INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Category ID for this content item.',
  note VARCHAR(255) COMMENT 'A note to save with this answer in the back-end interface.',

  /* SCHEMA: Thing */
  name VARCHAR(255) COMMENT 'Machine name for this e-mail template. Aliased by title property.',
  description TEXT COMMENT 'Description of this e-mail template.',
  description__intro VARCHAR(280) COMMENT 'Short description of the item, used for the text shown on browse views.',

  /* SCHEMA: none (internal use only) */
  subject TEXT COMMENT 'Text template with shortcodes for the subject field of the e-mail.',
  body TEXT COMMENT 'HTML template with shortcodes for the body field of the e-mail.',

  /* SQL DDL */
  PRIMARY KEY (data_feed_template_id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;


REPLACE INTO `#__cajobboard_data_feed_templates` (`data_feed_template_id`, `name`, `slug`, `description`, `subject`, `body`) VALUES
	(1, 'analytics_report', 'analytics-report', 'Analytics reports template', 'Your [SITENAME] report for [TIMEPERIOD]', '<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">\r\n<div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">\r\n<p>Hello [FIRSTNAME],</p>\r\n<p>Attached is your <span style=\"line-height: 1.3em;\">[TIMEPERIOD] </span><span style=\"line-height: 1.3em;\">report</span></p>\r\n</div>\r\n<p style=\"font-size: x-small; color: #667;\">You are receiving this automatic email message because you have set up automatic report generation on <em>[SITENAME]</em>. <span style=\"line-height: 1.3em;\">Do not reply to this email, it is sent from an unmonitored email address.</span></p>\r\n</div>'),
  (2, 'new_comment_posted_notification', 'new-comment-posted-notification', 'New comment posted notification template', 'subject', 'body'),
  (3, 'new_question_posted_notification', 'new-question-posted-notification', 'New question posted notification template', 'subject', 'body'),
  (4, 'new_answer_posted_notification', 'new-answer-posted-notification', 'New answer posted notification template', 'subject', 'body'),
  (5, 'new_employer_review_received_notification', 'new-employer-review-received-notification', 'New employer review posted notification template', 'subject', 'body'),
  (6, 'job_post_alert', 'job-post-alert', 'Job posting alert template', 'subject', 'body'),
  (7, 'resume_alert', 'resume-alert', 'Resume alert template', 'subject', 'body'),
  (8, 'new_message_received_notification', 'new-message-received-notification', 'New user message notification template', 'subject', 'body'),
  (9, 'fair_credit_reporting_act_notice', 'fair-credit-reporting-act-notice', 'FCRA notice sent when credit check is done', 'subject', 'body'),
  (10, 'new_application_received_notification', 'new-application-received-notification', 'New application received for a job posting template', 'subject', 'body'),
  (11, 'gdpr_notice', 'gdpr-notice', 'GDPR user data removal notification template', 'subject', 'body'),
  (12, 'complete_job_seeker_profile_request', 'complete-job-seeker-profile-request', 'Reminders to complete a job seeker profile', 'subject', 'body'),
  (13, 'connectors_job_post_alert', 'connectors-job-post-alert', 'Connectors job posting alert template', 'subject', 'body'),
  (14, 'recommendation_request', 'recommendation-request', 'Recommendation request template', 'subject', 'body'),
  (15, 'recommendation_follow_up', 'recommendation-follow-up', 'Recommendation follow up template', 'subject', 'body'),
  (16, 'reference_request', 'reference-request', 'Reference request template', 'subject', 'body'),
  (17, 'reference_follow_up', 'reference-follow-up', 'Reference follow up template', 'subject', 'body'),
  (18, 'ats_scheduling_reminder', 'ats-scheduling-reminder', 'ATS scheduling reminder template', 'subject', 'body'),
  (19, 'ats_workflow_notice', 'ats-workflow-notice', 'ATS workflow notices template, e.g. when a scorecard is marked complete for a candidate, a background check completed, a reference received for a candidate', 'subject', 'body');


/*
 * Create content types for email message templates, mapping fields to the UCM standard fields for history feature
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
 * Recommendations content type for history component
 */
INSERT INTO `#__content_types` (`type_id`, `type_title`, `type_alias`, `table`, `rules`, `field_mappings`, `router`, `content_history_options`)
VALUES(
  /* type_id */
  null,
  /* type_title */
  'DataFeedTemplates',
  /* type_alias */
  'com_cajobboard.data_feed_templates',
  /* table NOTE: No spaces, Joomla! stupidly has this set as a VARCHAR(255) field, how do you add config in that space? */
  '{
    "special":{
      "dbtable":"#__cajobboard_data_feed_templates",
      "key":"data_feed_template_id",
      "type":"data_feed_templates",
      "prefix":"DataFeedTemplatesTable",
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
      "asset_id":"asset_id",
      "core_access":"access",
      "core_alias":"slug",
      "core_body":"description",
      "core_catid":"cat_id",
      "core_content_item_id":"data_feed_template_id",
      "core_created_time":"created_on",
      "core_images":"null",
      "core_language":"language",
      "core_modified_time":"modified_on",
      "core_ordering":"null",
      "core_params":"params",
      "core_publish_down":"publish_down",
      "core_publish_up":"publish_up",
      "core_state":"enabled",
      "core_title":"name",
      "core_urls":"null",
      "core_version":"version"
    },
    "special":{
      "body":"body",
      "description__intro":"description__intro",
      "image":"image",
      "note":"note",
      "subject":"subject"
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
