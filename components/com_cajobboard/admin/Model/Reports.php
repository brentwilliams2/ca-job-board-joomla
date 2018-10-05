<?php
/**
 * Reports Model
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

use FOF30\Container\Container;
use FOF30\Model\DataModel;

/**
 * Model class description
 *
 * Fields:
 *
 * UCM
 * @property int            $report_id       Surrogate primary key.
 * @property string         $slug            Alias for SEF URL.
 * @property int            $created_by      Userid of the creator of this report.
 * @property string         $createdOn       Date this report was created.
 * @property int            $modifiedBy      Userid of person that last modified this report.
 * @property string         $modifiedOn      Date this report was last modified.
 *
 * SCHEMA: Thing
 * @property string         $name            A title or header for this report.
 * @property string         $description     A short description of this report.
 *
 * SCHEMA: CreativeWork
 * @property Object         $about           The content item this report is about.
 * @property string         $keywords        The reasons this content is being reported, usually set from a predefined system list of reasons.
 * @property string         $text            The actual text of this report.
 */
class Reports extends DataModel
{
	/**
	 * Public constructor. Overrides the parent constructor.
	 *
	 * @see DataModel::__construct()
	 *
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    // Not using convention for table names or primary key field
		$config['tableName'] = '#__cajobboard_reports';
    $config['idFieldName'] = 'report_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.reports';

    // Add behaviours to the model
    $config['behaviours'] = array('Filters', 'Language', 'Tags');

    parent::__construct($container, $config);

    /*
     * Set up relations
     */

    // @TODO: Waiting on PR request for custom relation types (to create relation type for table inheritance)
    //$this->hasOne('about', $about__model' . @com_cajobboard', 'about__id', $this->container->inflector->singularize($about__model) . '_id');
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
    $this->assertNotEmpty($this->title, 'COM_CAJOBBOARD_REPORT_ERR_TITLE');
    $this->assertNotEmpty($this->description, 'COM_CAJOBBOARD_REPORT_ERR_DESCRIPTION');
    $this->assertNotEmpty($this->url, 'COM_CAJOBBOARD_REPORT_ERR_URL');

		parent::check();

    return $this;
  }
}
