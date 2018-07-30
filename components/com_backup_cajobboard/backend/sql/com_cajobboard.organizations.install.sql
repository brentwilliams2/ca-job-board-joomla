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
CREATE TABLE IF NOT EXISTS '#__cajobboard_organizationtypes' (
/* @TODO: Should this use ItemList for the enumeration values? Utilities has tables with similar question */
  /* SCHEMA: Thing */
  'name' CHAR(16) COMMENT 'The type of organization, e.g. Employer, Recruiter, etc.',
  'description' VARCHAR(255),
  PRIMARY KEY ('name'),
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;


 /**
 * Organization table
 *
 * Uses schema https://schema.org/Organization
 */
CREATE TABLE IF NOT EXISTS '#__cajobboard_organizations' (
  /* Use Calligraphic unified content model (UCM) table for common record metadata */
  'cajobboard_organization_id' BIGINT UNSIGNED NOT NULL,  /* FK to #__cajobboard_ucm(id) */
  /* SCHEMA: Thing(additionalType) -> extended types in private namespace (default) */
  'organizationType' CHAR(16) COMMENT 'The type of organization e.g. Employer, Recruiter, etc.' /* FK from #__cajobboard_organization_type */
  /* SCHEMA: Thing */
  'name' Text COMMENT 'The name of the item.'
  'disambiguatingDescription' COMMENT Text 'A short description of the employer, for example to use on listing pages.'
  'description'Text COMMENT 'A description of the item.'
  'url' URL COMMENT 'URL of employer\'s website.'
  /***** image 	ImageObject 	'Images of the employer.' FK from media images table */

  /* SCHEMA: Organization */
  'legalName' Text COMMENT 'The official name of the employer.'
/* @TODO: Need to create PostalAddress table, used in Place also */ 'location' Place or PostalAddress or Text COMMENT 'Where the organization is located'
  'logo' ImageObject or URL COMMENT 'An associated logo.'
  'email' Text COMMENT 'Email address.'
  'telephone' Text	COMMENT 'The telephone number.'
  'faxNumber'	Text COMMENT 'The fax number.'
  'contactPoint' ContactPoint COMMENT 'A contact point for a person or organization. Supersedes contactPoints.' /* contactPoint duplicates a lot of info here (email, telephone, faxNumber) and adds hoursAvailable */

  'diversityPolicy'	CreativeWork or URL	COMMENT 'Statement on diversity policy of the employer.'

  /***** employee  Person  Someone working for this organization. Supersedes employees. FK from user table */


  'memberOf'	Organization or ProgramMembership	COMMENT 'An Organization (or ProgramMembership) to which this Person or Organization belongs.'
  'numberOfEmployees' QuantitativeValue	COMMENT 'The number of employees in an organization e.g. business.' /* QuantitativeValue has properties like value, minValue, maxValue, unitCode for unit of measurement */

  'aggregateRating'	AggregateRating	COMMENT 'The overall rating, based on a collection of reviews or ratings, of the item.'
  'review' Review	COMMENT 'A review of the item. Supersedes reviews.'

  'parentOrganization' Organization COMMENT 'The larger organization that this organization is a subOrganization of, if any.'

  PRIMARY KEY ('id'),
  /* FOREIGN KEY (ucm_id) REFERENCES #__cajobboard_ucm(id), */
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;



 /**
 * Organization - Employee join table
 */
CREATE TABLE IF NOT EXISTS '#__cajobboard_organization_employee' (
  'employer_id' BIGINT UNSIGNED NOT NULL,
  'employee_id' BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY ('employer_id', 'employee_id'),
  /* FOREIGN KEY (employer_id) REFERENCES#__cajobboard_employer(ucm_id), */
  /* @TODO: Reference to Joomla user table FOREIGN KEY (employee_id) REFERENCES #__cajobboard_ucm(id), */
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;
