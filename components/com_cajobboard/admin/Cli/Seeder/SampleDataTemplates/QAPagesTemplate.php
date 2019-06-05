<?php
/**
 * POPO Object Template for QAPage model sample data seeding
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

class QAPagesTemplate extends CommonTemplate
{
	/**
	 * This property points to a QAPage entity associated with this question and answer page.
	 *
	 * @property    int
   */
  public $is_part_of;

	/**
	 * The company that wrote this question and answer page.
	 *
	 * @property    int
   */
  public $publisher;

	/**
	 * The actual text of the question and answer page itself.
	 *
	 * @property    string
   */
  public $text;

	/**
	 * The question this question and answer page is intended for.
	 *
	 * @property    int
   */
  public $parent_item;

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
	 * Setters for QAPage fields
   */

  // $this->hasOne('isPartOf', 'QAPages@com_cajobboard', 'is_part_of', 'qapage_id');
  public function is_part_of ($config, $faker)
  {
    $this->is_part_of = $config->relationMapper->getFKValue('InverseSideOfHasOne', $config, true, $faker); // @TODO: Not in model
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
}
