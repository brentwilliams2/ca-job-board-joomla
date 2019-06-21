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

use \Calligraphic\Cajobboard\Admin\Helper\Enum\ImageObjectAspectRatiosEnum;
use \Calligraphic\Cajobboard\Admin\Helper\Enum\ImageObjectSizesEnum;
use \FOF30\Container\Container;

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
 * @property  string	      $caption          Caption for the property image
 * @property  string	      $exif_data        JSON-encoded exif data for this image
 *
 * SCHEMA: MediaObject
 * @property  string	      $content_url      Filename of the property image
 *
 * @TODO: will the front-end even know
 * @property  int			      $content_size     File size in bytes
 * @property  int			      $height           Height of the property image in px
 * @property  int			      $width            Width of the property image in px
 * @property  string	      $encoding_format  RFC 2045 mime type for this image to disambiguate different encodings of the same image, e.g. image/jpeg, image/png, image/gif, image/svg+xml
 *
 * SCHEMA: CreativeWork
 * @property  Object	      $ContentLocation  Place depicted or described in the image, FK to #__cajobboard_places
 *
 * SCHEMA: Thing
 * @property  string	      $name             A name for this image
 * @property  string	      $description      A long description of this image
 * @property  Object        $Author           The author of this content or rating, FK to #__users
 */
class ImageObjects extends BaseModel
{
  use \FOF30\Model\Mixin\Assertions;

  /**
	 * Whether xaccel.redirect (Nginx) or xsendfile (Apache) is available
	 *
	 * @var  string|null
	 */
	protected static $isXRedirectAvailable = null;

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

    // Relation to category table for $Category
    $this->belongsTo('Category', 'Categories@com_cajobboard', 'cat_id', 'id');

    if (!$this->isXRedirectAvailable)
    {
      $this->isXRedirectAvailable();
    }
  }

  // @TODO: Need to warn the administrator if the sizes for thumb / small / medium / large images are changed
  //        that all images will need to be resized, and then trigger all images to reprocess. Might need a job control shell script.

  // NOTE: filename is saved with the same hash of the original file + ".jpg" name in all folders, so rewriting
  //       can be done by just clearing out the resize folders (thumb, small, etc.) and regenerating.

  /*
    @TODO: Issues from notes

    1. Using @1, @1.5, @2, @3 modifiers (e.g. supporting Retina)
    2. Should images be automatically converted to png from jpg and gif?
    3. How are thumbnails handled - forcing a crop? Should the UI have the user select a crop for thumbnails?
        -- small / medium / large images are resized to the size's configured width, and aspect ratio maintained (so height variable)
        -- thumb is constrained to a fixed width and height, so requires cropping
    4. Nice to have option to permit crops instead of simple resizing, so an image could e.g. focus in on people as it is scaled down (like for thumb)
  */

  /*
    @TODO: MOVE this note to view

    accept="image/*" — Accept any file with an image/* MIME type. Many mobile devices also let the user take a picture with
    the camera when this is used. Note that mime type and file extension are different: mime type is determined by the browser
    and varies in implementation.

      <form method="post" enctype="multipart/form-data">
        <input type="file" id="profile_pic" name="profile_pic" accept="image/*, .jpg, .jpeg, .png">
      </form>
  */

  /**
	 * Process image files with ImageMagick
	 */
	public function processImages()
	{
    // @TODO: implement

    // Need to handle image processing asynchronously, see admin/Cli/MediaProcessor
    // e.g. resizing for thumbs, small/medium/large, cropping, etc.
  }


  /**
	 * Get hash of image to use as system filename for the image
	 */
	public function getImageHash()
	{
    // @TODO: implement. Existing is using MD5 hash.
  }


  /**
	 * Get HTML tag for image to use as system filename for the image
	 */
	public function getImageTag()
	{
    // @TODO: implement, MOVE to controller

    $model->metadata->
  }


  /**
	 * Get HTML tag for image to use as system filename for the image
   *
   * @param  ImageObjectSizes   The size of the image
	 */
	public function setImageProperties(ImageObjectSizes $size)
	{
    // @TODO: implement, MOVE to controller

    $height = $model->metadata->get($size . '.height', ImageObjectSizes::Original . '.height');
    $width = $model->metadata->get($size . '.width', ImageObjectSizes::Original . '.width');
  }


  /**
	 *
	 */
	public function getImageUrl()
	{
    // @TODO: implement

    // NOTE: category name is the same as the model name (organizations, persons, places) so can be normalized using the model name
    // {sitename}/media/{component name}/images/{category name}/[ original | thumb | small | medium | large ]/{hashed_file_name}.jpg or {slug}.jpg
  }


   /**
	 *
	 */
	public function isXRedirectAvailable()
	{
    // @TODO: implement

    // can check what Apache modules loaded with apache_get_modules(), returns indexed array of module names,
    // also set up a configuration option for whether the ugly name or a SEO-friendly name should be used.

    $this->isRedirectAvailable = 'false'; // or string 'true'
  }


  /**
	 *
	 */
	public function setSefAliasOnWebServer()
	{
    if (! 'true' == $this->isRedirectAvailable)
    {
      return;
    }

    /*
      @TODO: access control: sudo apt-get install libapache2-mod-xsendfile

      httpd.conf:

      #
      # X-Sendfile
      #
      LoadModule xsendfile_module modules/mod_xsendfile.so
      XSendFile On
      # enable sending files from parent dirs of the script directory
      XSendFileAllowAbove On

      header('X-Sendfile: ' . $absoluteFilePath);

      // The Content-Disposition header allows you to tell the browser if
      // it should download the file or display it. Use "inline" instead of
      // "attachment" if you want it to display in the browser. You can
      // also set the filename the browser should use.
      header('Content-Disposition: attachment; filename="somefile.jpg"');

      // The Content-Type header tells the browser what type of file it is.
      header('Content-Type: image/jpeg');

      // Nginx uses x-accel.redirect


    */
  }


  /**
	 * Transform 'exif_data' field to a JRegistry object on bind
	 *
	 * @return  static  Self, for chaining
	 *
	 * @throws \RuntimeException  When the data bound to this record is invalid
	 */
  protected function getExifDataAttribute($value)
  {
    // Make sure it's not a JRegistry already
    if (is_object($value) && ($value instanceof Registry))
    {
        return $value;
    }

    // Return the data transformed to a JRegistry object
    return new Registry($value);
  }


  /**
   * Transform 'exif_data' field's JRegistry object to a JSON string before save
	 *
	 * @return  static  Self, for chaining
	 *
	 * @throws \RuntimeException  When the data bound to this record is invalid
	 */
  protected function setExifDataAttribute($value)
  {
    // Make sure it a JRegistry object, otherwise return the value
    if ( !($value instanceof Registry) )
    {
      return $value;
    }

    // Return the data transformed to JSON
    return $value->toString('JSON');
  }


  /**
	 * Extract EXIF data from image and set 'exif_data' field to a JSON string before save
	 */
  protected function extractExifDataFromImage()
  {

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
