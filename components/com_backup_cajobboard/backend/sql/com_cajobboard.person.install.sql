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

Person

/* Thing */
name
description
alternateName Text 'An alias for the item (nickname).'
image 	ImageObject or URL 'An image of the item. This can be a URL or a fully described ImageObject.'
mainEntityOfPage 	CreativeWork or URL 'Indicates a page (or other CreativeWork) for which this thing is the main entity being described. See background notes for details.'
/* Person*/
additionalName Text 'An additional name for a Person, can be used for a middle name.'
address PostalAddress or Text 'Physical address of the item.'
affiliation Organization 'An organization that this person is affiliated with. For example, a school/university, a club, or a team.'
alumniOf 	EducationalOrganization  or Organization 	'An organization that the person is an alumni of.'
award Text 'An award won by or for this item. Supersedes awards.'
birthDate	Date 'Date of birth.'
birthPlace Place 'The place where the person was born.'
colleague Person or URL 'A colleague of the person. Supersedes colleagues.'
contactPoint ContactPoint 'A contact point for a person or organization. Supersedes contactPoints.'
email Text 'Email address.'
familyName Text 'Family name. In the U.S., the last name of an Person. This can be used along with givenName instead of the name property.'
faxNumber Text 'The fax number.'
gender 	GenderType or Text 'Gender of the person. While http://schema.org/Male and http://schema.org/Female may be used, text strings are also acceptable'
givenName Text 'Given name. In the U.S., the first name of a Person. This can be used along with familyName instead of the name property.'
hasOccupation Occupation 'The Person\'s occupation. For past professions, use Role for expressing dates.'
homeLocation ContactPoint or Place 	'A contact location for a person\'s residence.'
jobTitle Text 'The job title of the person (for example, Financial Manager).'
memberOf Organization or ProgramMembership 'An Organization (or ProgramMembership) to which this Person or Organization belongs.'
nationality Country 'Nationality of the person.'
telephone Text 'The telephone number.
workLocation ContactPoint or Place 'A contact location for a person\'s place of work.'
worksFor Organization 'Organizations that the person works for.'


/* Occupation: for Person(hasOccupation), JobPostings uses occupational groups. 'A profession, may involve prolonged training and/or a formal qualification.' */
educationRequirements Text 'Educational background needed for the position or Occupation.'
estimatedSalary MonetaryAmount or MonetaryAmountDistribution or Number or PriceSpecification 'A property describing the estimated salary for a job posting based on a variety of variables including, but not limited to industry, job title, and location. The estimated salary is usually computed by outside organizations and therefore the hiring organization is not bound to this estimated salary.'
experienceRequirements Text 'Description of skills and experience needed for the position or Occupation.'
occupationLocation AdministrativeArea 'The region/country for which this occupational description is appropriate. Note that educational requirements and qualifications can vary between jurisdictions.'
occupationalCategory Text 'Category or categories describing the job. Use BLS O*NET-SOC taxonomy: http://www.onetcenter.org/taxonomy.html. Ideally includes textual label and formal code, with the property repeated for each applicable value.'
qualifications Text 'Specific qualifications required for this role or Occupation.'
responsibilities Text 'Responsibilities associated with this role or Occupation.'
skills Text 'Skills required to fulfill this role.'
