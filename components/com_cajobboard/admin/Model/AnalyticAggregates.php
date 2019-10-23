<?php
/**
 * Admin Analytic Aggregates Model
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

use \Calligraphic\Cajobboard\Admin\Model\Helper\TableFields;
use \FOF30\Container\Container;
use \FOF30\Model\DataModel;

/**
 * Fields:
 *
 * UCM
 * @property int            $analytic_aggregate_id   Surrogate primary key.
 * @property string         $slug             Alias for SEF URL.
 *
 * FOF "magic" fields
 * @property int            $asset_id                     FK to the #__assets table for access control purposes.
 * @property int            $access                       The Joomla! view access level.
 * @property string         $created_on                   Timestamp of record creation, auto-filled by save().
 * @property int            $created_by                   User ID who created the record, auto-filled by save().
 * @property string         $modified_on                  Timestamp of record modification, auto-filled by save(), touch().
 * @property int            $modified_by                  User ID who modified the record, auto-filled by save(), touch().
 * @property string         $locked_on                    Timestamp of record locking, auto-filled by lock(), unlock().
 * @property int            $locked_by                    User ID who locked the record, auto-filled by lock(), unlock().
 *
 * SCHEMA: Joomla UCM fields, used by Joomla!s            UCM when using the FOF ContentHistory behaviour
 * @property int            $ordering                     Order this record should appear in for sorting.
 * @property string         $params                       JSON encoded parameters for this item.
 * @property int            $cat_id                       Category ID for this item.
 * @property string         $note                         A note to save with this item for use in the back-end interface.
 *
 * SCHEMA: Thing
 * @property string         $name                         A title to use for the analytic.
 * @property string         $description                  A description of the analytic.
 * @property string         $description__intro           Short description of the item, used for the text shown on social media via shares and search engine results.
 * @property int            $about__foreign_model_id      The foreign model primary key that this comment belongs to
 * @property string         $about__foreign_model_name    The name of the foreign model this comment belongs to, discriminator field for single-table inheritance
 *
 * @property JSON           $structured_value             The values for this analytic aggregate, in a JSON string.
 */
class AnalyticAggregates extends DataModel
{
  /* Traits to include in the class */

  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Asset;                // Joomla! role-based access control handling
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Comments;             // 'saveComment' method
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Constructor;          // Refactored base-class constructor, called from __construct method
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Core;                 // Utility methods
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Count;                // Overridden count() method to cache value
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\FieldStateMachine;    // Toggle method for boolean fields
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\JsonData;             // Methods for transforming between JSON-encoded strings and Registry objects
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\TableFields;          // Use an array of table fields instead of database reads on each table

  // Transformations for model properties (attributes) to an appropriate data type (e.g.
  // Registry objects). Validation checks and setting attribute values from state should
  // be done in Behaviours (which can be enabled and overridden per model).

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
		$config['tableName'] = '#__cajobboard_analytic_aggregates';
    $config['idFieldName'] = 'analytic_aggregate_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.analytic_aggregates';

    // Set an alias for the title field for DataModel's check() method's slug field auto-population
    $config['aliasFields'] = array('title' => 'name');

    // Add behaviours to the model. Filters, Created, and Modified behaviours are added automatically.
    $config['behaviours'] = array(
      'Access',     // Filter access to items based on viewing access levels
      'Assets',     // Add Joomla! ACL assets support
      'Category',   // Set category in new records
      'Ordering',   // Order items owned by featured status and then descending by date
      'Slug',       // Backfill the slug field with the 'title' property or its fieldAlias if empty

      /* Model property (attribute) Behaviours for validation and setting value from state */
      'DescriptionIntro',   // Check the length of the 'description__intro' field
    );

    /* Parent constructor */
    parent::__construct($container, $config);

    /* Set up relations after parent constructor */
  }


  // @TODO: Create new records on-demand, so everything is an update (no separate create function)
  //        Set up eventing system to use for other triads to notify when analytics data is being generated

  //  DON'T NEED SEEDER for this model

  /**
	 * Transform 'structured_value' field to a JRegistry object on bind
	 *
	 * @return  \Calligraphic\Library\Platform\Registry
	 */
  protected function getStructuredValueAttribute($value)
  {
    $structuredValue = $this->transformJsonToRegistry($value);

    return $structuredValue;
  }


  /**
	 * Transform 'structured_value' field's JRegistry object to a JSON string before save
	 *
	 * @return  string  JSON string
	 */
  protected function setStructuredValueAttribute($value)
  {
    return $this->transformRegistryToJson($value);
  }


  /*

  Joomla! >= 3.9 has a built in 'actions' system. We could use this model just for aggregates,
  and use the 'actions' system for the raw data.

  Spec mentions the following analytics:

    i. View job -> Apply to job
    ii. Create employer account -> Buy package
    iii. Clicked from email job alert
    iv. Popup sharing a job -> Did they share the job
    v. For job listings using an external application link, track how many times that application link was clicked.

  This is the place to keep aggregate counts of comments to show on list views, or other aggregates on the job board.


  Possible database schemas:

  Events             EventId int,  EventTypeId varchar,   TS timestamp
  EventAttrValueInt  EventId int,  AttrName varchar,  Value int
  EventAttrValueChar EventId int,  AttrName varchar,  Value varchar

  * sessionId :int (FK)
  * actionStart :time
  * actionEnd :time
  * actionType :varchar
  * actionDetail :text

  select *
  from Events
    join EventAttrValueInt  on Id = EventId and AttrName = 'APPVERSION' and Value > 4
    join EventAttrValueChar on Id = EventId and AttrName = 'APP_NAME'
                                            and Value like "%Office%"
  where EventTypeId = "APP_LAUNCH"


  Quarterly reports:
    applications per open requisition (and % that are referrals)
    applicants to interviews (and % that are screened)
    offers vs. hires (and % up or down from last quarter)
    average time-to-hire (days)
    Job posting # of views
    invoicing / cost to fill the job


  Reporting options:
      The status of job seekers in the application process
      What time of day applicants view your job posting
      Which job board or career site brings in more applicants
      The strengths of potential applicants
      Custom categories applicants fall under
      Applicants’ engagement in the hiring process
      Questionnaire answers

    */
}
