<?php
/**
 * Admin Job Offers Model
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
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
 * @property int            $offer_id        Surrogate primary key.
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
 * @property string         $name                             A title to use for the offer.
 * @property string         $description                      A description of the offer.
 * @property string         $description__intro               Short description of the item.
 *
 * @property \DateTime      $valid_through                    The date this job offer is valid until.
 * @property int            $price__base_salary__value        The base salary of the job.
 * @property string         $price__base_salary__currency     Currency the job is paid in, use ISO 4217 currency format e.g. USD.
 * @property string         $price__base_salary__duration     Pay period for the job, use ISO 8601 duration format, e.g. P2W for bi-weekly.
 */
class Offers extends BaseDataModel
{
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Assertions;

	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    /* Set up config before parent constructor */

    // @TODO: Add this to call the content history methods during create, save and delete operations. CHECK SYNTAX
    // JObserverMapper::addObserverClassToClass('JTableObserverContenthistory', 'BackgroundChecks', array('typeAlias' => 'com_cajobboard.offers'));

    // Not using convention for table names or primary key field
		$config['tableName'] = '#__cajobboard_offers';
    $config['idFieldName'] = 'offer_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.offers';

    // Set an alias for the title field for DataModel's check() method's slug field auto-population
    $config['aliasFields'] = array('title' => 'name');

    // Add behaviours to the model. Filters, Created, and Modified behaviours are added automatically.
    $config['behaviours'] = array(
      'Access',     // Filter access to items based on viewing access levels
      'Assets',     // Add Joomla! ACL assets support
      //'Own',        // Filter access to items owned by the currently logged in user only
      //'PII',        // Filter access for items that have Personally Identifiable Information. ONLY for ATS screens, use view template PII access control for individual fields
      //'Tags'        // Add Joomla! Tags support
    );

    /* Parent constructor */
    parent::__construct($container, $config);

    /* Set up relations after parent constructor */

    // table field for belongsTo relation is in this model's table

    // many-to-one FK to  #__cajobboard_persons
    $this->belongsTo('AboutPerson', 'Persons@com_cajobboard', 'about__person', 'id');

    // many-to-one FK to #__cajobboard_job_postings
    $this->belongsTo('ItemOffered', 'JobPostings@com_cajobboard', 'item_offered', 'job_posting_id');

    // many-to-one FK to #__cajobboard_organizations
    $this->belongsTo('OfferedBy', 'Organizations@com_cajobboard', 'offered_by', 'organization_id');

    // many-to-one FK to #__cajobboard_digital_documents
    $this->belongsTo('IncludesObjectDigitalDocument', 'DigitalDocuments@com_cajobboard', 'includes_object__digital_document', 'digital_document_id');

    // many-to-one FK to #__cajobboard_email_messages
    $this->belongsTo('IncludesObjectEmailMessage', 'EmailMessages@com_cajobboard', 'includes_object__email_message', 'email_message_id');
  }
}
