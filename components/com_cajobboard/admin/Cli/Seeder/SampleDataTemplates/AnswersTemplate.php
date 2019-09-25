<?php
/**
 * POPO Object Template for Answers model sample data seeding
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

class AnswersTemplate extends CommonTemplate
{
  use \Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates\Mixins\Image;

  /**
	 * The primary key of the foreign model item that this answer belongs to.
	 *
	 * @property    int
   */
  public $about__foreign_model_id;


	/**
	 * The name of the foreign model this answer belongs to, discriminator field for single-table inheritance.
	 *
	 * @property    string
   */
  public $about__foreign_model_name;


	/**
	 * This property points to a Question entity associated with this answer.
	 *
	 * @property    int
   */
  public $is_part_of__question;


	/**
	 * The actual text of the answer itself.
	 *
	 * @property    string
   */
  public $text;


	/**
	 *Upvote count for this item.
	 *
	 * @property    int
   */
  public $upvote_count;


	/**
	 * Downvote count for this item.
	 *
	 * @property    int
   */
  public $downvote_count;


  /**
	 * Setters for Answer fields
   */


  // $this->hasOne('ParentItem', 'Comments@com_cajobboard', 'parent_item', 'comment_id');
  public function about__foreign_model_id ($config, $faker)
  {
    $foreignModels = array(
      'Applications',
      'Interviews',
      'QAPages'
    );

    $this->about__foreign_model_name = $foreignModels[$faker->numberBetween(0, count($foreignModels) - 1 )];

    $this->about__foreign_model_id = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, $this->about__foreign_model_name);
  }


  public function about__foreign_model_name ($config, $faker)
  {
    return;
  }


  // $this->hasOne('IsPartOf', 'Questions@com_cajobboard', 'is_part_of', 'question_id');
  public function is_part_of__question ($config, $faker)
  {
    $this->is_part_of__question = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'Questions');
  }


  public function text ($config, $faker)
  {
    $this->text = implode("\n", $faker->paragraphs($faker->numberBetween(1, 3)));
  }


  public function upvote_count ($config, $faker)
  {
    $this->upvote_count = $faker->numberBetween(1, 30);
  }


  public function downvote_count ($config, $faker)
  {
    $this->downvote_count = $faker->numberBetween(1, 10);
  }
}
