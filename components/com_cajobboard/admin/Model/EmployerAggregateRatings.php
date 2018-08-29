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
use FOF30\Model\DataModel;
use JLog;

JLog::add('Employer Aggregate Ratings model called', JLog::DEBUG, 'cajobboard');
/**
 * Model class for Job Board Employer_Aggregate_Ratings
 *
 * SCHEMA: EmployerAggregateRating
 * @property  Organizations	$ItemReviewed 	The employer whose reviews and ratings are being aggregated for, FK to #__cajobboard_organizations
 * @property  int		  $rating_count 	The count of total number of ratings.
 * @property  int		  $review_count 	The count of total number of reviews.
 *
 * SCHEMA: Rating
 * @property  int		  $rating_value   The average rating for this employer. Default worstRating 1 and bestRating 5 assumed.
 */
class EmployerAggregateRatings extends DataModel
{
  /*
   * Overridden constructor
   */
	public function __construct(Container $container, array $config = array())
	{
    // override default table names and primary key id
    $this->tableName = "#__cajobboard_employer_aggregate_ratings";
    $this->idFieldName = "employer_aggregate_rating_id";

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.employer_aggregate_ratings';

    parent::__construct($container, $config);

    // Add behaviours to the model
    $this->addBehaviour('Language');
    $this->addBehaviour('Tags');
    $this->addBehaviour('Filters');

   /*
    * Set up relations
    */

    // many-to-one FK to  #__cajobboard_organizations
    $this->belongsTo('ItemReviewed', 'Organizations@com_cajobboard', 'item_reviewed', 'organization_id');
  }

	/**
	 *
	 *
	 * @param   array|\stdClass  $data  Source data
	 *
	 * @return  bool
	 */
	function onBeforeSave(&$data)
	{

  }

	/**
	 * Build the SELECT query for returning records.
	 *
	 * @param   \JDatabaseQuery  $query           The query being built
	 * @param   bool             $overrideLimits  Should I be overriding the limit state (limitstart & limit)?
	 *
	 * @return  void
	 */
	public function onAfterBuildQuery(\JDatabaseQuery $query, $overrideLimits = false)
	{
    $db = $this->getDbo();

    // search functionality was in here, as well as in FrameworkUsers
  }
}
