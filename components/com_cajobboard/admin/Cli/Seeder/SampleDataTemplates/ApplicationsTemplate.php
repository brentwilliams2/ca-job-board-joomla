<?php
/**
 * POPO Object Template for Applications model sample data seeding
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

class ApplicationsTemplate extends CommonTemplate
{
	/**
	 * The person this page is from. FK to #__cajobboard_persons.
	 *
	 * @property    int
   */
  public $main_entity_of_page;


  /**
	 * The Question List to be cloned into this application. FK to #__cajobboard_question_lists.
	 *
	 * @property    int
   */
  public $about__question_list;


  /**
	 * Setters for QAPage fields
   */


   // $this->hasOne('MainEntityOfPage', 'Questions@com_cajobboard', 'main_entity_of_page', 'question_id');
  public function main_entity_of_page ($config, $faker)
  {
    $this->seedApplicationsQuestionListsJoinTable($config, $faker);

    $this->main_entity_of_page = $config->relationMapper->getFKValue('InverseSideOfHasOne', $config, true, $faker, 'Persons');
  }


  // $this->belongsTo('AboutQuestionList', 'QuestionLists@com_cajobboard', 'about__question_list', 'question_list_id');
  public function about__question_list ($config, $faker)
  {
    $this->about__question_list = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'QuestionLists');
  }


  public function seedApplicationsQuestionListsJoinTable($config, $faker)
  {
    $config->relationMapper->BelongsToMany($config, $faker, 'application_id', 'Questions', 'question_id', '#__cajobboard_applications_questions', 2);
  }
}
