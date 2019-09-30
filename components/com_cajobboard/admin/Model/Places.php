<?php
/**
 * Admin Places Model
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
use \Calligraphic\Cajobboard\Admin\Model\BaseDataModel;

/*
 * Fields:
 *
 * UCM
 * @property int            $place_id                       Surrogate primary key.
 * @property string         $slug                           Alias for SEF URL
 * FOF "magic" fields
 * @property int            $asset_id                       FK to the #__assets table for access control purposes.
 * @property int            $access                         The Joomla! view access level.
 * @property int            $enabled                        Publish status: -2 for trashed and marked for deletion, -1 for archived, 0 for unpublished, and 1 for published.
 * @property string         $created_on                     Timestamp of record creation, auto-filled by save().
 * @property int            $created_by                     User ID who created the record, auto-filled by save().
 * @property string         $modified_on                    Timestamp of record modification, auto-filled by save(), touch().
 * @property int            $modified_by                    User ID who modified the record, auto-filled by save(), touch().
 * @property string         $locked_on                      Timestamp of record locking, auto-filled by lock(), unlock().
 * @property int            $locked_by                      User ID who locked the record, auto-filled by lock(), unlock().
 * SCHEMA: Joomla UCM fields, used by Joomla!s UCM when using the FOF ContentHistory behaviour
 * @property string         $publish_up                     Date and time to change the state to published, schema.org alias is datePosted.
 * @property string         $publish_down                   Date and time to change the state to unpublished.
 * @property int            $version                        Version of this item.
 * @property int            $ordering                       Order this record should appear in for sorting.
 * @property object         $metadata                       JSON encoded metadata field for this item.
 * @property string         $metakey                        Meta keywords for this item.
 * @property string         $metadesc                       Meta descriptionfor this item.
 * @property string         $xreference                     A reference to enable linkages to external data sets, used to output a meta tag like FB open graph.
 * @property string         $params                         JSON encoded parameters for the content item.
 * @property string         $language                       The language code for the article or * for all languages.
 * @property int            $cat_id                         Category ID for this content item.
 * @property int            $hits                           Number of hits the content item has received on the site.
 * @property int            $featured                       Whether this content item is featured or not.
 * SCHEMA: Thing
 * @property string         $name                           A name for this place.
 * @property string         $description                    A long description of this place.
 * SCHEMA: PostalAddress
 * @property  string	      $branch_code                    A short textual code that uniquely identifies a place of business.
 * @property  string	      $fax_number                     The E.164 PSTN fax number.
 * @property  bool		      $public_access                  A flag to signal that the Place is open to public visitors. If this property is omitted there is no assumed default boolean value.
 * SCHEMA: Place (geo) -> GeoCoordinates NOTE: https://schema.org/GeoCoordinates has separate latitude, longitude properties instead of using GIS point.
 * @property  int   	      $geo                            Latitude and longitude of place using MySQL GIS spatial data type. FK to #__cajobboard_geo_coordinates(geo_coordinate_id)
 * Place (address) -> PostalAddress
 * @property  string	      $address__country               The two-letter ISO 3166-1 alpha-2 country code.
 * @property  string	      $address__locality              The locality, e.g. Mountain View.
 * @property  string	      $address__postal_code           The postal code, e.g. 94043.
 * @property  string	      $address__street_address        The street address, e.g. 1600 Amphitheatre Pkwy.
 * @property  string        $telephone                      The E.164 PSTN telephone number.
 * @property  string	      $opening_hours_specification    The days and times this location is open.
 * RELATIONS
 * @property  int			      $Logo                           A logo image that represents this place. FK to #__cajobboard_images(image_id)
 * @property  int			      $Photo                          One or more photographs of this place. FK M:M relationship in to #__cajobboard_images(image_id)
 */
class Places extends BaseDataModel
{
	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    // override default table names and primary key id
		$config['tableName'] = '#__cajobboard_places';
    $config['idFieldName'] = 'place_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.places';

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
      'Tags'        // Add Joomla! Tags support
    );

    parent::__construct($container, $config);

    /* Set up relations after parent constructor */

    // one-to-one FK to  #__cajobboard_persons
    $this->hasOne('Author', 'Persons@com_cajobboard', 'created_by', 'id');

    // many-to-one FK to  #__cajobboard_address_regions
    $this->belongsTo('AddressRegion', 'AddressRegions@com_cajobboard', 'address__region', 'address_region_id');

    // many-to-one FK to  #__cajobboard_geo_coordinates
    $this->belongsTo('Geo', 'GeoCoordinates@com_cajobboard', 'geo', 'geo_coordinate_id');

    // many-to-one FK to  #__cajobboard_image_objects
    $this->belongsTo('Logo', 'ImageObjects@com_cajobboard', 'logo', 'image_object_id');

    // many-to-many FK to  #__cajobboard_image_objects via join table
    $this->belongsToMany('Photo', 'ImageObjects@com_cajobboard', 'place_id', 'image_object_id', '#__cajobboard_places_images');
  }
}
