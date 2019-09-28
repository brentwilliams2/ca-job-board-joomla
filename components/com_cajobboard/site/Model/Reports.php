<?php
/**
 * Site Reports Model (PDF reports generated from various sources, like Analytics)
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
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
 * @property int            $report_id         Surrogate primary key.
 * @property string         $slug             Alias for SEF URL.
 *
 * FOF "magic" fields
 * @property bool           $featured         Whether this report is featured or not.
 * @property int            $hits             Number of hits this report has received.
 * @property int            $created_by       Userid of the creator of this report.
 * @property string         $createdOn        Date this report was created.
 * @property int            $modifiedBy       Userid of person that last modified this report.
 * @property string         $modifiedOn       Date this report was last modified.
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
 * @property string         $name             A title to use for the report.
 * @property string         $description      A description of the report.
 * @property string         $description__intro     Short description of the item, used for the text shown on browse views.
 *
 * Thing(additionalType) -> Schedule
 * @property string         $repeat_frequency  How often this report should be generated. Use ISO 8601 duration format, e.g. PM1 for monthly, PW1 for weekly, PD1 for daily, PT0S for never-recurring.
 * @property int            $by_day            Which day(s) of the week this report should be generated on. Auto-filled to current day for one-time reports. Uses DaysOfWeekEnum helper.
 * @property int            $repeat_count      The number of times this report should be generated. Set to any non-positive integer value or null for recurring.
 *
 * SCHEMA: Message
 * @property string         $date_sent         The date the report was last sen.
 */
class Reports extends \Calligraphic\Cajobboard\Admin\Model\Reports
{
	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);
  }
}
