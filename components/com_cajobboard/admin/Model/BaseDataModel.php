<?php
/**
 * Base Admin DataModel for all Job Board Models
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
use \FOF30\Model\DataModel;
use \FOF30\Model\DataModel\Exception\NoAssetKey;
use \Calligraphic\Cajobboard\Admin\Model\Helper\TableFields;

/**
 * Model class description
 */
class BaseDataModel extends DataModel
{
  /* Traits to include in the class */

  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Archive;              // Over-ridden 'archive' method
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Assertions;           // Convenient assertions, e.g. for use in validation / check methods
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Asset;                // Joomla! role-based access control handling
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Comments;             // 'saveComment' method
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Constructor;          // Refactored base-class constructor, called from __construct method
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Core;                 // Utility methods
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Count;                // Overridden count() method to cache value
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\FieldStateMachine;    // Toggle method for boolean fields
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\JsonData;             // Methods for transforming between JSON-encoded strings and Registry objects
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\TableFields;          // Use an array of table fields instead of database reads on each table
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Validation;           // Provides over-ridden 'check' method

  // Transformations for model properties (attributes) to an appropriate data type (e.g.
  // Registry objects). Validation checks and setting attribute values from state should
  // be done in Behaviours (which can be enabled and overridden per model).

  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Attributes\Image;     // Attribute getter / setter
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Attributes\Metadata;  // Attribute getter / setter
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Attributes\Params;    // Attribute getter / setter

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


	/**
   * @TODO: Overridden to fix logic error. Submit PR. See BaseListModel and BaseTreeModel.
	 * Method to compute the default name of the asset item (in table #__assets).
	 *
	 * @throws  NoAssetKey
	 *
	 * @return  string
	 */
	public function getAssetName()
	{
		// If there is no assetKey defined, stop here, or we'll get a wrong name
		if (!$this->_assetKey)
		{
			throw new NoAssetKey;
		}

		// e.g. com_cajobboard.answer.2
		return $this->_assetKey . '.' . $this->getId();
	}
}
