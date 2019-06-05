<?php
/**
 * POPO Object Template for Reviews model sample data seeding
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

class ReviewsTemplate extends CommonTemplate
{
	/**
	 * This property points to the employer being reviewed/rated.
	 *
	 * @property    Organizations
   */
  public $item_reviewed;

	/**
	 * The actual body of the review.
	 *
	 * @property    string
   */
  public $review_body;

	/**
	 * The rating for the content. Default worstRating 1 and bestRating 5 assumed.
	 *
	 * @property    int
   */
  public $rating_value;

  /**
	 * Setters for Review fields
   */

  // $this->belongsTo('ItemReviewed', 'Organizations@com_cajobboard', 'item_reviewed', 'organization_id');
  public function item_reviewed ($config, $faker)
  {
    $this->item_reviewed = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, 'Organizations');
  }

  public function review_body ($config, $faker)
  {
    $this->review_body = implode("\n", $faker->paragraphs($faker->numberBetween(2, 4)));
  }

  public function rating_value ($config, $faker)
  {
    $this->rating_value = $faker->numberBetween(1, 5);
  }
}
