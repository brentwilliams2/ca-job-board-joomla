/**
 * @package   Calligraphic Job Board
 * @version   September 28, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

/**
 * Email Messages data model SQL
 *
 * Uses schema https://schema.org/EmailMessage
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_email_messages` (
  email_message_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key', /* FK to #__cajobboard_ucm(id) */
  slug CHAR(255) NOT NULL COMMENT 'alias for SEF URL',

  /* FOF "magic" fields */
  asset_id	INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Enable record-level access control.', /* FK to #__assets */
  access INT UNSIGNED NOT NULL DEFAULT '1' COMMENT 'The Joomla! view access level.',
  enabled TINYINT NOT NULL DEFAULT '1' COMMENT 'Send status: -2 for trashed and marked for deletion, -1 for mail delivery failure, 0 for not yet mailed, and 1 for mailed.',
  created_on DATETIME DEFAULT NULL COMMENT 'Timestamp of record creation, auto-filled by save().',
  created_by INT NOT NULL DEFAULT '0' COMMENT 'User ID who created the record, auto-filled by save().',
  modified_on DATETIME DEFAULT NULL COMMENT 'Timestamp of record modification, auto-filled by save(), touch().',
  modified_by INT DEFAULT '0' COMMENT 'User ID who modified the record, auto-filled by save(), touch().',

  /* Joomla UCM fields, used by Joomla!s UCM when using the FOF ContentHistory behaviour */
  publish_up DATETIME DEFAULT NULL COMMENT 'Date and time to change the state to published, schema.org alias is datePosted.',
  params TEXT COMMENT 'JSON encoded parameters for the content item.',
  language CHAR(7) NOT NULL DEFAULT '*' COMMENT 'The language code for the email message or * for all languages.',
  cat_id INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Category ID for this content item.',
  note VARCHAR(255) COMMENT 'Used by the outgoing mail processor to save any information about mail delivery status.',

  /* SCHEMA: Thing */
  description TEXT COMMENT 'Note for internal use concerning this e-mail.',
  description__intro VARCHAR(280) COMMENT 'Short description of the item.',
  name VARCHAR(255) COMMENT 'Subject field of the e-mail. Aliased by title property.',

  /* SCHEMA: CreativeWork */
  `text` TEXT COMMENT 'Body field of the e-mail.',

  /* SCHEMA: Message */
  date_sent DATETIME DEFAULT NULL COMMENT 'The date/time at which the message was sent via the MTA.',
  message_attachment__document INT UNSIGNED COMMENT 'A DigitalDocument attachment for this e-mail message, e.g. a PDF file for an analytics report.', /* FK to #__cajobboard_digital_documents */
  recipient__additional_name VARCHAR(255) COMMENT 'An additional name for  of the recipient, can be used for a middle name.',
  recipient__email VARCHAR(2083) COMMENT 'Email address of the recipient.',
  recipient__family_name VARCHAR(255) COMMENT 'Family name of the recipient. In the U.S., the last name of an Person.',
  recipient__given_name VARCHAR(255) COMMENT 'Given name of the recipient. In the U.S., the first name of a Person.',
  recipient__honorific_prefix VARCHAR(255) COMMENT 'An honorific prefix preceding the recipient\'s name such as Dr. / Mrs. / Mr.',
  recipient__honorific_suffix VARCHAR(255) COMMENT 'An honorific suffix preceding the recipient\'s name such as M.D. / PhD / MSCSW.',
  sender INT UNSIGNED COMMENT 'Optional, the organization that sent this message. Use created_by to query by the Person that sent this message.', /* FK to #__cajobboard_organizations */

  /* SCHEMA: https://calligraphic.design/schema/EmailMessages */
  email_message_template INT UNSIGNED COMMENT 'The template to apply when generating this message.', /* FK to #__cajobboard_email_message_templates */

  /* SQL DDL */
  PRIMARY KEY (email_message_id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;