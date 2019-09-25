/**
 * @package   Calligraphic Job Board
 * @version   15 September, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

 /**
 * Background Check table
 *
 * schema https://schema.org/Report
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_credit_reports` (
  credit_report_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key',
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
  note TEXT COMMENT 'A note to save with this digital document in the back-end interface.',

  /* SCHEMA: Thing */
  about BIGINT(20) UNSIGNED COMMENT 'The person the credit report is being conducted on', /* FK to #__cajobboard_persons */
  name VARCHAR(255) COMMENT 'A name for this document.',
  description TEXT COMMENT 'Description of this document.',
  description__intro VARCHAR(280) COMMENT 'Short description of the item, used for the text shown on social media via shares and search engine results.',

  /* SCHEMA: Thing(potentialAction) -> Action */
  action_status TINYINT UNSIGNED COMMENT 'Status of the action, ENUM defined in \Calligraphic\Cajobboard\Admin\Helper\Enum\ActionStatusEnum.',
  end_time DATETIME DEFAULT NULL COMMENT 'The date the completed credit report was received.',
  result BIGINT(20) UNSIGNED COMMENT 'The digital document returned from the credit reporting service as a result', /* FK to #__cajobboard_digital_documents */
  start_time DATETIME DEFAULT NULL COMMENT 'The date the credit report was requested.',

  /* SCHEMA: Thing(potentialAction) -> BuyAction */
  vendor BIGINT(20) UNSIGNED COMMENT 'The organization that will provide credit report services for this item.',  /* FK to #__cajobboard_organizations */

  PRIMARY KEY (credit_report_id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;
