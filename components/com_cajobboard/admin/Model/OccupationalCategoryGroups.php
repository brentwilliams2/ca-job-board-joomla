<?php
/**
 * Admin Occupational Category Groups Model
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

use \FOF30\Container\Container;
use \Calligraphic\Cajobboard\Admin\Model\BaseModel;

/**
 * Model class description
 *
 * Fields:
 *
 * @property int      $job_occupational_category_group_id    Surrogate primary key
 * @property string   $slug                       Alias for SEF URL
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
 * SCHEMA: Thing
 * @property string   $description                Occupational category group description
 * @property string   $url                        Link to schema for occupational category, e.g. wikipedia page on Full Time
 * SCHEMA: https://calligraphic.design/schema/OccupationalCategoryBLS
 * @property string   $group                      Name this occupational category should be shown under e.g. office staff
  */
class OccupationalCategoryGroups extends BaseModel
{
  use Mixin\Assertions;

	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    // Not using convention for table names or primary key field
		$config['tableName'] = '#__cajobboard_occupational_category_groups';
    $config['idFieldName'] = 'occupational_category_group_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.occupational_groups';

    // Set an alias for the title field for DataModel's check() method's slug field auto-population
    $config['aliasFields'] = array('title' => 'group');

    parent::__construct($container, $config);

    // Add behaviours to the model. Filters, Created, and Modified behaviours are added automatically.
    $config['behaviours'] = array(
      //'Access',     // Filter access to items based on viewing access levels
      //'Assets',     // Add Joomla! ACL assets support
      //'Category',   // Set category in new records
      'Check',      // Validation checks for model, over-rideable per model
      //'ContentHistory', // Add Joomla! content history support
      'Enabled',    // Filter access to items based on enabled status
      'Language',   // Filter front-end access to items based on language
      'Metadata',   // Set the 'metadata' JSON field on record save
      'Ordering',   // Order items owned by featured status and then descending by date
      //'Own',        // Filter access to items owned by the currently logged in user only
      //'PII',        // Filter access for items that have Personally Identifiable Information
      //'Publish',    // Set the publish_on field for new records
      //'Slug',       // Backfill the slug field with the 'title' property or its fieldAlias if empty
      'Tags'        // Add Joomla! Tags support
    );
  }

	/**
	 * Perform checks on data for validity
	 *
	 * @return  static  Self, for chaining
	 *
	 * @throws \RuntimeException  When the data bound to this record is invalid
	 */
	public function check()
	{
    $this->assertNotEmpty($this->description, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_ERR_TITLE');
    $this->assertNotEmpty($this->url, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_ERR_CODE');
    $this->assertNotEmpty($this->group, 'COM_CAJOBBOARD_OCCUPATIONAL_CATEGORY_ERR_GROUP');

		parent::check();

    return $this;
	}
}
