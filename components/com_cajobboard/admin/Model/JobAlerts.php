<?php
/**
 * Admin Alerts Model
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
 * Fields:
 *
 * UCM
 * @property int            $job_alert_id     Surrogate primary key.
 * @property string         $slug             Alias for SEF URL.
 *
 * FOF "magic" fields
 * @property bool           $featured         Whether this alert is featured or not.
 * @property int            $hits             Number of hits this alert has received.
 * @property int            $created_by       Userid of the creator of this alert.
 * @property string         $createdOn        Date this alert was created.
 * @property int            $modifiedBy       Userid of person that last modified this alert.
 * @property string         $modifiedOn       Date this alert was last modified.
 *
 * SCHEMA: Joomla UCM fields, used by Joomla!s UCM when using the FOF ContentHistory behaviour
 * @property string         $publish_up       Date and time to change the state to published, schema.org alias is datePosted.
 * @property string         $publish_down     Date and time to change the state to unpublished.
 * @property int            $ordering         Order this record should appear in for sorting.
 * @property object         $metadata         JSON encoded metadata field for this item.
 * @property string         $metakey          Meta keywords for this item.
 * @property string         $metadesc         Meta description for this item.
 * @property string         $xreference       A reference to enable linkages to external data sets, used to output a meta tag like FB open graph.
 * @property string         $params           JSON encoded parameters for this item.
 * @property string         $language         The language code for the article or * for all languages.
 * @property int            $cat_id           Category ID for this item.
 * @property int            $hits             Number of hits the item has received on the site.
 * @property int            $featured         Whether this item is featured or not.
 *
 * SCHEMA: Thing
 * @property string         $name             A title to use for the alert.
 * @property string         $description      A description of the alert.
 *
 * SCHEMA: https://schema.org/GeoCoordinates
 * @property  GeoCoordinates $geo_coordinate  The geographic coordinates of the center of the job seeker's search radius, FK to #__cajobboard_geo_coordinates
 *
 * SCHEMA: https://schema.org/geoRadius
 * @property int            $geo_radius       The distance in miles to search for jobs from the job seeker's search radius center point.
 *
 * SCHEMA: https://schema.org/occupationalCategory
 * @property OccupationalCategories $occupational_category   A category describing the job, FK to #__cajobboard_occupational_categories
 *
 * SCHEMA: https://schema.org/keywords
 * @property JSON           $keywords         Used to filter jobs shown for this alert. Should be a case-insensitive array of keywords, e.g. [ "great customers", "friendly", "fun" ]
 */
class JobAlerts extends BaseModel
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
    /* Set up config before parent constructor */

    // Not using convention for table names or primary key field
		$config['tableName'] = '#__cajobboard_job_alerts';
    $config['idFieldName'] = 'job_alert_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.job_alerts';

    // Set an alias for the title field for DataModel's check() method's slug field auto-population
    $config['aliasFields'] = array('title' => 'name');

    // Add behaviours to the model. Filters, Created, and Modified behaviours are added automatically.
    $config['behaviours'] = array(
      'Access',     // Filter access to items based on viewing access levels
      'Assets',     // Add Joomla! ACL assets support
      'Category',   // Set category in new records
      'Check',      // Validation checks for model, over-rideable per model
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

    /* Parent constructor */
    parent::__construct($container, $config);

    /* Set up relations after parent constructor */

    // one-to-one FK to #__cajobboard_geo_coordinates
    $this->inverseSideOfHasOne('GeoCoordinates', 'GeoCoordinates@com_cajobboard', 'geo_coordinate', 'geo_coordinate_id');

    // one-to-one FK to #__cajobboard_occupational_categories
    $this->inverseSideOfHasOne('OccupationalCategories', 'OccupationalCategories@com_cajobboard', 'occupational_category', 'occupational_category_id');
  }

  /**
	 *
	 */
	public function doSomethingGeoRelated()
	{
    // @TODO: Creates alert for jobs within X miles for same job category
  }


  /**
	 *
	 */
	public function getCityCenter()
  {
    /*
      1. Job seeker / employer enters a city name via a text input rather than a drop-down box of cities to select from.
      2. They are offered suggestions as they type, like the way Google's search feature works.
      3. A map shows with a pin over where I think they're talking about.
      4. If it's wrong (two towns with the same name for example), they can click on the map and I'll detect the closest town name.
      5. I use a default radius (maybe 20 miles?) for them, and they can change the radius if they want.
    */
  }


  /**
	 * Purge old job alerts
	 */
	public function purgeExpiredJobAlerts($duration)
	{
    // @TODO: Purge job alerts that are older than $duration
  }


  /**
	 * Transform 'keyword' field to an associative array on bind
	 *
	 * @return  static  Self, for chaining
	 *
	 * @throws \RuntimeException  When the data bound to this record is invalid
	 */
  protected function getKeywordsAttribute($value)
  {
    // Make sure it hasn't already been transformed
    if ( is_array($value) )
    {
        return $value;
    }

    $array = json_decode($value, true);

    if ( json_last_error() != JSON_ERROR_NONE )
    {
      throw new \Exception( 'Error in JobAlerts model while transforming keyword table field JSON to array: ' . json_last_error_msg() );
    }

    return $array;
  }


  /**
	 * Transform 'keyword' field array to a JSON string before save
	 *
	 * @return  static  Self, for chaining
	 *
	 * @throws \RuntimeException  When the data bound to this record is invalid
	 */
  protected function setKeywordsAttribute($value)
  {
    $json = json_encode($value);

    if ( json_last_error() != JSON_ERROR_NONE )
    {
      throw new \Exception( 'Error in JobAlerts model while transforming keyword property array to JSON: ' . json_last_error_msg() );
    }

    return $json;
  }


  /**
	 * @throws    \RuntimeException when the assertion fails
	 *
	 * @return    $this   For chaining.
	 */
	public function check()
	{
    $this->assertNotEmpty($this->name, 'COM_CAJOBBOARD_JOB_ALERTS_TITLE_ERR');

		parent::check();

    return $this;
  }
}
