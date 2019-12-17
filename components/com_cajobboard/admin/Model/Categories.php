<?php
/**
 * Admin Categories Model
 *
 * Allows using Joomla! com_categories as relations for FOF models
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model;

// no direct access
defined( '_JEXEC' ) or die;

use \Calligraphic\Cajobboard\Admin\Model\BaseTreeModel;
use \FOF30\Container\Container;

/**
 * Fields:
 *
 * @property  int     $id                 Surrogate primary key
 * @property  int     $asset_id           FK to the #__assets table.
 * @property  int     $parent_id          Parent category of this category, FK to the #__categories table
 * @property  int     $lft                Nested table left
 * @property  int     $rgt                Nested table right
 * @property  int     $level              Nesting level in hierarchy
 * @property  string  $path               Breadcrumb of parent categories and this category, forward-slash separated
 * @property  string  $extension          Name of the extension the category applies to
 * @property  string  $title 	            Name of the category
 * @property  string  $alias 	            Slug for SEO-friendly URLs to this category's page
 * @property  string  $note 	            Extra information about this category
 * @property  string  $description        Long description of the category
 * @property  bool    $published          Whether this category is published
 * @property  bool    $checked_out        When checked out for editing
 * @property  string  $checked_out_time   Time checked out for editing
 * @property  int     $access             Joomla! access rules
 * @property  string  $params             Parameters for this category, defined in admin/models/forms/category.xml
 * @property  string  $metadesc           The meta description for the page.
 * @property  string  $metakey            The meta keywords for the page.
 * @property  string  $metadata           JSON encoded metadata properties.
 * @property  int     $created_user_id    User who created this category, FK to #__users
 * @property  string  $created_time 	    Date this category was created
 * @property  int     $modified_user_id   User who created this category, FK to #__users
 * @property  string  $modified_time 	    Date this category was modified
 * @property  int     $hits 	            Number of hits this category has received
 * @property  string  $language 	        Language for this category or '*' for all
 * @property  string  $version            Version history for this category
 */
class Categories extends BaseTreeModel
{
  /* Traits to include in the class */

  // Transformations for model properties (attributes) to an appropriate data type (e.g.
  // Registry objects). Validation checks and setting attribute values from state should
  // be done in Behaviours (which can be enabled and overridden per model).

  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Attributes\Metadata;  // Attribute getter / setter
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Attributes\Params;    // Attribute getter / setter

  /*
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws NoTableColumns
   */
	public function __construct(Container $container, array $config = array())
	{
		$config['tableName'] = '#__categories';
    $config['idFieldName'] = 'id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.categories';

    // Set field aliases: $alias => $realName
    $config['aliasFields'] = array(
      'created_by' => 'created_user_id',
      'created_on' => 'created_time',
      'enabled' => 'published',
      'locked_by' => 'checked_out_time',
      'locked_on' => 'checked_out',
      'modified_by' => 'modified_user_id',
      'modified_on' => 'modified_time',
      'slug' => 'alias',
    );

    // Add behaviours to the model. 'Filters' behaviour added by default in addBehaviour() method.
    $config['behaviours'] = array(

      /* Core UCM field behaviours */

      'Access',             // Filter access to items based on viewing access levels
      'Assets',             // Add Joomla! ACL assets support
      'Category',           // Set category in new records
      'Created',            // Update the 'created_by' and 'created_on' fields for new records
      'ContentHistory',     // Add Joomla! content history support
      'Enabled',            // Filter access to items based on enabled status
      'Hits',               // Add tracking for number of item views
      'Language',           // Filter front-end access to items based on language
      'Locked',             // Add 'locked_on' and 'locked_by' fields to skip fields check
      'Modified',           // Update the 'modified_by' and 'modified_on' fields for new records
      'Note',               // Add 'note' field to skip fields check
      //'Own',                // Filter access to items owned by the currently logged in user only
      'Params',             // Add 'params' field to skip fields check
      //'PII',                // Filter access for items that have Personally Identifiable Information.
      'Slug',               // Backfill the slug field with the 'title' property or its fieldAlias if empty
      //'Tags',               // Add Joomla! Tags support

      /* Validation checks. Single slash is escaped to a double slash in over-ridden addBehaviour() method in Model/Mixin/Patches.php */

      'Check',              // Validation checks for model, over-rideable per model
      'Check/Metadata',     // Set the 'metadata' JSON field on record save
      'Check/Title',        // Check length and titlecase the 'metadata' JSON field on record save
    );

    parent::__construct($container, $config);
  }
}
