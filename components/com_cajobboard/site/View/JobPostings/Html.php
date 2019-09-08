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

use \Calligraphic\Cajobboard\Site\View\Common\BaseHtml;
use \FOF30\Container\Container;
use \Joomla\CMS\Component\ComponentHelper;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Helper\TagsHelper;
use \Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;

class Html extends BaseHtml
{
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


//-------------------------------------------------------------------------------------
// @TODO: Maybe these should be refactored into their own class?
// @TODO: Need to provide access control for who should be able to change the employer a job posting links to
// @TODO: Should provide a drop-down list of employers to choose from that the user belongs to / can create job postings for
// @TODO: How do I know what employers a user belongs to?    #__cajobboard_organizations_employees
// @TODO: Can the employer be changed after the job posting is created?

  /**
   *
   *
   * @param   string    $item
   *
   * @return  boolean
   */
  public function getEmployerLogoSource($item)
  {
    if ( isset($item->id) )
    {
      // @TODO: can we pull a model-through-a-model like this?
      return $this->container->template->parsePath( $item->hiringOrganization->Logo->thumbnail );
    }

    // @TODO: Return a translated string and display a blank logo?
  }


  /**
   *
   *
   * @param   string    $item
   *
   * @return  boolean
   */
  public function getEmployerLogoCaption($item)
  {
    if ( isset($item->id) )
    {
      // @TODO: can we pull a model-through-a-model like this?
      return $item->hiringOrganization->Logo->caption;
    }

    return Text::_('COM_CAJOBBOARD_JOB_POSTINGS_LOGO_CAPTION_EDIT_PLACEHOLDER');
  }


  /**
   *
   *
   * @param   string    $item
   *
   * @return  boolean
   */
  public function getEmployerId($item)
  {
    if ( isset($item->id) )
    {
      return (int) $item->hiringOrganization->organization_id;
    }
  }


  /**
   *
   *
   * @param   string    $item
   *
   * @return  boolean
   */
  public function getEmployerName($item)
  {
    if ( isset($item->id) )
    {
      // @TODO: hiringOrganization->legal_name?
      return $item->hiringOrganization->organization_title;
    }

    return Text::_('COM_CAJOBBOARD_JOB_POSTINGS_EMPLOYER_NAME_EDIT_PLACEHOLDER');
  }

//-------------------------------------------------------------------------------------



  /**
   *
   *
   * @param   string    $item
   *
   * @return  boolean
   */
  public function getEmploymentType($item)
  {
    if ( isset($item->id) )
    {
      return Text::_($item->employmentType->name);
    }
  }


  /**
   *
   *
   * @param   string    $item
   *
   * @return  boolean
   */
  public function getFormattedPay($item)
  {
    if ( isset($item->id) )
    {
      return $this->container->JobPosting->formatPayToValueOrRange(
        $item->base_salary__value,
        $item->base_salary__min_value,
        $item->base_salary__max_value,
        $item->base_salary__duration
      );
    }
  }
}
