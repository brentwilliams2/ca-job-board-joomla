/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

 /**
 * Example table
 */
CREATE TABLE IF NOT EXISTS '#__cajobboard_example' (
  'id' bigint unsigned NOT NULL AUTO_INCREMENT=0,
  PRIMARY KEY ('id')
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;


CREATE TABLE `#__akeebasubs_users` (
	`akeebasubs_user_id` bigint(20) unsigned NOT NULL auto_increment,
	`user_id` bigint(20) unsigned NOT NULL,
	`isbusiness` TINYINT(1) NOT NULL DEFAULT '0',
	`businessname` VARCHAR(255) NULL,
	`occupation` VARCHAR(255) NULL,
	`vatnumber` VARCHAR(255) NULL,
	`viesregistered` TINYINT(1) NOT NULL DEFAULT '0',
	`taxauthority` VARCHAR(255) NULL,
	`address1` VARCHAR(255) NULL,
	`address2` VARCHAR(255) NULL,
	`city` VARCHAR(255) NULL,
	`state` VARCHAR(255) NULL,
	`zip` VARCHAR(255) NULL,
	`country` CHAR(2) NOT NULL DEFAULT 'XX',
	`params` TEXT,
	`notes` TEXT,
    `needs_logout` TINYINT NOT NULL DEFAULT '0',
	PRIMARY KEY ( `akeebasubs_user_id` ),
	UNIQUE KEY `joomlauser` (`user_id`)
) DEFAULT COLLATE utf8_general_ci;

 * @property  int     $id
 * @property  string  $name
 * @property  string  $username // alternateName  An alias for the item (nickname).
 * @property  string  $email
 * @property  bool    $block
 * @property  string  $params


/* Thing */
description TEXT COMMENT 'A description of this person.',
image BIGINT UNSIGNED COMMENT 'An image or avatar for this person.' /* FK to ImageObjects table */
mainEntityOfPage VARCHAR(2083) COMMMENT 'A homepage or website belonging to this person.'

/* Person*/

givenName Text 'Given name. In the U.S., the first name of a Person. This can be used along with familyName instead of the name property.',
additionalName 	Text 	'An additional name for a Person, can be used for a middle name.',
familyName Text 'Family name. In the U.S., the last name of an Person. This can be used along with givenName instead of the name property.',

telephone VARCHAR(30) 'A telephone number for this person.',
faxNumber VARCHAR(30) COMMENT 'A fax number for this person.',

award TEXT COMMENT 'An award won by or for this item. Supersedes awards.',

  /* Person (address) -> PostalAddress */
  /* Mailing address, see homeLocation. Maybe should autofill unless they indicate a different mailing address. */
  address__street_address VARCHAR(255) COMMENT 'The street address, e.g. 1600 Amphitheatre Pkwy',
  address__address_locality VARCHAR(50) COMMENT 'The locality, e.g. Mountain View',
  address_region BIGINT UNSIGNED NOT NULL COMMENT 'The name of the region, e.g. California', /* FK to #__cajobboard_util_address_region(address_region) */
  address__postal_code VARCHAR(12) COMMENT 'The postal code, e.g. 94043',
  address__address_country VARCHAR(2) COMMENT 'The two-letter ISO 3166-1 alpha-2 country code',

  homeLocation Place 	'The address of a person\'s residence.' /* FK to Place */

  affiliation Organization 'An organization that this person is affiliated with. For example, a school/university, a club, or a team.' /* FK to */
  memberOf Organization or ProgramMembership 'An Organization (or ProgramMembership) to which this Person or Organization belongs.' /* FK to */
  alumniOf 	EducationalOrganization 'An organization that the person is an alumni of.' /* FK to */


  jobTitle Text 'The job title of the person (for example, Financial Manager).'
  worksFor Organization 'Organizations that the person works for.' /* M:M FK to Organizations. Could use for Recruiters. */
  hasOccupation Occupation 'The Person\'s occupation. For past professions, use Role for expressing dates.' /* FK to JobOccupationalCategories */
