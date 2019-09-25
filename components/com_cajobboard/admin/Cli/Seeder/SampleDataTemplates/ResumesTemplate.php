<?php
/**
 * POPO Object Template for Resumes model sample data seeding
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates;

use Faker;

// no direct access
defined('_JEXEC') or die;

class ResumesTemplate extends CommonTemplate
{
	/**
	 * System filename of a resume file attached to the record.
	 *
	 * @property    string
   */
  public $content_url;


	/**
	 * Size of the resume file in bytes.
	 *
	 * @property    int
   */
  public $content_size;


  content_url VARCHAR(255) NOT NULL COMMENT '',
  content_size BIGINT(20) UNSIGNED COMMENT '',
  encoding_format CHAR(32) COMMENT '',
  resume JSON COMMENT '',
  main_entity_of_page BIGINT UNSIGNED COMMENT 'FK to person this application is about. FK to #__cajobboard_persons.',

	/**
	 * MIME format of the document, e.g. application/pdf
	 *
	 * @property    string
   */
  public $encoding_format;


	/**
	 * JSON-formatted resume data.
	 *
	 * @property    JSON
   */
  public $resume;


	/**
	 * The organization this question-and-answer page is about. FK to #__cajobboard_organizations.
	 *
	 * @property    int
   */
  public $main_entity_of_page;


  /**
	 * Setters for QAPage fields
   */


  public function content_url ($config, $faker)
  {
    $metadata = $this->getResumeMetadata();

    $this->content_url = $metadata[$nextConfig->item_id]['content_url'];
    $this->content_size = $metadata[$nextConfig->item_id]['content_size'];
  }


  public function content_size ($config, $faker)
  {
    return;
  }


  public function encoding_format ($config, $faker)
  {
     $this->encoding_format = 'application/pdf';
   }


  public function resume ($config, $faker)
  {
    $this->resume = $this->getResumeJson();
  }


  // $this->belongsTo('MainEntityOfPage', 'Persons@com_cajobboard', 'main_entity_of_page', 'id');
  public function main_entity_of_page ($config, $faker)
  {
    $this->about__main_entity_of_page = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'Persons');
  }


  private function getResumeMetadata()
  {
    return array(
      array(
        'content_url' => 'ccf15af9de4bdf47213744dbbc44cbf8.pdf',  'content_size' => '97776'
      ),
      array(
        'content_url' => '40b0c12d6666c71e3ff133296b27a304.pdf',  'content_size' => '20372'
      ),
      array(
        'content_url' => 'a230d31691ea0b6afa90dea544a82e69.pdf',  'content_size' => '20148'
      ),
      array(
        'content_url' => '857efe3a1350ad6efa8d25365747b7ea.pdf',  'content_size' => '20841'
      ),
      array(
        'content_url' => '854158c179184c6c4431440891f9084e.pdf',  'content_size' => '101928'
      )
  );


  private function getResumeJson()
  {
    return '{

    }';
  }
}



/* These are from Person schema, but are more like resume items */
award TEXT COMMENT 'An award won by or for this item. Supersedes awards.',
affiliation Organization 'An organization that this person is affiliated with. For example, a school/university, a club, or a team.' /* FK to */
memberOf Organization or ProgramMembership 'An Organization (or ProgramMembership) to which this Person or Organization belongs.' /* FK to */
alumniOf 	EducationalOrganization 'An organization that the person is an alumni of.' /* FK to */


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


// USE JSON-LD ???


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
