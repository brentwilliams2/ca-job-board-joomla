/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */


/**
 * Issue Report Categories table for abusive content reports
 *
 * Uses schema https://calligraphic.design/schema/ReportIssueCategory
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_issue_report_categories` (
  issue_report_category_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key',
  category VARCHAR(255) COMMENT 'The category of abusive content report, e.g. spam, inappropriate language, etc.',
  url VARCHAR(2083) NOT NULL COMMENT 'Link to schema for type of complaint, e.g. wikipedia page on Profanity',

  /* DDL */
  PRIMARY KEY (issue_report_category_id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;


/**
 * Initial abusive content report categories
 */
INSERT INTO `#__cajobboard_issue_report_categories` (category, url) VALUES
  ('COM_CAJOBBOARD_REPORTS_REASON_INAPPROPRIATE_LANGUAGE', 'https://en.wikipedia.org/wiki/Profanity'),
  ('COM_CAJOBBOARD_REPORTS_REASON_SPAM', 'https://en.wikipedia.org/wiki/Messaging_spam'),
  ('COM_CAJOBBOARD_REPORTS_REASON_DOX', 'https://en.wikipedia.org/wiki/Doxing'),
  ('COM_CAJOBBOARD_REPORTS_REASON_ILLEGAL', 'https://en.wikipedia.org/wiki/Notice_and_take_down'),
  ('COM_CAJOBBOARD_REPORTS_REASON_IRRELEVANT', 'https://en.wikipedia.org/wiki/Relevance'),
  ('COM_CAJOBBOARD_REPORTS_REASON_CRITICISM', 'https://en.wikipedia.org/wiki/Criticism');
