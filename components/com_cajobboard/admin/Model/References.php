<?php
/**
 * Admin Job Seeker References Model
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * A reference letter is more general in nature than a recommendation letter.  Typically, it is not
 * addressed to an individual. It is an overall assessment of the candidate’s characteristics, knowledge,
 * and skills. Context of how the writer knows the individual is included, such as, “I was Clara’s supervisor
 * at Acme Loans.”  In some cases a company representative will issue a letter of reference that simply states
 * the former employee’s dates of employment and job title.  This letter merely references that the writer
 * knows you and confirms basic facts about you.
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
 * @property int            $reference_id     Surrogate primary key.
 * @property string         $slug             Alias for SEF URL.
 *
 * FOF "magic" fields
 * @property bool           $featured         Whether this reference is featured or not.
 * @property int            $hits             Number of hits this reference has received.
 * @property int            $created_by       Userid of the creator of this reference.
 * @property string         $createdOn        Date this reference was created.
 * @property int            $modifiedBy       Userid of person that last modified this reference.
 * @property string         $modifiedOn       Date this reference was last modified.
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
 * @property string         $name             A title to use for the reference.
 * @property string         $description      The text of this reference.
 * @property string         $description__intro    Short description of the item, used for the text shown on browse views.
 *
 * SCHEMA: CreativeWork
 * @property string         $text             The actual text of the reference.
 */
class References extends BaseDataModel
{
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
		$config['tableName'] = '#__cajobboard_references';
    $config['idFieldName'] = 'reference_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.references';

    // Set an alias for the title field for DataModel's check() method's slug field auto-population
    $config['aliasFields'] = array('title' => 'name');

    // Add behaviours to the model. Filters, Created, and Modified behaviours are added automatically.
    $config['behaviours'] = array(
      'Access',     // Filter access to items based on viewing access levels
      'Assets',     // Add Joomla! ACL assets support
      //'ContentHistory', // Add Joomla! content history support
      //'Own',        // Filter access to items owned by the currently logged in user only
      //'PII',        // Filter access for items that have Personally Identifiable Information. ONLY for ATS screens, use view template PII access control for individual fields
      //'Tags'        // Add Joomla! Tags support
    );

    /* Parent constructor */
    parent::__construct($container, $config);

    /* Set up relations after parent constructor */

    // table field for inverseSideOfHasOne relation is in this model's table

    // one-to-one with FK stored in this model, FK to #__cajobboard_digital_documents
    $this->inverseSideOfHasOne('DigitalDocument', 'DigitalDocuments@com_cajobboard', 'has_part__digital_document', 'digital_document_id');

    // one-to-one with FK stored in this model, FK to #__cajobboard_image_objects
    $this->inverseSideOfHasOne('ImageObject', 'ImageObjects@com_cajobboard', 'has_part__image_object', 'image_object_id');

    // table field for belongsTo relation is in this model's table

    // many-to-one FK to  #__cajobboard_persons
    $this->belongsTo('About', 'Persons@com_cajobboard', 'about', 'id');
  }

/*
@TODO: How to correlate email responses to the request for reference that was sent -
          1. by email address? how to know then which reference request it's for if multiple from same email add'y?
          2. by a string added in the subject or body?
          3. By something added to the recipient string, like "reference@mfi.com" but with a prefix (e.g.
              123.reference@mfi.com to reference@mfi.com)? Will the prefix be lost on forward? rewrite into the subject?

@TODO: How to ferry email responses to reference requests back into Joomla!

@TODO: How to get media object attachments from an email?
*/

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
	 * Method to request a reference
	 */
  public function requestReference($who)
  {
    /*
      @TODO: implement request for reference
    */
  }


  /**
	 * Method to get collection of requests for references that have been sent but not answered
	 */
  public function getStaleRequestedReferences($datetime)
  {
    /*
      @TODO: implement checking for old and unanswered reference requests
    */
  }


  /**
	 * @throws    \RuntimeException when the assertion fails
	 *
	 * @return    $this   For chaining.
	 */
	public function check()
	{
    $this->assertNotEmpty($this->name, 'COM_CAJOBBOARD_REFERENCES_TITLE_ERR');

		parent::check();

    return $this;
  }
}
