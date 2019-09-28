<?php
/**
 * Site Issue Report Categories Model for abusive content
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

use FOF30\Container\Container;

/**
 * Fields:
 *
 * UCM
 * @property int      $issue_report_category_id   Surrogate primary key.

 * SCHEMA: CreativeWork
 * @property string   $category   The category of abusive content report, e.g. spam, inappropriate language, etc.
 * @property string   $url        Link to schema for type of complaint, e.g. wikipedia page on Profanity
 */
class IssueReportCategories extends \Calligraphic\Cajobboard\Admin\Model\IssueReportCategories
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
