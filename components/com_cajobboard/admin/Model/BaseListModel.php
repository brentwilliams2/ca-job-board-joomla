<?php
/**
 * Base Admin List Model for all Job Board Models
 *
 * This base model is intended for support models that allow relations to core models.
 * Use for modeling lists, enums, categories, types, and the like. It is intended to be
 * simpler than either the data or hierarchical (tree) base models.
 *
 * @package   Calligraphic Job Board
 * @version   July 2, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic
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
class BaseListModel extends DataModel
{
  // Traits to include in the class
  use Mixin\Assertions;
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
      'Check',      // Validation checks for model, over-rideable per model
      'Enabled',    // Filter access to items based on enabled status
      'Language',   // Filter front-end access to items based on language
      'Ordering',   // Order items owned by featured status and then descending by date
      'Publish',    // Set the publish_on field for new records
      'Slug'        // Backfill the slug field with the 'title' property or its fieldAlias if empty
    );

    // Merge any behaviours passed from the child model into our base class default behaviours
    $config['behaviours'] = array_merge($config['behaviours'], $behaviours);

    /* Parent constructor */
    parent::__construct($container, $config);
  }
}
