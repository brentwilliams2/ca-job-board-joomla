<?php
 /**
  * Admin Control Panel Sidebar Menu Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // no direct access
  defined('_JEXEC') or die;

  use \Joomla\CMS\Uri\Uri;

  $root = Uri::base(false);

  // @TODO: See the code in FOF30\Toolbar renderSubmenu() for ideas

  /*
(link title, icon, url, submenu items)

Analytics
Job Postings
ATS
  Applications
  References
  Recommendations
  Questionnaires
  Score Cards
  Candidates
  Tasks
  Scheduling
Subscriptions
Job Alerts
Resumes
Profiles
  Employer
  Job Seeker
  Recruiter
  Connector
Social Media
  Facebook
  Linkedin
  Twitter
  Instagram
Other
  Q&A
  Messages
  Reviews
  Places
  Media
    Images
    Audio
    Video
  Comments
  */
?>

<div class="control-panel-sidebar-nav">

  <!-- sidebar menu -->
  <ul class="sidebar-nav nav nav-list">
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown">
        <i class="icon-chart"></i>
        Q & A
        <span class="icon-arrow-down-3"></span>
      </a>

      <ul class="dropdown-menu">
        <li><a href="#">Questions</a></li>
      <li><a href="{{ $root }}index.php?option=com_cajobboard&view=Answers">Answers</a></li>
      </ul>
    </li>
  </ul>
  <!-- /sidebar menu -->

  <!-- /menu footer buttons -->
  <div class="row sidebar-footer">
    <a
      href="#"
      class="span3 hasTip"
      title="@lang('COM_CAJOBBOARD_CONTROL_PANEL_TOOLTIP_SEARCH_TITLE')::@lang('COM_CAJOBBOARD_CONTROL_PANEL_TOOLTIP_SEARCH_DESC')"
    >
      <span class="icon-search" aria-hidden="true"></span>
    </a>

    <a
      href="#"
      class="span3 hasTip"
      title="@lang('COM_CAJOBBOARD_CONTROL_PANEL_TOOLTIP_HELP_TITLE')::@lang('COM_CAJOBBOARD_CONTROL_PANEL_TOOLTIP_HELP_DESC')"
    >
      <span class="icon-info" aria-hidden="true"></span>
    </a>

    <a
      href="#"
      class="span3 hasTip"
      title="@lang('COM_CAJOBBOARD_CONTROL_PANEL_TOOLTIP_OPTIONS_TITLE')::@lang('COM_CAJOBBOARD_CONTROL_PANEL_TOOLTIP_OPTIONS_DESC')"
    >
      <span class="icon-options" aria-hidden="true"></span>
    </a>

    <a
    href="#"
      class="span3 hasTip"
      title="@lang('COM_CAJOBBOARD_CONTROL_PANEL_TOOLTIP_HIDE_MENU_TITLE')::@lang('COM_CAJOBBOARD_CONTROL_PANEL_TOOLTIP_HIDE_MENU_DESC')"
    >
      <span class="icon-delete" aria-hidden="true"></span>
    </a>
  </div>
  <!-- /menu footer buttons -->
</div>