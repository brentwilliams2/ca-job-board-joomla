<?php
/**
 * Admin Image Objects Model
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

/*
 * Fields:
 *
 * UCM
 * @property int            $image_object_id    Surrogate primary key.
 * @property string         $slug               Alias for SEF URL.
 * @property bool           $featured           Whether this answer is featured or not.
 * @property int            $hits               Number of hits this answer has received.
 * @property int            $created_by         Userid of the creator of this answer.
 * @property string         $created_on         Date this answer was created.
 * @property int            $modified_by        Userid of person that last modified this answer.
 * @property string         $modified_on        Date this answer was last modified.
 * @property Object         $Category           Category object for this image, FK to #__categories
 *
 * SCHEMA: Joomla UCM fields, used by Joomla!s UCM when using the FOF ContentHistory behaviour
 * @property string         $publish_up       Date and time to change the state to published, schema.org alias is datePosted.
 * @property string         $publish_down     Date and time to change the state to unpublished.
 * @property int            $version          Version of this item.
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
 * SCHEMA: ImageObject
 * @property  string	      $caption            Caption for the property image
 * @property  string	      $exif_data          JSON-encoded exif data for this image
 *
 * SCHEMA: MediaObject
 * @property  string	      $content_url        Filename of the property image
 * @property  int			      $content_size       File size in bytes
 * @property  int			      $height             Height of the property image in px
 * @property  int			      $width              Width of the property image in px
 * @property  string	      $encoding_format    RFC 2045 mime type for this image to disambiguate different encodings of the same image, e.g. image/jpeg, image/png, image/gif
 *
 * SCHEMA: CreativeWork
 * @property  Object	      $ContentLocation   Place depicted or described in the image, FK to #__cajobboard_places
 *
 * SCHEMA: Thing
 * @property  string	      $name              A name for this image
 * @property  string	      $description       A long description of this image
 * @property  Object        $Author            The author of this content or rating, FK to #__users
 */
class ImageObjects extends BaseModel
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
    // override default table names and primary key id
		$config['tableName'] = '#__cajobboard_image_objects';
    $config['idFieldName'] = 'image_object_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.image_objects';

    parent::__construct($container, $config);

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

    /* Set up relations after parent constructor */

    // Place depicted or described in the image, many-to-one FK to  #__cajobboard_places
    $this->belongsTo('ContentLocation', 'Places@com_cajobboard', 'content_location', 'place_id');

    // one-to-one FK to  #__cajobboard_persons
    $this->hasOne('Author', 'Persons@com_cajobboard', 'created_by', 'id');

// @TODO: Could this be done using JTable\Categories, and the FOF Categories model removed from this project?
// @TODO: Something like: $category = \JTable::getInstance('Category');

    // Relation to category table for $Category
    $this->belongsTo('Category', 'Categories@com_cajobboard', 'cat_id', 'id');
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
    // @TODO: Finish validation checks
    $this->assertNotEmpty($this->title, 'COM_CAJOBBOARD_IMAGE_OBJECTS_ERR_TITLE');

		parent::check();

    return $this;
  }
}
