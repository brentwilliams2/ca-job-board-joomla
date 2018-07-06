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

/* Schema.org markup suggested for resumes */
Person and Postal Address (for "Contact and Social Media Links", use html <section id="contact-details">)

Person
  image
  name
  jobTitle
  telephone
  email
  url

PostalAddress
  streetAddress
  addressLocality
  addressRegion
  postalCode
  addressCountry


ItemList (for skills, use html <section id="skills"> )
  itemListElement


Organization (for experience, use html <section id="experience">)
  jobTitle
  name
  description

Article (for publications, use html <section id="publications">)
  name
  url


EducationalOrganization and PostalAddress (for education, use html <section id="education">)

  name
  url


/* Schema taken from http://jsonresume.org/schema */
{

  "basics": {
    "name": "John Doe",
    "label": "Programmer",
    "picture": "",
    "email": "john@gmail.com",
    "phone": "(912) 555-4321",
    "website": "http://johndoe.com",
    "summary": "A summary of John Doe...",
    "location": {
      "address": "2712 Broadway St",
      "postalCode": "CA 94115",
      "city": "San Francisco",
      "countryCode": "US",
      "region": "California"
    },
    "profiles": [{
      "network": "Twitter",
      "username": "john",
      "url": "http://twitter.com/john"
    }]
  },

  "work": [{
    "company": "Company",
    "position": "President",
    "website": "http://company.com",
    "startDate": "2013-01-01",
    "endDate": "2014-01-01",
    "summary": "Description...",
    "highlights": [
      "Started the company"
    ]
  }],

  "volunteer": [{
    "organization": "Organization",
    "position": "Volunteer",
    "website": "http://organization.com/",
    "startDate": "2012-01-01",
    "endDate": "2013-01-01",
    "summary": "Description...",
    "highlights": [
      "Awarded 'Volunteer of the Month'"
    ]
  }],

  "education": [{
    "institution": "University",
    "area": "Software Development",
    "studyType": "Bachelor",
    "startDate": "2011-01-01",
    "endDate": "2013-01-01",
    "gpa": "4.0",
    "courses": [
      "DB1101 - Basic SQL"
    ]
  }],

  "awards": [{
    "title": "Award",
    "date": "2014-11-01",
    "awarder": "Company",
    "summary": "There is no spoon."
  }],

  "publications": [{
    "name": "Publication",
    "publisher": "Company",
    "releaseDate": "2014-10-01",
    "website": "http://publication.com",
    "summary": "Description..."
  }],

  "skills": [{
    "name": "Web Development",
    "level": "Master",
    "keywords": [
      "HTML",
      "CSS",
      "Javascript"
    ]
  }],

  "languages": [{
    "name": "English",
    "level": "Native speaker"
  }],

  "interests": [{
    "name": "Wildlife",
    "keywords": [
      "Ferrets",
      "Unicorns"
    ]
  }],

  "references": [{
    "name": "Jane Doe",
    "reference": "Reference..."
  }]

}
