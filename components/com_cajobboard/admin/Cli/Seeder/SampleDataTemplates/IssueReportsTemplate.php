<?php
/**
 * POPO Object Template for Issue Reports (abuse content complaints) model sample data seeding
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates;

use Faker;

// no direct access
defined('_JEXEC') or die;

class IssueReportsTemplate extends CommonTemplate
{
	/**
	 * The foreign model name the item of this report refers to, e.g. Answers.
	 *
	 * @property    int
   */
  public $about__model;

	/**
	 * The primary key of the foreign model the item of this report refers to.
	 *
	 * @property    int
   */
  public $about__id;

	/**
	 * The reason this content is being reported, FK to #__cajobboard_report_reasons
	 *
	 * @property    string
   */
  public $category;


  /**
	 * Setters for Answer fields
   */

  public function about__model ($config, $faker)
  {
    $models = array(
      'Answers',
      'Applications',
      'ApplicationLetters',
      'AudioObjects',
      'DiversityPolicies',
      'EmailMessages',
      'ImageObjects',
      'JobPostings',
      'Messages',
      'Organizations',
      'Persons',
      'Places',
      'QAPages',
      'Questions',
      'Recommendations',
      'References',
      'Resumes',
      'Reviews',
      'VideoObjects'
    );

    $this->about__model = $models[$faker->numberBetween(0, 18)];

    $this->about__id = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, $this->about__model);
  }

  public function about__id ($config, $faker)
  {
    return;
  }

  public function category ($config, $faker)
  {
    $this->category = $faker->numberBetween(1, 6);
  }
}
