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
  'id' BIGINT UNSIGNED NOT NULL AUTO_INCREMENT=0,
  PRIMARY KEY ('id')
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;

 /**
 * Telephone number table
 */
CREATE TABLE IF NOT EXISTS '#__cajobboard_util_telephone' (
  'telephone' CHAR(16) NOT NULL COMMENT 'The telephone number',
  PRIMARY KEY ('telephone')
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;


/**
 * Days of week table
 */
CREATE TABLE IF NOT EXISTS '#__cajobboard_util_day_of_week' (
  /* SCHEMA: https://schema.org/DayOfWeek */
  'day' CHAR(16) NOT NULL,
  PRIMARY KEY ('day')
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;

 /**
 * Region table (states or equivelant entity, e.g. CA)
 */
CREATE TABLE IF NOT EXISTS '#__cajobboard_util_address_region' (
  'address_region' CHAR(32) NOT NULL COMMENT 'The name of the region, e.g. California'
  'address_region_abbr' VARCHAR(6) NOT NULL COMMENT 'The abbreviation for the region, e.g. CA'
  PRIMARY KEY ('address_region')
)
  ENGINE=innoDB
  DEFAULT CHARACTER SET = utf8
  DEFAULT COLLATE = utf8_unicode_ci;

/**
 * Initial days of the week
 */
INSERT INTO '#__cajobboard_util_day_of_week' ('day') VALUES
  ('Monday'),
  ('Tuesday'),
  ('Wednesday'),
  ('Thursday'),
  ('Friday'),
  ('Saturday'),
  ('Sunday'),
  ('Weekdays'),
  ('Weekends'),
  ('PublicHolidays');

/**
 * Initial regions (states or equivelant entity, e.g. CA)
 */
INSERT INTO '#__cajobboard_util_address_region' ('address_region', 'address_region_abbr') VALUES
  ('Alabama',	'AL'),
  ('Alaska',	'AK'),
  ('Arizona',	'AZ'),
  ('Arkansas',	'AR'),
  ('California',	'CA'),
  ('Colorado',	'CO'),
  ('Connecticut',	'CT'),
  ('Delaware',	'DE'),
  ('Florida',	'FL'),
  ('Georgi',	'GA'),
  ('Hawaii',	'HI'),
  ('Idaho',	'ID'),
  ('Illinois',	'IL'),
  ('Indiana',	'IN'),
  ('Iowa',	'IA'),
  ('Kansas',	'KS'),
  ('Kentucky',	'KY'),
  ('Louisiana',	'LA'),
  ('Maine',	'ME'),
  ('Maryland',	'MD'),
  ('Massachusetts',	'MA'),
  ('Michigan',	'MI'),
  ('Minnesota',	'MN'),
  ('Mississippi',	'MS'),
  ('Missouri',	'MO'),
  ('Montana',	'MT'),
  ('Nebraska',	'NE'),
  ('Nevada',	'NV'),
  ('New Hampshire',	'NH'),
  ('New Jersey',	'NJ'),
  ('New Mexico',	'NM'),
  ('New York',	'NY'),
  ('North Carolina',	'NC'),
  ('North Dakota',	'ND'),
  ('Ohio',	'OH'),
  ('Oklahoma',	'OK'),
  ('Oregon',	'OR'),
  ('Pennsylvania',	'PA'),
  ('Rhode Island',	'RI'),
  ('South Carolina',	'SC'),
  ('South Dakota',	'SD'),
  ('Tennessee',	'TN'),
  ('Texas',	'TX'),
  ('Utah',	'UT'),
  ('Vermont',	'VT'),
  ('Virginia',	'VA'),
  ('Washington',	'WA'),
  ('West Virginia',	'WV'),
  ('Wisconsin',	'WI'),
  ('Wyoming',	'WY'),
  ('American Samoa',	'AS'),
  ('District of Columbia',	'	DC'),
  ('Federated States of Micronesia',	'FM'),
  ('Guam',	'GU'),
  ('Marshall Islands',	'MH'),
  ('Northern Mariana Islands',	'MP'),
  ('Palau',	'PW'),
  ('Puerto Rico',	'PR'),
  ('Virgin Islands',	'VI');
