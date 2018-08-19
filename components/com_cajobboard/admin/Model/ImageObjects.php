<?php
/**
 * Admin Place Model
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
 * Places model
 *
 * Describes more of less fixed physical places
 *
 * Fields:
 *
 * @property  int			$image_object_id    Surrogate primary key
 *
 * SCHEMA: ImageObject
 * @property  string	$image              Filename of the property image
 * @property  string	$thumbnail          Filename of the property image thumbnail
 * @property  string	$caption            Caption for the property image
 * @property  string	$exif_data          JSON-encoded exif data for this image
 *
 * SCHEMA: MediaObject
 * @property  int			$height             Height of the property image in px
 * @property  int			$width              Width of the property image in px
 * @property  string	$encoding_format    RFC 2045 mime type for this image to disambiguate different encodings of the same image, e.g. image/jpeg, image/png, image/gif
 *
 * SCHEMA: CreativeWork
 * @property  Object	$contentLocation   Place depicted or described in the image, FK to #__cajobboard_places
 *
 * SCHEMA: Thing
 * @property  string	$name              A name for this image
 * @property  string	$description       A long description of this image
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
    parent::__construct($container, $config);

    // override default table names and primary key id
    $this->tableName = "#__cajobboard_image_objects";
    $this->idFieldName = "image_object_id";

    // Add behaviours to the model
    $this->addBehaviour('Language');
    $this->addBehaviour('Tags');
    $this->addBehaviour('Filters');

    /*
     * Set up relations
     */

    // Place depicted or described in the image, many-to-one FK to  #__cajobboard_places
    $this->belongsTo('contentLocation', 'Places@com_cajobboard', 'content_location', 'place_id');
  }
}
