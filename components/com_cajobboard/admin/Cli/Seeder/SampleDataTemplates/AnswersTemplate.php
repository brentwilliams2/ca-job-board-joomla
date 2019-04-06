<?php
/**
 * POPO Object Template for Answer model sample data seeding
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
	/**
	 * Category ID for this item.
	 *
	 * @var    int
   */
  public $cat_id;

	/**
	 * This property points to a QAPage entity associated with this answer.
	 *
	 * @var    QAPage
   */
  public $is_part_of;

	/**
	 * The company that wrote this answer.
	 *
	 * @var    Organization
   */
  public $publisher;

	/**
	 * The actual text of the answer itself.
	 *
	 * @var    string
   */
  public $text;

	/**
	 * The question this answer is intended for.
	 *
	 * @var    Question
   */
  public $parent_item;

	/**
	 *Upvote count for this item.
	 *
	 * @var    int
   */
  public $upvote_count;

	/**
	 * Downvote count for this item.
	 *
	 * @var    int
   */
	public $downvote_count;

  /**
	 * Userid of the creator of this item.
	 *
	 * @var    \JUser
   */
  public $created_by;


  /**
	 * Setters for Answer fields
   */


  public function cat_id ($config, $faker)
  {
    foreach ($config->categories as $category)
    {
      if ($category->title = 'answers')
      {
        $this->cat_id = $category->id;
        return;
      }
    }
    $this->cat_id = null;
  }

  // $this->hasOne('isPartOf', 'QAPages@com_cajobboard', 'is_part_of', 'qapage_id');
  public function is_part_of ($config, $faker)
  {
    $this->is_part_of = $config->relationMapper->getFKValue('InverseSideOfHasOne', $config, true, $faker);
  }

  // $this->hasOne('parentItem', 'Questions@com_cajobboard', 'parent_item', 'question_id');
  public function parent_item ($config, $faker)
  {
    $this->parent_item = $config->relationMapper->getFKValue('InverseSideOfHasOne', $config, true, $faker);
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

  public function created_by ($config, $faker)
  {
    $this->created_by = $config->userIds[$faker->numberBetween(0, count($config->userIds))];
  }

  public function created_on ($config, $faker)
  {
    $this->created_on = $faker->dateTimeBetween($startDate = '-5 years', $endDate = 'now', $timezone = null);
  }
}
