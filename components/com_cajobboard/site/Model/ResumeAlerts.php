<?php
/**
 * Site Resume Alerts Model
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Model;

// no direct access
defined('_JEXEC') or die;

use \FOF30\Container\Container;

/**
 * Fields:
 *
 * UCM
 * @property int            $alert_id         Surrogate primary key.
 * @property string         $slug             Alias for SEF URL.
 *
 * FOF "magic" fields
 * @property bool           $featured         Whether this alert is featured or not.
 * @property int            $hits             Number of hits this alert has received.
 * @property int            $created_by       Userid of the creator of this alert.
 * @property string         $createdOn        Date this alert was created.
 * @property int            $modifiedBy       Userid of person that last modified this alert.
 * @property string         $modifiedOn       Date this alert was last modified.
 *
 * SCHEMA: Joomla UCM fields, used by Joomla!s UCM when using the FOF ContentHistory behaviour
 * @property string         $publish_up       Date and time to change the state to published, schema.org alias is datePosted.
 * @property string         $publish_down     Date and time to change the state to unpublished.
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
 *
 * SCHEMA: Thing
 * @property string         $name             A title to use for the alert.
 * @property string         $description      A description of the alert.
 *
 * SCHEMA: https://schema.org/GeoCoordinates
 * @property  GeoCoordinates $geo_coordinate   The geographic coordinates of the center of the employer's search radius, FK to #__cajobboard_geo_coordinates
 *
 * SCHEMA: https://schema.org/geoRadius
 * @property int            $geo_radius      The distance in miles to search for jobs from the employer's search radius center point.',
 *
 * SCHEMA: https://schema.org/occupationalCategory
 * @property OccupationalCategories $occupational_category   A category describing the job being sought, FK to #__cajobboard_occupational_categories
 *
 * SCHEMA: https://schema.org/keywords
 * @property JSON           $keywords       Used to filter resumes shown for this alert. Should be a case-insensitive array of keywords, e.g. [ "great customers", "friendly", "fun" ]
 */
class ResumeAlerts extends \Calligraphic\Cajobboard\Admin\Model\ResumeAlerts
{
	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);
  }
}
