<?php
/**
 * Admin Digital Documents Model
 *
 * @package   Calligraphic Job Board
 * @version   May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model;

// no direct access
defined( '_JEXEC' ) or die;

use \Calligraphic\Cajobboard\Admin\Model\BaseDataModel;
use \Calligraphic\Cajobboard\Admin\Model\Interfaces\Core;
use \Calligraphic\Cajobboard\Admin\Model\Interfaces\Extended;
use \Calligraphic\Cajobboard\Admin\Model\Interfaces\Social;
use \FOF30\Container\Container;

/*
 * Fields:
 *
 * UCM
 * @property int            $digital_document_id    Surrogate primary key.
 * @property string         $slug               Alias for SEF URL.
 * @property bool           $featured           Whether this answer is featured or not.
 * @property int            $hits               Number of hits this answer has received.
 * @property int            $created_by         Userid of the creator of this answer.
 * @property string         $created_on         Date this answer was created.
 * @property int            $modified_by        Userid of person that last modified this answer.
 * @property string         $modified_on        Date this answer was last modified.
 * @property Object         $Category           Category object for this digital document, FK to #__categories
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
 * @property string         $note             A note to save with this item for use in the back-end interface.
 *
 * SCHEMA: Thing
 * @property  string	      $name             A name for this digital document
 * @property  string	      $description      A long description of this digital document
 * @property  string        $description__intro   Short description of the item, used for the text shown on social media via shares and search engine results.
 * @property Registry       $image             Image metadata for social share and page header images.
 *
 * SCHEMA: MediaObject
 * @property  string	      $content_url      Filename of the digital document
 * @property  int			      $content_size     File size in bytes
 * @property  string	      $encoding_format  MIME format of the document, e.g. application/pdf
 */
class DigitalDocuments extends BaseDataModel implements Core, Extended, Social	  // Social is for metadata fields, Extended is Job Board UCM fields (name, description, description__intro)
{
  /* Traits to include in the class */

  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Comments;             // 'saveComment' method

  // Transformations for model properties (attributes) to an appropriate data type (e.g.
  // Registry objects). Validation checks and setting attribute values from state should
  // be done in Behaviours (which can be enabled and overridden per model).

  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Attributes\Image;     // Attribute getter / setter
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Attributes\Metadata;  // Attribute getter / setter
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Attributes\Params;    // Attribute getter / setter

	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    // override default table names and primary key id
		$config['tableName'] = '#__cajobboard_digital_documents';
    $config['idFieldName'] = 'digital_document_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.digital_documents';

    // Set an alias for the title field for DataModel's check() method's slug field auto-population
    $config['aliasFields'] = array('title' => 'name');

    // Add behaviours to the model. 'Filters' behaviour added by default in addBehaviour() method.
    $config['behaviours'] = array(

      /* Core UCM field behaviours */

      'Access',             // Filter access to items based on viewing access levels
      'Assets',             // Add Joomla! ACL assets support
      'Category',           // Set category in new records
      'Created',            // Update the 'created_by' and 'created_on' fields for new records
      //'ContentHistory',     // Add Joomla! content history support
      'Enabled',            // Filter access to items based on enabled status
      'Featured',           // Add support for featured items
      'Hits',               // Add tracking for number of item views
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

      /* Validation checks. Single slash is escaped to a double slash in over-ridden addBehaviour() method in Model/Mixin/Patches.php */

      'Check',              // Validation checks for model, over-rideable per model
      'Check/Image',        // Set the 'image' JSON field on record save
      'Check/Metadata',     // Set the 'metadata' JSON field on record save
      'Check/Title',        // Check length and titlecase the 'metadata' JSON field on record save

      /* Model property (attribute) Behaviours for validation and setting value from state */

      'DescriptionIntro',   // Check the length of the 'description__intro' field
    );

    parent::__construct($container, $config);

    /* Set up relations after parent constructor */

    // one-to-one FK to  #__cajobboard_persons
    $this->hasOne('Author', 'Persons@com_cajobboard', 'created_by', 'id');

    // Relation to category table for $Category
    $this->belongsTo('Category', 'Categories@com_cajobboard', 'cat_id', 'id');

    /*
    if (!$this->isXRedirectAvailable)
    {
      $this->isXRedirectAvailable();
    }
    */

    // @TODO: Could this be done using JTable\Categories, and the FOF Categories model removed from this project?
    // @TODO: Something like: $category = \JTable::getInstance('Category');

    // @TODO: access control: sudo apt-get install libapache2-mod-xsendfile
    /*
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
      header('Content-Type: digital document/jpeg');

      // Nginx uses x-accel.redirect

      can check what Apache modules loaded with apache_get_modules(), returns indexed array of module names,
      also set up a configuration option for whether the ugly name or a SEO-friendly name should be used.

      Need to handle digital document processing asynchronously, see admin/Cli/MediaProcessor
    */
  }
}
