<?php
/**
 * POPO Object Template for Analytic Aggregates model sample data seeding
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

class AnalyticAggregatesTemplate extends BaseTemplate
{
	/**
	 * Alias for SEF URL.
	 *
	 * @var    string
   */
  public $slug;


	/**
	 * FK to the #__viewlevels table for access view control purposes.
	 *
	 * @var    int
  */
  public $access;


  /**
	 * Userid of the creator of this item.
	 *
	 * @var    \Joomla\CMS\User\User
   */
  public $created_by;


  /**
	 * Date the item was created
	 *
	 * @var    \DateTime
   */
  public $created_on;


  /**
	 * Userid of person that last modified this item.
	 *
   * @var    \Joomla\CMS\User\User
   */
  public $modified_by;


	/**
	 * Category ID for this item.
	 *
	 * @var    int
   */
  public $cat_id;


  /**
	 * JSON encoded parameters for this item.
	 *
	 * @var    string
   */
  public $params;


	/**
	 * A note to save with this item in the back-end interface.
	 *
	 * @var    string
   */
  public $note;


	/**
	 * A title to use for this item.
	 *
	 * @var    string
   */
  public $name;


	/**
	 * A description of the item.
	 *
	 * @var    string
   */
  public $description;


	/**
	 * A description of the item.
	 *
	 * @var    string
   */
  public $description__intro;


	/**
	 * The values for this analytic aggregate, in a JSON string.
	 *
	 * @var    JSON
   */
  public $structured_value;


  /**
	 * Setters for Common fields
   */


  public function slug ($config, $faker)
  {
    $this->slug = $faker->slug();
  }


  // Set to a view level for this item: 1 is "Public", 2 is "Registered", etc.
  public function access ($config, $faker)
  {
    $this->access = 1;
  }


  public function cat_id ($config, $faker)
  {
    // need to get model name being worked on, normalized to human-readable form e.g. "Job Postings"
    $className = explode( '\\', get_class($this) );
    $modelName = preg_replace('/Template$/', '', array_pop($className) );
    $normalModelName = preg_replace('/(?<!^)[A-Z]/', ' $0', $modelName);

    foreach ($config->categories as $category)
    {
      if ($category->title == $normalModelName)
      {
        $this->cat_id = $category->id;

        return;
      }
    }

    $this->cat_id = null;
  }


  public function created_on ($config, $faker)
  {
    $dateTime = $faker->dateTimeBetween('-5 years', 'now', null);

    $this->created_on = $dateTime->format('Y-m-d H:i:s');
    $this->publish_up = $dateTime->format('Y-m-d H:i:s');
  }


  public function created_by ($config, $faker)
  {
    $this->created_by = $config->userIds[$faker->numberBetween( 0, count($config->userIds) - 1 )];
  }


  public function modified_by ($config, $faker)
  {
    $this->modified_by = 0;
  }


  public function params ($config, $faker)
  {
    $this->params = '{"image":"","image_alt":""}';
  }


  public function note ($config, $faker)
  {
    $this->note = $faker->paragraph;
  }


  public function name ($config, $faker)
  {
    $this->name = $faker->sentence;
  }


  public function description ($config, $faker)
  {
    $this->description = $faker->paragraph;
  }


  public function description__intro ($config, $faker)
  {
    $this->description__intro = $faker->text(280);
  }


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


  public function structured_value ($config, $faker)
  {
    $this->structured_value = '{}';
  }
}