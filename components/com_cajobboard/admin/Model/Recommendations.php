<?php
/**
 * Admin Job Seeker Recommendations Model
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * In a letter of recommendation, the writer knows the candidate well enough to evaluate their abilities.
 * A letter of recommendation is generally requested by the candidate for a particular career goal, academic
 * application, or job opportunity. The writer details the candidate’s accomplishments and skills that make
 * him a strong contender.  The letter is written based on the writer’s personal experience with this candidate.
 * Also, this type of letter is addressed to a specific recipient.  A letter of recommendation is stronger than
 * a reference because the writer is actually recommending you for a job.
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
 * @property int            $recommendation_id  Surrogate primary key.
 * @property string         $slug               Alias for SEF URL.
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
 * SCHEMA: Joomla UCM fields, used by Joomla!s  UCM when using the FOF ContentHistory behaviour
 * @property string         $publish_up         Date and time to change the state to published, schema.org alias is datePosted.
 * @property string         $publish_down       Date and time to change the state to unpublished.
 * @property int            $version            Version of this item.
 * @property int            $ordering           Order this record should appear in for sorting.
 * @property object         $metadata           JSON encoded metadata field for this item.
 * @property string         $metakey            Meta keywords for this item.
 * @property string         $metadesc           Meta description for this item.
 * @property string         $xreference         A reference to enable linkages to external data sets, used to output a meta tag like FB open graph.
 * @property string         $params             JSON encoded parameters for this item.
 * @property string         $language           The language code for the article or * for all languages.
 * @property int            $cat_id             Category ID for this item.
 * @property int            $hits               Number of hits the item has received on the site.
 * @property int            $featured           Whether this item is featured or not.
 * @property string         $note               A note to save with this item for use in the back-end interface.
 *
 * SCHEMA: Thing
 * @property string         $name               A title to use for this recommendation.
 * @property string         $description        The text of this recommendation.
 */
class Recommendations extends BaseModel
{
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Assertions;

  // To handle user uploading PDF or Image files:
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\MediaUploads;

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
		$config['tableName'] = '#__cajobboard_recommendations';
    $config['idFieldName'] = 'recommendation_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.recommendations';

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

    /* Parent constructor */
    parent::__construct($container, $config);

    /* Set up relations after parent constructor */

    // one-to-one with FK stored in this model, FK to #__cajobboard_digital_documents
    $this->inverseSideOfHasOne('DigitalDocument', 'DigitalDocuments@com_cajobboard', 'has_part__digital_document', 'digital_document_id');

    // one-to-one with FK stored in this model, FK to #__cajobboard_image_objects
    $this->inverseSideOfHasOne('ImageObject', 'ImageObjects@com_cajobboard', 'has_part__image_object', 'image_object_id');

    // many-to-one FK to  #__cajobboard_persons
    $this->belongsTo('About', 'Persons@com_cajobboard', 'about', 'id');
  }

// @TODO: Recommendations and references can be one of several types of media object: video recording, audio, pdf, .docx

  /**
	 * Uses OCR Helper to convert PDF and image files to PHP strings
	 */
  public function convertMediaObjectToText($object)
  {
    /*
      @TODO: implement. Should be called when savePdfUpload() or saveImageUpload() are
             called on the MediaUploads mixin to this class. Needs a prominent notice for the user that
             the original file was scanned and OCRd in case it has errors, and a link to a PDF of the original.
             Offering OCR is important for mobile users.

        References and recommendations can be three things:
          1. Text uploaded from an editor, by the person giving the referral/reference logging in and writing it;
          2. a PDF file uploaded, with the referral/reference;
          3. a scanned image of the referral/reference being uploaded.
    */
  }


  /**
	 * Method to request a recommendation
	 */
  public function requestRecommendation($who)
  {
    /*
      @TODO: implement request for recommendation
    */
  }


  /**
	 * Method to get collection of requests for recommendations that have been sent but not answered
	 */
  public function getStaleRequestedRecommendations($datetime)
  {
    /*
      @TODO: implement hecking for old and unanswered recommendation requests
    */
  }


  /**
	 * @throws    \RuntimeException when the assertion fails
	 *
	 * @return    $this   For chaining.
	 */
	public function check()
	{
    $this->assertNotEmpty($this->name, 'COM_CAJOBBOARD_RECOMMENDATION_TITLE_ERR');

		parent::check();

    return $this;
  }
}
