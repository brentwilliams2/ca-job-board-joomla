<?php
/**
 * Admin Reports Model
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
use \Calligraphic\Cajobboard\Admin\Model\BaseModel;

/**
 * Fields:
 *
 * UCM
 * @property int            $report_id            Surrogate primary key.
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
 * @property int      $version                    Version of this item.
 * @property int      $ordering                   Order this record should appear in for sorting.
 * @property object   $metadata                   JSON encoded metadata field for this item.
 * @property string   $metakey                    Meta keywords for this item.
 * @property string   $metadesc                   Meta descriptionfor this item.
 * @property string   $xreference                 A reference to enable linkages to external data sets, used to output a meta tag like FB open graph.
 * @property string   $params                     JSON encoded parameters for the content item.
 * @property string   $language                   The language code for the article or * for all languages.
 * @property int      $cat_id                     Category ID for this content item.
 * @property int      $hits                       Number of hits the content item has received on the site.
 * @property int      $featured                   Whether this content item is featured or not.
 * SCHEMA: Thing
 * @property string   $name                       A title or header for this report.
 * @property string   $description                A short description of this report.
 * SCHEMA: CreativeWork
 * @property string   $about__model               The foreign model name the item of this report refers to, e.g. Answers.
 * @property int      $about__id                  The primary key of the foreign model the item of this report refers to.
 * @property string   $keywords                   The reasons this content is being reported. Use table #__cajobboard_report_reasons to populate in views..
 * @property string   $text                       The actual text of this report.
 */
class Reports extends BaseModel
{
  use \FOF30\Model\Mixin\Assertions;

	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    // Not using convention for table names or primary key field
		$config['tableName'] = '#__cajobboard_reports';
    $config['idFieldName'] = 'report_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.reports';

    // Set an alias for the title field for DataModel's check() method's slug field auto-population
    $config['aliasFields'] = array('title' => 'name');

    // Add behaviours to the model. Filters, Created, and Modified behaviours are added automatically.
    $config['behaviours'] = array(
      'Access',     // Filter access to items based on viewing access levels
      'Assets',     // Add Joomla! ACL assets support
      'Category',   // Set category in new records
      'Check',      // Validation checks for model, over-rideable per model
      //'ContentHistory', // Add Joomla! content history support
      'Enabled',    // Filter access to items based on enabled status
      'Language',   // Filter front-end access to items based on language
      'Metadata',   // Set the 'metadata' JSON field on record save
      'Ordering',   // Order items owned by featured status and then descending by date
      //'Own',        // Filter access to items owned by the currently logged in user only
      //'PII',        // Filter access for items that have Personally Identifiable Information
      'Publish',    // Set the publish_on field for new records
      'Slug',       // Backfill the slug field with the 'title' property or its fieldAlias if empty
      //'Tags'        // Add Joomla! Tags support
    );

    parent::__construct($container, $config);

    /* Set up relations after parent constructor */

    // one-to-one FK to  #__cajobboard_persons
    $this->hasOne('Author', 'Persons@com_cajobboard', 'created_by', 'id');
  }


  /**
	 * Get the item that is reported as abusive content.
   *
   * @param   array   $modelName  The model name of the item reported as abusive content.
   * @param   array   $itemId     The primary key of the item reported as abusive content.
	 *
	 * @return  @TODO: What to return? HTML rendered from a view, or a model object?
	 */
	public function getReportedContentItem($modelName, $itemId)
	{
    // @TODO: implement
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
    $this->assertNotEmpty($this->name, 'COM_CAJOBBOARD_REPORT_ERR_TITLE');
    $this->assertNotEmpty($this->description, 'COM_CAJOBBOARD_REPORT_ERR_DESCRIPTION');
    $this->assertNotEmpty($this->about__model, 'COM_CAJOBBOARD_REPORT_ERR_ABOUT_MODEL');
    $this->assertNotEmpty($this->about__id, 'COM_CAJOBBOARD_REPORT_ERR_ABOUT_ID');
    $this->assertNotEmpty($this->keywords, 'COM_CAJOBBOARD_REPORT_ERR_REASON_NOT_PREDEFINED');
    $this->assertNotEmpty($this->text, 'COM_CAJOBBOARD_REPORT_ERR_TEXT');

    // @TODO: Make sure about__model has a valid DataModel name

    // @TODO: Make sure keywords is in #__cajobboard_report_reasons

		parent::check();

    return $this;
  }
}
