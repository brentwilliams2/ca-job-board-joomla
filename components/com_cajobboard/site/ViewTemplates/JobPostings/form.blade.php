<?php
 /**
  * Site Job Postings Edit View Template
  *
  * @package   Calligraphic Job Board
  * @version   October 5, 2019
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2019 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // Framework classes
  use \FOF30\Utils\FEFHelper\BrowseView;
  use \FOF30\Utils\SelectOptions;
  use \Calligraphic\Cajobboard\Site\Helper\Format;
  use \Joomla\CMS\Language\Text;

  // no direct access
  defined('_JEXEC') or die;

  $item = $this->getItem();

  // @TODO: Need Database field for employer's requisition / job number and EEO statement

  // @TODO: Need access control for new records. Separate into add and edit files?
?>

{{--
  #1 - Name of Employer
  // @TODO: Need to provide access control for who should be able to change the employer a job posting links to
  // @TODO: Should provide a drop-down list of employers to choose from that the user belongs to / can create job postings for
  // @TODO: How do I know what employers a user belongs to?    #__cajobboard_organizations_employees
  // @TODO: Can the employer be changed after the job posting is created?
--}}
@section('employer_name')
  <div class="employer-name">
    <h4>
      <label for="text">
        @lang('COM_CAJOBBOARD_JOB_POSTINGS_EMPLOYER_EDIT_LABEL')
      </label>
    </h4>

    <a
      class="media-object employer-logo"
      href="@route('index.php?option=com_cajobboard&view=Employer&task=read&id='. $this->getEmployerId($item) )"
    >
      <img src="{{{ $this->getEmployerLogoSource($item) }}}" alt="{{{ $this->getEmployerLogoCaption($item) }}}">
    </a class="media-object">

    <input
      type="text"
      class="form-control"
      name="employer-name"
      id="employer-name"
      value="{{ $this->getEmployerName($item) }}"
    />
  </div>
@overwrite


{{--
  #2 - Job Posting Title
--}}
@section('job_title')
  <div class="job-title">
    <h4>
      <label for="text">
        @lang('COM_CAJOBBOARD_JOB_POSTINGS_TITLE_EDIT_LABEL')
      </label>
    </h4>

    <input
      type="text"
      class="form-control"
      name="job-title-text"
      id="job-title-text"
      value="{{ $this->getTitle($item) }}"
      rows="8"
    />
  </div>
@overwrite




{{--
  Responsive container for desktop and mobile
--}}
<div class="job-posting-item">{{-- @TODO: Need to make the main container linkable $item->slug, and add special class if $item->featured --}}

  {{-- #1 Employer Logo --}}
  <div class="employer-name-container">
    @yield('employer_name')
  </div>
  
  {{-- Main container --}}
  <div class="job-posting-list-item-main-container col-md-10 col-xs-12">

    <div class="row">
      <div class="col-md-9 col-xs-12">

        <div class="row">
          <div class="col-xs-12">
            {{-- #2 Job Title --}}
            @yield('job_title')

          </div>
        </div>

      </div>

    </div>

  </div>{{-- End main container --}}

  <div class="clearfix"></div>

</div>{{-- End responsive container --}}