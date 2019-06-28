/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

/**
 * Messages data model SQL
 *
 * Uses schema https://schema.org/Message
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_messages` (
  message_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key', /* FK to #__cajobboard_ucm(id) */
  slug CHAR(255) NOT NULL COMMENT 'alias for SEF URL',

  /* FOF "magic" fields */
  asset_id	INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Enable record-level access control.', /* FK to #__assets */
  access INT UNSIGNED NOT NULL DEFAULT '1' COMMENT 'The Joomla! view access level.',
  enabled TINYINT NOT NULL DEFAULT '1' COMMENT 'Publish status: -2 for trashed and marked for deletion, -1 for archived, 0 for unpublished, and 1 for published.',
  created_on DATETIME DEFAULT NULL COMMENT 'Timestamp of record creation, auto-filled by save().',
  created_by INT NOT NULL DEFAULT '0' COMMENT 'User ID who created the record, auto-filled by save().',
  modified_on DATETIME DEFAULT NULL COMMENT 'Timestamp of record modification, auto-filled by save(), touch().',
  modified_by INT DEFAULT '0' COMMENT 'User ID who modified the record, auto-filled by save(), touch().',

  /* Joomla UCM fields, used by Joomla!s UCM when using the FOF ContentHistory behaviour */
  params TEXT COMMENT 'JSON encoded parameters for the content item.',
  language CHAR(7) NOT NULL DEFAULT '*' COMMENT 'The language code for the message or * for all languages.',
  cat_id INT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Category ID for this content item.',
  note VARCHAR(255) COMMENT 'A note to save with this report in the back-end interface.',

  /* SCHEMA: Thing */
  description TEXT COMMENT 'Body text of this message.',
  name VARCHAR(255) COMMENT 'Subject field of the e-mail. Aliased by title property.',

  /* SCHEMA: Message */
  date_read DATETIME DEFAULT NULL COMMENT 'The date/time at which the message was opened by the recipient.',
  recipient INT UNSIGNED  COMMENT 'The recipient of this message.', /* FK to #__cajobboard_organizations */

  /* SQL DDL */
  PRIMARY KEY (message_id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;


/**
 * Messages - Audio Object join table
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_messages_audio_objects` (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key',
  message_id BIGINT UNSIGNED NOT NULL,
  audio_object_id BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;


/**
 * Messages - Digital Document join table
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_messages_digital_documents` (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key',
  message_id BIGINT UNSIGNED NOT NULL,
  digital_document_id BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;


/**
 * Messages - Image Object join table
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_messages_image_objects` (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key',
  message_id BIGINT UNSIGNED NOT NULL,
  image_object_id BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;


/**
 * Messages - Video Object join table
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_messages_video_objects` (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key',
  message_id BIGINT UNSIGNED NOT NULL,
  video_object_id BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;
