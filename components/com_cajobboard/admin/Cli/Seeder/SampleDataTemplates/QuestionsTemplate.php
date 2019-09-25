<?php
/**
 * POPO Object Template for Question model sample data seeding
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

class QuestionsTemplate extends CommonTemplate
{
  use \Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates\Mixins\Image;

	/**
	 * This property points to an Answer entity associated with this question.
	 *
	 * @property    int
   */
  public $accepted_answer;

	/**
	 * The company that wrote this question.
	 *
	 * @property    int
   */
  public $publisher;

	/**
	 * The actual text of the question itself.
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
	 * Setters for Question fields
   */

  // $this->inverseSideOfHasOne('acceptedAnswer', 'Answers@com_cajobboard', 'accepted_answer', 'answer_id');
  public function accepted_answer ($config, $faker)
  {
    $this->accepted_answer = $config->relationMapper->getFKValue('InverseSideOfHasOne', $config, true, $faker, 'Answers');
  }

  // $this->belongsTo('Publisher', 'Organizations@com_cajobboard', 'publisher', 'organization_id');
  public function publisher ($config, $faker)
  {
    $this->publisher = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'Organizations');
  }

  public function text ($config, $faker)
  {
    $this->text = implode("\n", $faker->paragraphs($faker->numberBetween(1, 3)));
  }

  public function upvote_count ($config, $faker)
  {
    $this->upvote_count = $faker->numberBetween(1, 10);
  }

  public function downvote_count ($config, $faker)
  {
    $this->downvote_count = $faker->numberBetween(1, 30);
  }
}
