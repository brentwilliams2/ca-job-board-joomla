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

use FOF30\Container\Container;
use \Calligraphic\Cajobboard\Admin\Model\BaseModel;

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
class Categories extends BaseModel
{
// @TODO: See note in ImageObjects model about whether this model is needed, or we could use JTable\Categories instead

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

    parent::__construct($container, $config);

    // Add behaviours to the model. Filters, Created, and Modified behaviours are added automatically.
    $config['behaviours'] = array(
      //'Access',     // Filter access to items based on viewing access levels
      //'Assets',     // Add Joomla! ACL assets support
      //'Category',   // Set category in new records
      //'Check',      // Validation checks for model, over-rideable per model
      //'ContentHistory', // Add Joomla! content history support
      'Enabled',    // Filter access to items based on enabled status
      'Language',   // Filter front-end access to items based on language
      'Metadata',   // Set the 'metadata' JSON field on record save
      'Ordering',   // Order items owned by featured status and then descending by date
      //'Own',        // Filter access to items owned by the currently logged in user only
      //'PII',        // Filter access for items that have Personally Identifiable Information
      //'Publish',    // Set the publish_on field for new records
      //'Slug',       // Backfill the slug field with the 'title' property or its fieldAlias if empty
      //'Tags'        // Add Joomla! Tags support
    );

		// Do not run automatic value validation of data before saving it.
    $this->autoChecks = false;
  }
}
