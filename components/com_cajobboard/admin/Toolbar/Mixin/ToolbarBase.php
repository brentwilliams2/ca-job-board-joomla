<?php
/**
 * Admin Toolbar
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Toolbar\Mixin;

// no direct access
defined('_JEXEC') or die;

use \Joomla\CMS\Toolbar\ToolbarHelper as JToolBarHelper;
use \Joomla\CMS\Language\Text;

trait ToolbarBase
{
	/**
	 * Return an array of all views to show in toolbar submenu
	 *
	 * @return  array  A list of all views
	 */
	protected function getSubmenuViews()
	{ // COM_CAJOBBOARD_TITLE_ADDRESSREGIONS
    return array(
      'AddressRegions',
      'AnalyticAggregates',
      'Answers',
      'ApplicationLetters',
      'Applications',
      'AudioObjects',
      'BackgroundChecks',
      'Candidates',
      'Certifications',
      'Comments',
      'ControlPanels',
      'CreditReports',
      'DataFeeds',
      'DataFeedTemplates',
      'DigitalDocuments',
      'DiversityPolicies',
      'EmailMessages',
      'EmailMessageTemplates',
      'EmployerAggregateRatings',
      'EmploymentTypes',
      'FairCreditReportingAct',
      'GeoCoordinates',
      'ImageObjects',
      'Interviews',
      'IssueReportCategories',
      'IssueReports',
      'JobAlerts',
      'JobPostings',
      'Messages',
      'OccupationalCategories',
      'OccupationalCategoryGroups',
      'Offers',
      'OrganizationRoles',
      'Organizations',
      'OrganizationTypes',
      'Persons',
      'Places',
      'Profiles',
      'QAPages',
      'QuestionLists',
      'Questions',
      'References',
      'Registrations',
      'Reports',
      'ResumeAlerts',
      'Resumes',
      'Reviews',
      'Schedules',
      'ScoreCards',
      'SearchResultPages',
      'TaskActions',
      'TaskLists',
      'Vendors',
      'VideoObjects',
      'WorkFlows'
    );
  }


	/**
	 * Append all submenu links to $linkbar class property
	 *
	 * @return  void
	 */
	public function renderSubmenu()
	{
    $views = $this->getSubmenuViews();

    $activeView = $this->container->input->getCmd('view', 'cpanel');

		foreach ($views as $view)
		{
			$name = Text::_( strtoupper($this->container->componentName) . '_TITLE_' . strtoupper($view) );

      $link = 'index.php?option=' . $this->container->componentName . '&view=' . $view;

      $active = $view == $activeView;

			$this->appendLink($name, $link, $active);
		}
  }


  /**
   * Renders the title for admin pages
   *
   * @param   string    $task   The task of the page the title should be rendered for
   */
  public function renderTitle($task)
  {
    // Set toolbar title, defaulting to control panel
    $view = $this->container->inflector->pluralize($this->container->input->getCmd('view', 'cpanel'));

    $title_key = Text::_('COM_CAJOBBOARD');

    // e.g. COM_CAJOBBOARD_TITLE_CONTROLPANELS_DEFAULT
    $subtitle_key = Text::_(strtoupper('COM_CAJOBBOARD_TITLE_' . $view . '_' . $task));

    // Displays title as e.g. "Calligraphic Job Board: Control Panel" at top of admin screen
    JToolBarHelper::title($title_key . ': ' . $subtitle_key, 'com_cajobboard');
  }
}
