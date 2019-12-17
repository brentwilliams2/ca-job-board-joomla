<?php
/**
 * Base Admin DataModel for all Job Board Models
 *
 * @package   Calligraphic Job Board
 * @version   May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model;

// no direct access
defined('_JEXEC') or die;

use \Calligraphic\Cajobboard\Admin\Model\Helper\TableFields;
use \FOF30\Container\Container;
use \FOF30\Model\TreeModel;

/**
 * Model class description
 */
class BaseTreeModel extends TreeModel
{
  /* Core trait methods to include in all models */

  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Constructor;          // Refactored base-class constructor, called from __construct method
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Core;                 // Utility methods
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Count;                // Overridden count() method to cache value
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Patches;              // Over-ridden FOF30 DataModel methods (some with PRs)
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\TableFields;          // Use an array of table fields instead of database reads on each table
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Validation;           // Provides over-ridden 'check' method

  /* Convenience trait methods that can be applied to all models, whether used or not */

  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Asset;                // Joomla! role-based access control handling
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\FieldStateMachine;    // Toggle method for boolean fields
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\JsonData;             // Methods for transforming between JSON-encoded strings and Registry objects

 	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    // @TODO: FOR TREE MODEL PROBLEM -- Do not populate the model from the request
    // @TODO: this is set because otherwise all fields set from model input in the last save are
    //        set on the state, and the Filter behaviour will automatically filter against them
    //        e.g. setting a WHERE clause on the 'description' field string value (so no items
    //        will return in browse view). Not sure why this is happening, and why it doesn't in
    //        in normal DataModel BaseHtml class with similar onBeforeBrowse() methods. This
    //        will probably cause pagination to fail.
    $config['ignore_request'] = true;

    // Add the Tree behaviour to the behaviour array passed from the model, adds nested set fields to skip fields on validation
    $config['behaviours'] = array_merge( $config['behaviours'], array('Tree') );

    /* Overridden constructor */
    $this->constructor($container, $config);
  }


  /**
   * @TODO: need to unlock record, doesn't seem to be happening after initial save automatically? Shouldn't this be a behaviour?
   *
   * @return void
   */
  public function onAfterSave()
  {

  }
}
