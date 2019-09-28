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
	 * FK to person this application is about. FK to #__cajobboard_persons.
	 *
	 * @property    int
   */
  public $main_entity_of_page;


  /**
	 * Setters for QAPage fields
   */


  public function content_url ($config, $faker)
  {
    $metadata = array(
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

    $this->content_url  = $metadata[$config->item_id - 1]['content_url'];
    $this->content_size = $metadata[$config->item_id - 1]['content_size'];
  }


  public function content_size ($config, $faker)
  {
    return;
  }


  public function encoding_format ($config, $faker)
  {
     $this->encoding_format = 'application/pdf';
   }


  // $this->belongsTo('MainEntityOfPage', 'Persons@com_cajobboard', 'main_entity_of_page', 'id');
  public function main_entity_of_page ($config, $faker)
  {
    $this->main_entity_of_page = $config->userIds[$faker->numberBetween( 0, count($config->userIds) - 1 )];
  }


  public function resume ($config, $faker)
  {
    /* Schema taken from http://jsonresume.org/schema */

    $this->resume = '{
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
          "Awarded Volunteer of the Month"
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
    }';
  }
}
