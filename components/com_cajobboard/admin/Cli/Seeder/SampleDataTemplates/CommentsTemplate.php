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
  use \Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates\Mixins\Image;
  use \Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates\Mixins\Tree;

	/**
	 * The primary key of the foreign model item that this comment belongs to.
	 *
	 * @property    int
   */
  public $about__foreign_model_id;


	/**
	 * The name of the foreign model this comment belongs to, discriminator field for single-table inheritance.
	 *
	 * @property    string    VARCHAR(255)
   */
  public $about__foreign_model_name;


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
	 * The parent item for this comment, defaults to the root node for the seeder
	 *
	 * @property    int
   */
  public $is_part_of;


	/**
	 * Class constructor
   *
   * @throws \Exception
	 */
  public function __construct()
  {
    $this->validateTreeTable('#__cajobboard_comments');
  }


  /**
	 * Setters for Comment fields
   */

  // $this->hasOne('ParentItem', 'Comments@com_cajobboard', 'parent_item', 'comment_id');
  public function about__foreign_model_id ($config, $faker)
  {
    $foreignModels = array(
      'JobPostings',
      'Organizations',
      'Places'
    );

    $this->about__foreign_model_name = $foreignModels[$faker->numberBetween(0, count($foreignModels) - 1 )];

    $this->about__foreign_model_id = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, $this->about__foreign_model_name);
  }


  public function about__foreign_model_name ($config, $faker)
  {
    return;
  }


  public function upvote_count ($config, $faker)
  {
    $this->upvote_count = $faker->numberBetween(1, 30);
  }


  public function downvote_count ($config, $faker)
  {
    $this->downvote_count = $faker->numberBetween(1, 10);
  }


  public function is_part_of ($config, $faker)
  {
    $this->is_part_of = 1;
  }
}
