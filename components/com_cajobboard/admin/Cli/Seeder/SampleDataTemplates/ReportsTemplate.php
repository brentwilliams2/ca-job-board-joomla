<?php
/**
 * POPO Object Template for Reports model sample data seeding
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

class ReportsTemplate extends CommonTemplate
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
	 * The reasons this content is being reported. Use table #__cajobboard_report_reasons to populate in views.
	 *
	 * @property    int
   */
  public $keywords;

  /**
	 * The actual text of this report.
	 *
	 * @property    int
   */
  public $text;

  /**
	 * Setters for Report fields
   */

  public function about__model ($config, $faker)
  {
    $models = array(
      "Answers",
      "ImageObjects",
      "JobPostings",
      "Organizations",
      "Places",
      "QAPages",
      "Questions",
      "Reports",
      "Resumes",
      "Reviews"
    );

    $this->about__model = $models[ $faker->numberBetween( 0, count($models) - 1 ) ];

    $this->about__id = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, $this->about__model);
  }

  public function about__id ($config, $faker)
  {
    return;
  }

  public function keywords ($config, $faker)
  {
    $reasons = array(
      'COM_CAJOBBOARD_REPORTS_REASON_INAPPROPRIATE_LANGUAGE',
      'COM_CAJOBBOARD_REPORTS_REASON_SPAM',
      'COM_CAJOBBOARD_REPORTS_REASON_DOX',
      'COM_CAJOBBOARD_REPORTS_REASON_ILLEGAL',
      'COM_CAJOBBOARD_REPORTS_REASON_IRRELEVANT',
      'COM_CAJOBBOARD_REPORTS_REASON_CRITICISM'
    );

    $this->keywords = $reasons[ $faker->numberBetween( 0, count($reasons) - 1 ) ];
  }

  public function text ($config, $faker)
  {
    $this->text = $faker->paragraph;
  }
}
