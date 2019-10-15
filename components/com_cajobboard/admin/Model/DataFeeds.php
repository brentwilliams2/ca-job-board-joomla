<?php
/**
 * Admin Data Feeds Model
 *
 * This is used e.g. to provide XML feeds to external job board listing aggregators (Indeed.com, etc.)
 *
 * Extends schema.org DigitalDocuments
 *
 * @package   Calligraphic Job Board
 * @version   September 28, 2019
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
 * @property int            $data_feed_id     Surrogate primary key.
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
 * @property string         $name             A title to use for the data feed.
 * @property string         $description      A description of the data feed.
 * @property string         $description__intro   Short description of the item, used for the text shown on social media via shares and search engine results.
 * @property string         $url              Relative URL of the data feed on this site, if the vendor pulls from this site.
 *
 * SCHEMA: https://calligraphic.design/schema/DataFeed
 * @property string         $send_dates DATETIME DEFAULT NULL COMMENT 'The date/time at which this data feed should be pushed to the audience, as a  Calligraphic\Cajobboard\Admin\Helper\Enum\DaysOfWeekEnum value.',
 *
 * SCHEMA: DataFeed
 * @property string         $data_feed_element  A JSON configuration describing Filter parameters to apply for the JobPostings included in the feed, e.g. {"state variable":"job_posting_id","method":"between","from":"1","to":"10"}.
 *
 * SCHEMA: DataFeed(dataFeedElement) -> DataFeedItem
  * @property string         $date_created    The data and time this data feed was last pushed to the vendor.

 */
class DataFeeds extends BaseDataModel
{
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
		$config['tableName'] = '#__cajobboard_data_feeds';
    $config['idFieldName'] = 'data_feed_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.data_feeds';

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

    // one-to-one FK to #__cajobboard_data_feed_templates
    $this->inverseSideOfHasOne('DataFeedTemplate', 'DataFeedTemplates@com_cajobboard', 'data_feed_template', 'data_feed_template_id');

    // table field for belongsTo relation is in this model's table

    // many-to-one FK to  #__cajobboard_persons
    $this->belongsTo('Author', 'Persons@com_cajobboard', 'created_by', 'id');

    // many-to-one FK to  #__cajobboard_vendors
    $this->belongsTo('AudienceVendor', 'Vendors@com_cajobboard', 'audience__vendor', 'vendor_id');
  }

  /*
    @TODO: From specs: XML Feeds
        a. Basic feed of all Jobs
        b. Customized feeds to distribute to places like Indeed, ZipRecruiter, etc.
        c. Automatically refreshing - plugin triggered by cron?

    @TODO: Use the same logic as EmailMessages to deliver XML updates
  */

  // @TODO: Handle filtering on state variable when record loaded (e.g. 'data_feed_element' table property)


  /**
	 * Transform 'data_feed_element' field to a JRegistry object on bind
	 *
	 * @return  \Calligraphic\Library\Platform\Registry
	 */
  protected function getDataFeedElementAttribute($value)
  {
    $dataFeedElement = $this->transformJsonToRegistry($value);

    return $dataFeedElement;
  }


  /**
	 * Transform 'data_feed_element' field's JRegistry object to a JSON string before save
	 *
	 * @return  string  JSON string
	 */
  protected function setDataFeedElementAttribute($value)
  {
    return $this->transformRegistryToJson($value);
  }
}
