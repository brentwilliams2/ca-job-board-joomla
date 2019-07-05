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

use \FOF30\Model\DataModel;

/**
 * Model class description
 */
class BaseTreeModel extends TreeModel
{
  // Traits to include in the class
  use Mixin\Archive;
  use Mixin\Assertions;
  use Mixin\Asset;
  use Mixin\Attributes;
  use Mixin\Comments;
  use Mixin\Core;
  use Mixin\JsonData;
  use Mixin\Validation;


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
      'Metadata',   // Set the 'metadata' JSON field on record save
      'Ordering',   // Order items owned by featured status and then descending by date
      'Publish',    // Set the publish_on field for new records
      'Slug'        // Backfill the slug field with the 'title' property or its fieldAlias if empty
    );

    // Merge any behaviours passed from the child model into our base class default behaviours
    $config['behaviours'] = array_merge($config['behaviours'], $behaviours);

    /* Parent constructor */
    parent::__construct($container, $config);
  }


  /**
	 * Alias for belongsTo() relation. FOF has a hasOne() relation, where the relation field is
   * in the foreign table and allowing 1 : 0..1 relations with a NOT NULL FK field. This method
   * is included to clearly indicate intent for 0..1 : 1 relations with nullable FK fields. The
   * need for this is due to following Schema.org entity schemas, where many properties are
   * logically single references, like "employmentType" referencing an enumerated list, even
   * though all Schema.org properties allow collections (FOF belongsTo).
	 *
	 * @return   $this  For chaining
	 */
  public function inverseSideOfHasOne(string $name, string $foreignModelClass = null, string $localKey = null, string $foreignKey = null)
  {
    $this->belongsTo($name, $foreignModelClass, $localKey, $foreignKey);
  }
}
