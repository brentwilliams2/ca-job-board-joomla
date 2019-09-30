<?php
/**
 * Admin Application Letters Model
 *
 * Extends schema.org DigitalDocuments
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
use \Calligraphic\Cajobboard\Admin\Model\BaseDataModel;

/**
 * Fields:
 *
 * UCM
 * @property int            $application_letter_id    Surrogate primary key.
 * @property string         $slug             Alias for SEF URL.
 *
 * FOF "magic" fields
 * @property int            $asset_id           FK to the #__assets table for access control purposes.
 * @property int            $access             The Joomla! view access level.
 * @property int            $enabled            Publish status: -2 for trashed and marked for deletion, -1 for archived, 0 for unpublished, and 1 for published.
 * @property string         $created_on         Timestamp of record creation, auto-filled by save().
 * @property int            $created_by         User ID who created the record, auto-filled by save().
 * @property string         $modified_on        Timestamp of record modification, auto-filled by save(), touch().
 * @property int            $modified_by        User ID who modified the record, auto-filled by save(), touch().
 * @property string         $locked_on          Timestamp of record locking, auto-filled by lock(), unlock().
 * @property int            $locked_by          User ID who locked the record, auto-filled by lock(), unlock().
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
 * @property string         $name             A title to use for the comment.
 * @property string         $description      The text of the comment.
 * @property string         $description__intro   		Short description of the item, used for the text shown on social media via shares and search engine results.
 * 
 * SCHEMA: MediaObject
 * @property  string	      $content_url      Filename of the digital document
 * @property  int			      $content_size     File size in bytes
 * @property  string	      $encoding_format  MIME format of the document, e.g. application/pdf
 */
class ApplicationLetters extends BaseDataModel
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
		$config['tableName'] = '#__cajobboard_application_letters';
    $config['idFieldName'] = 'application_letter_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.application_letters';

    parent::__construct($container, $config);

    // Add behaviours to the model. Filters, Created, and Modified behaviours are added automatically.
    $config['behaviours'] = array(
      'Access',     // Filter access to items based on viewing access levels
      'Assets',     // Add Joomla! ACL assets support
      //'ContentHistory', // Add Joomla! content history support
      //'Own',        // Filter access to items owned by the currently logged in user only
      //'PII',        // Filter access for items that have Personally Identifiable Information. ONLY for ATS screens, use view template PII access control for individual fields
      //'Tags'        // Add Joomla! Tags support
    );

    /* Set up relations after parent constructor */

    // one-to-one FK to  #__cajobboard_persons
		$this->hasOne('Author', 'Persons@com_cajobboard', 'created_by', 'id');

		// The organization model primary key that this application letter was created for
		$this->belongsTo('About', 'Organizations@com_cajobboard', 'about__organization_id', 'organization_id');

		// Relation to category table for $Category
		$this->belongsTo('Category', 'Categories@com_cajobboard', 'cat_id', 'id');


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
