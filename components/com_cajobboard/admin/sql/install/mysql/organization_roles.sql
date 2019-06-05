/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

 /**
 * Organization Role table
 */
CREATE TABLE IF NOT EXISTS `#__cajobboard_organization_roles` (
  /* UCM (unified content model) properties for internal record metadata */
  organization_role_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Surrogate primary key',
  /* SCHEMA: Organizaton (additionalType) -> Role(roleName) */
  role_name TEXT NOT NULL COMMENT 'The role of the organization, e.g. Employer, Recruiter, etc.',
  /* SCHEMA: Thing */
  description TEXT NOT NULL COMMENT 'A description of the role of the organization',
  url VARCHAR(2083) NOT NULL COMMENT 'Link to schema for organization type, e.g. wikipedia page on Employer, Recruiter, etc.',
  PRIMARY KEY (organization_role_id)
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;

/**
 * Initial organization roles
 */
INSERT INTO `#__cajobboard_organization_roles` (role_name, description, url) VALUES
  ('COM_CAJOBBOARD_ORGANIZATION_ROLE_EMPLOYER', 'COM_CAJOBBOARD_ORGANIZATION_ROLE_EMPLOYER_DESC', 'https://en.wiktionary.org/wiki/employer'),
  ('COM_CAJOBBOARD_ORGANIZATION_ROLE_RECRUITER', 'COM_CAJOBBOARD_ORGANIZATION_ROLE_RECRUITER_DESC', 'https://en.wiktionary.org/wiki/recruiter'),
  ('COM_CAJOBBOARD_ORGANIZATION_ROLE_CONNECTOR', 'COM_CAJOBBOARD_ORGANIZATION_ROLE_CONNECTOR_DESC', 'https://en.wiktionary.org/wiki/connector');
