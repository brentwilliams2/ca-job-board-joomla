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
use FOF30\Model\DataModel;

/*
 * Image Objects model
 *
 * Holds metadata and file location information for images and photographs
 *
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
class ImageObjects extends \FOF30\Model\DataModel
{
	/**
	 * Public constructor. Adds behaviours and sets up the behaviours and the relations
	 *
	 * @param   Container  $container
	 * @param   array      $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    // override default table names and primary key id
    $this->tableName = "#__cajobboard_image_objects";
    $this->idFieldName = "image_object_id";

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.image_objects';

    parent::__construct($container, $config);

    // Add behaviours to the model
    $this->addBehaviour('Language');
    $this->addBehaviour('Tags');
    $this->addBehaviour('Filters');

    /*
     * Set up relations
     */

    // Place depicted or described in the image, many-to-one FK to  #__cajobboard_places
    $this->belongsTo('ContentLocation', 'Places@com_cajobboard', 'content_location', 'place_id');

    // Relation to users table for $author
    $this->belongsTo('Author', 'Persons@com_cajobboard', 'author', 'id');

    // Relation to category table for $Category
    $this->belongsTo('Category', 'Categories@com_cajobboard', 'cat_id', 'id');
  }
}
