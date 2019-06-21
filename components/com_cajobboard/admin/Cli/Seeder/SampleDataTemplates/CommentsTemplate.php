<?php
/**
 * POPO Object Template for Comments model sample data seeding
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

class CommentsTemplate extends CommonTemplate
{
	/**
	 * This property points to a Question entity associated with this answer.
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
	 * Setters for Answer fields
   */

  // relation field for belongsToMany is in a join table

  // $this->inverseSideOfHasOne('ParentItem', 'Comments@com_cajobboard', 'parent_item', 'comment_id');
  public function parent_item ($config, $faker)
  {
    //
    $this->parent_item = $config->relationMapper->getFKValue('InverseSideOfHasOne', $config, false, $faker, 'Comments');
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
