<?php
/**
 * Admin Schedules Model
 *
 * FOF30 inflector doesn't handle words that only have a plural form e.g. schedule
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

use \FOF30\Container\Container;
use \Calligraphic\Cajobboard\Admin\Model\BaseModel;

/**
 * Fields:
 *
 * UCM
 * @property int            $id               Surrogate primary key.
 * @property string         $slug             Alias for SEF URL.
 *
 * FOF "magic" fields
 * @property bool           $featured         Whether this schedule is featured or not.
 * @property int            $hits             Number of hits this schedule has received.
 * @property int            $created_by       Userid of the creator of this schedule.
 * @property string         $createdOn        Date this schedule was created.
 * @property int            $modifiedBy       Userid of person that last modified this schedule.
 * @property string         $modifiedOn       Date this schedule was last modified.
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
 *
 * SCHEMA: Thing
 * @property string         $name             A title to use for the schedule.
 * @property string         $description      A description of the schedule.
 */
class Schedules extends BaseModel
{
  use \FOF30\Model\Mixin\Assertions;

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
		$config['tableName'] = '#__cajobboard_schedules';
    $config['idFieldName'] = 'schedule_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.schedules';

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
  }


  /**
	 * @throws    \RuntimeException when the assertion fails
	 *
	 * @return    $this   For chaining.
	 */
	public function check()
	{
    $this->assertNotEmpty($this->name, 'COM_CAJOBBOARD_SCHEDULES_TITLE_ERR');

		parent::check();

    return $this;
  }

  /*
schedule_id 	int 	ID of the SQL Server Agent job schedule.
schedule_uid 	uniqueidentifier 	Unique identifier of the job schedule. This value is used to identify a schedule for distributed jobs.
originating_server_id 	int 	ID of the master server from which the job schedule came.
name 	sysname (nvarchar(128)) 	User-defined name for the job schedule. This name must be unique within a job.
owner_sid 	varbinary(85) 	Microsoft Windows security_identifier of the user or group that owns the job schedule.
enabled 	int 	Status of the job schedule:

0 = Not enabled.

1 = Enabled.

If the schedule is not enabled, no jobs will run on the schedule.
freq_type 	int 	How frequently a job runs for this schedule.

1 = One time only

4 = Daily

8 = Weekly

16 = Monthly

32 = Monthly, relative to freq_interval

64 = Runs when the SQL Server Agent service starts

128 = Runs when the computer is idle
freq_interval 	int 	Days that the job is executed. Depends on the value of freq_type. The default value is 0, which indicates that freq_interval is unused. See the table below for the possible values and their effects.
freq_subday_type 	int 	Units for the freq_subday_interval. The following are the possible values and their descriptions.



1 : At the specified time

2 : Seconds

4 : Minutes

8 : Hours
freq_subday_interval 	int 	Number of freq_subday_type periods to occur between each execution of the job.
freq_relative_interval 	int 	When freq_interval occurs in each month, if freq_interval is 32 (monthly relative). Can be one of the following values:

0 = freq_relative_interval is unused

1 = First

2 = Second

4 = Third

8 = Fourth

16 = Last
freq_recurrence_

factor 	int 	Number of weeks or months between the scheduled execution of a job. freq_recurrence_factor is used only if freq_type is 8, 16, or 32. If this column contains 0, freq_recurrence_factor is unused.
active_start_date 	int 	Date on which execution of a job can begin. The date is formatted as YYYYMMDD. NULL indicates today's date.
active_end_date 	int 	Date on which execution of a job can stop. The date is formatted YYYYMMDD.
active_start_time 	int 	Time on any day between active_start_date and active_end_date that job begins executing. Time is formatted HHMMSS, using a 24-hour clock.
active_end_time 	int 	Time on any day between active_start_date and active_end_date that job stops executing. Time is formatted HHMMSS, using a 24-hour clock.
date_created 	datetime 	Date and time that the schedule was created.
date_modified 	datetime 	Date and time that the schedule was last modified.
version_number 	int 	Current version number of the schedule. For example, if a schedule has been modified 10 times, the version_number is 10.
Value of freq_type 	Effect on freq_interval
1 (once) 	freq_interval is unused (0)
4 (daily) 	Every freq_interval days
8 (weekly) 	freq_interval is one or more of the following:

1 = Sunday

2 = Monday

4 = Tuesday

8 = Wednesday

16 = Thursday

32 = Friday

64 = Saturday
16 (monthly) 	On the freq_interval day of the month
32 (monthly, relative) 	freq_interval is one of the following:

1 = Sunday

2 = Monday

3 = Tuesday

4 = Wednesday

5 = Thursday

6 = Friday

7 = Saturday

8 = Day

9 = Weekday

10 = Weekend day
64 (starts when SQL Server Agent service starts) 	freq_interval is unused (0)
128 (runs when computer is idle) 	freq_interval is unused (0)
*/
}
