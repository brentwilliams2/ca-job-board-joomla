<?php
/**
 * Admin Reviews Model
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
use \Calligraphic\Cajobboard\Admin\Model\BaseListModel;

/**
 * Model class for Job Board Employer_Aggregate_Ratings
 *
 * @property int      $employer_aggregate_rating_id  Surrogate primary key
 * @property string   $slug                       Alias for SEF URL
 * FOF "magic" fields
 * @property int      $asset_id                   FK to the #__assets table for access control purposes.
 * @property int      $access                     The Joomla! view access level.
 * @property int      $enabled                    Publish status: -2 for trashed and marked for deletion, -1 for archived, 0 for unpublished, and 1 for published.
 * @property string   $created_on                 Timestamp of record creation, auto-filled by save().
 * @property int      $created_by                 User ID who created the record, auto-filled by save().
 * @property string   $modified_on                Timestamp of record modification, auto-filled by save(), touch().
 * @property int      $modified_by                User ID who modified the record, auto-filled by save(), touch().
 * @property string   $locked_on                  Timestamp of record locking, auto-filled by lock(), unlock().
 * @property int      $locked_by                  User ID who locked the record, auto-filled by lock(), unlock().
 * SCHEMA: Joomla UCM fields, used by Joomla!s UCM when using the FOF ContentHistory behaviour
 * @property string   $publish_up                 Date and time to change the state to published, schema.org alias is datePosted.
 * @property string   $publish_down               Date and time to change the state to unpublished.
 * @property int      $version                    Version of this item.
 * @property int      $ordering                   Order this record should appear in for sorting.
 * @property object   $metadata                   JSON encoded metadata field for this item.
 * @property string   $metakey                    Meta keywords for this item.
 * @property string   $metadesc                   Meta descriptionfor this item.
 * @property string   $xreference                 A reference to enable linkages to external data sets, used to output a meta tag like FB open graph.
 * @property string   $params                     JSON encoded parameters for the content item.
 * @property string   $language                   The language code for the article or * for all languages.
 * @property int      $cat_id                     Category ID for this content item.
 * @property int      $hits                       Number of hits the content item has received on the site.
 * @property int      $featured                   Whether this content item is featured or not.
 * SCHEMA: EmployerAggregateRating
 * @property  Organizations	$ItemReviewed 	      The employer whose reviews and ratings are being aggregated for, FK to #__cajobboard_organizations
 * @property  int		  $rating_count 	            The count of total number of ratings.
 * @property  int		  $review_count 	            The count of total number of reviews.
 *
 * SCHEMA: Rating
 * @property  int		  $rating_value               The total rating sum for this employer. Get average by dividing with rating_count. Default worstRating 1 and bestRating 5 assumed.
 */
class EmployerAggregateRatings extends BaseListModel
{
  use \FOF30\Model\Mixin\Assertions;

  /*
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
   */
	public function __construct(Container $container, array $config = array())
	{
    // Not using convention for table names or primary key field
		$config['tableName'] = '#__cajobboard_employer_aggregate_ratings';
    $config['idFieldName'] = 'employer_aggregate_rating_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.employer_aggregate_ratings';

    parent::__construct($container, $config);



   /* Set up relations after parent constructor */

    // one-to-one FK to  #__cajobboard_organizations
    $this->hasOne('ItemReviewed', 'Organizations@com_cajobboard', 'item_reviewed', 'organization_id');
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
    $this->assertNotEmpty($this->title, 'COM_CAJOBBOARD_EMPLOYER_AGGREGATE_RATINGS_ERR_TITLE');

		parent::check();

    return $this;
  }
}
