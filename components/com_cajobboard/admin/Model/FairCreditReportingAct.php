<?php
/**
 * Admin Fair Credit Reporting Act Model
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

use \Calligraphic\Cajobboard\Admin\Model\BaseDataModel;
use \Calligraphic\Cajobboard\Admin\Model\Interfaces\Core;
use \Calligraphic\Cajobboard\Admin\Model\Interfaces\Extended;
use \Calligraphic\Cajobboard\Admin\Model\Interfaces\Social;
use \FOF30\Container\Container;

/**
 * Fields:
 *
 * UCM
 * @property int            $fcra_id        Surrogate primary key.
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
 * @property string         $name             A title to use for the FCRA notice.
 * @property string         $description      A description of the FCRA notice.
 * @property string         $description__intro   Short description of the item.
 *
 * SCHEMA: Thing(potentialAction) -> Action
 * @property int            $action_status    Status of the action, ENUM defined in \Calligraphic\Cajobboard\Admin\Helper\Enum\ActionStatusEnum
 * @property datetime       $end_time         The date the completed FCRA notice was received.
 * @property datetime       $start_time       The date the FCRA notice was requested.
 * 
 * SCHEMA: Thing(potentialAction) -> Action(result) -> MediaObject
 * @property string         $result__content_url        System filename of the signed FCRA notice returned from the job seeker.
 * @property int            $result__content_size       File size in bytes.
 *
 * SCHEMA: Thing(potentialAction) -> Action(result) -> CreativeWork
 * @property string         $result__encoding_format    MIME format of the document, e.g. application/pdf.
 */
class FairCreditReportingAct extends BaseDataModel implements Core, Extended, Social	  // Social is for metadata fields, Extended is Job Board UCM fields (name, description, description__intro)
{
  /* Traits to include in the class */

  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Comments;             // 'saveComment' method

  // Transformations for model properties (attributes) to an appropriate data type (e.g.
  // Registry objects). Validation checks and setting attribute values from state should
  // be done in Behaviours (which can be enabled and overridden per model).

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
    /* Set up config before parent constructor */

    // Not using convention for table names or primary key field
		$config['tableName'] = '#__cajobboard_fair_credit_reporting_act';
    $config['idFieldName'] = 'fair_credit_reporting_act_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.fair_credit_reporting_act';

    // Set an alias for the title field for DataModel's check() method's slug field auto-population
    $config['aliasFields'] = array('title' => 'name');

    // Add behaviours to the model. 'Filters' behaviour added by default in addBehaviour() method.
    $config['behaviours'] = array(

      /* Core UCM field behaviours */

      'Access',             // Filter access to items based on viewing access levels
      'Assets',             // Add Joomla! ACL assets support
      'Category',           // Set category in new records
      'Created',            // Update the 'created_by' and 'created_on' fields for new records
      'Enabled',            // Filter access to items based on enabled status
      'Language',           // Filter front-end access to items based on language
      'Modified',           // Update the 'modified_by' and 'modified_on' fields for new records
      'Note',               // Add 'note' field to skip fields check
      //'Own',                // Filter access to items owned by the currently logged in user only
      'Params',             // Add 'params' field to skip fields check
      //'PII',                // Filter access for items that have Personally Identifiable Information.
      'PublishUp',          // Set the 'publish_on' field for new records, for models that lack a 'publish_down' field
      'Slug',               // Backfill the slug field with the 'title' property or its fieldAlias if empty

      /* Validation checks. Single slash is escaped to a double slash in over-ridden addBehaviour() method in Model/Mixin/Patches.php */

      'Check',              // Validation checks for model, over-rideable per model

      /* Model property (attribute) Behaviours for validation and setting value from state */

      'DescriptionIntro',   // Check the length of the 'description__intro' field
    );

    /* Parent constructor */
    parent::__construct($container, $config);

    /* Set up relations after parent constructor */

    // table field for belongsTo relation is in this model's table

    // many-to-one FK to  #__cajobboard_persons
    $this->belongsTo('Author', 'Persons@com_cajobboard', 'created_by', 'id');

    // many-to-one FK to #__cajobboard_persons
    $this->belongsTo('About', 'Persons@com_cajobboard', 'about', 'id');
  }
}
