<?php
/**
 * Admin Employment Types Model
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
defined('_JEXEC') or die;

use FOF30\Container\Container;
use \Calligraphic\Cajobboard\Admin\Model\Interfaces\Core;
use \Calligraphic\Cajobboard\Admin\Model\Interfaces\Extended;
use \Calligraphic\Cajobboard\Admin\Model\Interfaces\Social;
use \Calligraphic\Cajobboard\Admin\Model\BaseDataModel;

/**
 * Fields:
 *
 * @property int      $job_employment_type_id   Surrogate primary key
 * @property string   $slug                       Alias for SEF URL
 *
 * FOF "magic" fields
 * @property int      $asset_id                   FK to the #__assets table for access control purposes.
 * @property int      $access                     The Joomla! view access level.
 * @property int      $enabled                    Publish status: -2 for trashed and marked for deletion, -1 for archived, 0 for unpublished, and 1 for published.
 * @property string   $created_on                 Timestamp of record creation, auto-filled by save().
 * @property int      $created_by                 User ID who created the record, auto-filled by save().
 * @property string   $modified_on                Timestamp of record modification, auto-filled by save(), touch().
 * @property int      $modified_by                User ID who modified the record, auto-filled by save(), touch().
 * @property string   $locked_on                  Timestamp of record locking, auto-filled by lock(), unlock().
 * @property int      $locked_by                  User ID who locked the record, auto-filled by lock(), unlock().
 *
 * SCHEMA: Joomla UCM fields, used by Joomla!s UCM when using the FOF ContentHistory behaviour
 * @property string   $publish_up                 Date and time to change the state to published, schema.org alias is datePosted.
 * @property string   $publish_down               Date and time to change the state to unpublished.
 * @property int      $ordering                   Order this record should appear in for sorting.
 * @property object   $metadata                   JSON encoded metadata field for this item.
 * @property string   $metakey                    Meta keywords for this item.
 * @property string   $metadesc                   Meta description for this item.
 * @property string   $xreference                 A reference to enable linkages to external data sets, used to output a meta tag like FB open graph.
 * @property string   $params                     JSON encoded parameters for this item.
 * @property string   $language                   The language code for the article or * for all languages.
 * @property int      $cat_id                     Category ID for this item.
 * @property int      $hits                       Number of hits the item has received on the site.
 * @property int      $featured                   Whether this item is featured or not.
 *
 * SCHEMA: Thing
 * @property string   $name                       Type of employment (e.g. full-time, part-time, contract, temporary, seasonal, internship)
 * @property string   $description                Detailed description about type of employment
 * @property string   $url                        Link to schema for type of employment, e.g. wikipedia page on Full Time
 */
class EmploymentTypes extends BaseDataModel implements Core, Extended, Social
{
	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    // Not using convention for table names or primary key field
		$config['tableName'] = '#__cajobboard_employment_types';
    $config['idFieldName'] = 'employment_type_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.employment_types';

    // Set an alias for the title field for DataModel's check() method's slug field auto-population
    $config['aliasFields'] = array('title' => 'name');

    // Add behaviours to the model. Filters, Created, and Modified behaviours are added automatically.
    $config['behaviours'] = array(

      /* Core UCM field behaviours */

      'Access',             // Filter access to items based on viewing access levels
      'Assets',             // Add Joomla! ACL assets support
      'Category',           // Set category in new records
      'Created',            // Update the 'created_by' and 'created_on' fields for new records
      //'ContentHistory',     // Add Joomla! content history support
      'Enabled',            // Filter access to items based on enabled status
      'Featured',           // Add support for featured items
      'Language',           // Filter front-end access to items based on language
      'Locked',             // Add 'locked_on' and 'locked_by' fields to skip fields check
      'Modified',           // Update the 'modified_by' and 'modified_on' fields for new records
      'Note',               // Add 'note' field to skip fields check
      'Ordering',           // Order items owned by featured status and then descending by date
      //'Own',                // Filter access to items owned by the currently logged in user only
      'Params',             // Add 'params' field to skip fields check
      //'PII',                // Filter access for items that have Personally Identifiable Information.
      'Publish',            // Set the 'publish_on' field for new records
      'Slug',               // Backfill the slug field with the 'title' property or its fieldAlias if empty
      //'Tags',               // Add Joomla! Tags support

      /* Validation checks. Single slash is escaped to a double slash in over-ridden addBehaviour() method in Model/Mixin/Core.php */

      'Check',              // Validation checks for model, over-rideable per model
      'Check/Metadata',     // Set the 'metadata' JSON field on record save

      /* Model property (attribute) Behaviours for validation and setting value from state */

      'DescriptionIntro',   // Check the length of the 'description__intro' field
    );

    parent::__construct($container, $config);
  }
}
