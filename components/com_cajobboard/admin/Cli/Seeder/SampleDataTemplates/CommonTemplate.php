<?php
/**
 * POPO Object Template for seeding sample data in model common fields.
 * Override any setters in child class to provide custom output.
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates;

use Calligraphic\Cajobboard\Admin\Cli\Seeder\JoinTableManager;

// no direct access
defined('_JEXEC') or die;

class CommonTemplate extends BaseTemplate
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
	 * Publish status: -2 for trashed and marked for deletion, -1 for archived,
   * 0 for unpublished, and 1 for published. Not enabled by default.
	 *
	 * @var    int
   */
  public $enabled;

	/**
	 * JSON encoded metadata field for this item.
	 *
	 * @var    string
   */
  public $metadata;

  /**
	 * Meta keywords for this item.
	 *
	 * @var    string
   */
  public $metakey;

  /**
	 * Meta description for this item.
	 *
	 * @var    string
   */
  public $metadesc;

  /**
	 * A reference to enable linkages to external data sets, used to output a meta tag like FB open graph.
	 *
	 * @var    string
   */
	public $xreference;

  /**
	 * JSON encoded parameters for this item.
	 *
	 * @var    string
   */
  public $params;

	/**
	 * Category ID for this item.
	 *
	 * @var    int
   */
  public $cat_id;

	/**
	 * Number of hits this item has received.
	 *
	 * @var    int
   */
  public $hits;

	/**
	 * Whether this item is featured or not.
	 *
	 * @var    bool
   */
  public $featured;

	/**
	 * Alias for SEF URL.
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
	 * Userid of person that last modified this item.
	 *
   * @var    \JUser
   */
  public $modified_by;


  /**
	 * Setters for Common fields
   */
  public function slug ($config, $faker)
  {
    // @TODO: not putting a hyphen between first and second word
    $this->slug = implode('-', $faker->words($faker->numberBetween(1, 5)));
  }

  // Set to a view level for this item: 1 is "Public", 2 is "Registered", etc.
  public function access ($config, $faker)
  {
    $this->access = 1;
  }

  // Set 10% of records to trashed (-2), 10% to archived (-1),
  // 10% to unpublished (0), and rest to published (1).
  public function enabled ($config, $faker)
  {
    switch ($faker->numberBetween(1, 10)) {
      case 1:
        $this->enabled = -2;
        break;
      case 2:
        $this->enabled = -1;
        break;
      case 2:
        $this->enabled = 0;
        break;
      default:
        $this->enabled = 1;
    }
  }

  // Common relation fields
  public function metadata ($config, $faker)
  {
    // @TODO: not saving correctly, same problem in model field with attribute handlers
    $this->metadata = '{"robots":"index, follow","author":"' . $faker->name . '"}';
  }

  public function metakey ($config, $faker)
  {
    $this->metakey = implode(', ', $faker->words($faker->numberBetween(1, 5)));
  }

  public function metadesc ($config, $faker)
  {
    $this->metadesc = $faker->sentence($faker->numberBetween(6, 15));
  }

  public function xreference ($config, $faker)
  {
    $this->xreference = null;
  }

  public function params ($config, $faker)
  {
    $this->params = '{"image":"","image_alt":""}';
  }

  public function cat_id ($config, $faker)
  {
    foreach ($config->categories as $category)
    {
      if ($category->title = 'uncategorised')
      {
        $this->cat_id = $category->id;
        return;
      }
    }

    $this->cat_id = null;
  }

  public function hits ($config, $faker)
  {
    $this->hits = $faker->numberBetween(0, 100);
  }

  // Set 10% of records to be featured
  public function featured ($config, $faker)
  {
    switch ($faker->numberBetween(1, 10)) {
      case 1:
        $this->featured = true;
        break;
      default:
        $this->featured = false;
    }
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

  public function modified_by ($config, $faker)
  {
    $this->modified_by = 0;
  }
}
