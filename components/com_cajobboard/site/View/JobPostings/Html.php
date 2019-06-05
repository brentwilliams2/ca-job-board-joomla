<?php
/**
 * Job Postings HTML View
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\View\JobPostings;

use \FOF30\Container\Container;
use \Calligraphic\Cajobboard\Site\View\Common\BaseHtml;
use \Joomla\CMS\Component\ComponentHelper;
use \Joomla\CMS\Factory;

// no direct access
defined('_JEXEC') or die;

class Html extends BaseHtml
{
	/**
	 * The aggregate reviews data for each job posting
	 *
	 * @var  array  Indexed array of PHP objects containing aggregate review data
   */
   protected $aggregateReviews;

	/**
	 * Overridden. Load view-specific language file.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    // Add view template helper for Job Postings to container
    $config['template_path'] = $container->thisPath . '/ViewTemplates/JobPostings';

    parent::__construct($container, $config);

    $this->loadLanguageFileForView('job_postings');

    // Load javascript file for Job Posting views
    $this->addJavascriptFile('media://com_cajobboard/js/Site/jobPostings.js');

    // Vendor lib for the star-rating widget
    $this->addJavascriptFile('media://com_cajobboard/js/Vendor/rater.min.js');
  }

  /*
   * Actions to take before list view is executed
   *
   * @return  void
   */
	protected function onBeforeBrowse()
	{
    // Relations to eager-load
    $this->setupBrowse(array(
      'HiringOrganization',
      'JobLocation',
      'EmploymentType',
      'OccupationalCategory',
      'AggregateReviews'
    ));
  }
}
