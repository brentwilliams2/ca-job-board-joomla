<?php
/**
 * Base Admin Hierarchical Nested List Model for all Job Board Models
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c) 2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model;

// no direct access
defined('_JEXEC') or die;

use \FOF30\Container\Container;
use \FOF30\Model\TreeModel;
use \Calligraphic\Cajobboard\Admin\Model\Helper\TableFields;

/**
 * Model class description
 */
class BaseTreeModel extends TreeModel
{
  /* Traits to include in the class */

  use Mixin\Archive;              // Over-ridden 'archive' method
  use Mixin\Assertions;           // Convenient assertions, e.g. for use in validation / check methods
  use Mixin\Asset;                // Joomla! role-based access control handling
  use Mixin\Comments;             // 'saveComment' method
  use Mixin\Constructor;          // Refactored base-class constructor, called from __construct method
  use Mixin\Core;                 // Utility methods
  use Mixin\Count;                // Overridden count() method to cache value
  use Mixin\FieldStateMachine;    // Toggle method for boolean fields
  use Mixin\JsonData;             // Methods for transforming between JSON-encoded strings and Registry objects
  use Mixin\TableFields;          // Use an array of table fields instead of database reads on each table
  use Mixin\Validation;           // Provides over-ridden 'check' method

  // Transformations for model properties (attributes) to an appropriate data type (e.g.
  // Registry objects). Validation checks and setting attribute values from state should
  // be done in Behaviours (which can be enabled and overridden per model).

  use Mixin\Attributes\Image;     // Attribute getter / setter
  use Mixin\Attributes\Metadata;  // Attribute getter / setter
  use Mixin\Attributes\Params;    // Attribute getter / setter

  /*
    SQL:
      lft INT,
      rgt INT,
      `hash` CHAR(40),
      INDEX lft (lft),
      INDEX rgt (rgt),
      INDEX composite_lft_rgt (lft, rgt),
      INDEX `hash` (`hash`),
  */

 	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    // Add behaviours to the model. Filters, Created, and Modified behaviours are added automatically.
    $behaviours = array(
      'Category',   // Set category in new records
      'Check',      // Validation checks for model, over-rideable per model
      'Enabled',    // Filter access to items based on enabled status
      'Language',   // Filter front-end access to items based on language
      'Ordering',   // Order items owned by featured status and then descending by date
      'Publish',    // Set the publish_on field for new records
      'Slug',       // Backfill the slug field with the 'title' property or its fieldAlias if empty

      /* Model property (attribute) Behaviours for validation and setting value from state */
      'Image',              // Set the 'image' JSON field on record save
      'DescriptionIntro',   // Check the length of the 'description__intro' field
      'Metadata',           // Set the 'metadata' JSON field on record save
      'Title',              // Check length and titlecase the 'metadata' JSON field on record save
    );

    // Merge any behaviours passed from the child model into our base class default behaviours
    if ( array_key_exists('behaviours', $config) )
    {
      $config['behaviours'] = array_merge($config['behaviours'], $behaviours);
    }
    else
    {
      $config['behaviours'] = $behaviours;
    }

    /* Overridden constructor */
    $this->constructor($container, $config);
  }
}



