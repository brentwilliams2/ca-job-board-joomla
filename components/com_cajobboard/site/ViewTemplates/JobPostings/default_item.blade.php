<?php
 /**
  * Job Postings Item for Browse View Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // Framework classes
  use FOF30\Utils\FEFHelper\BrowseView;
  use FOF30\Utils\SelectOptions;
  use JUri;
  //use Jlog;

  // no direct access
  defined('_JEXEC') or die;

  // Plural translation strings:
  // @plural('COM_USERS_N_USERS_ACTIVATED', count($ids))
  // COM_USERS_N_USERS_ACTIVATED_0="No users activated"
  // COM_USERS_N_USERS_ACTIVATED_1="User successfully activated"
  // COM_USERS_N_USERS_ACTIVATED="%s Users successfully activated"

  // Translation string substitution:
  // @sprintf('STRING_WITH_NUMBERS_IN_IT', $num1, $num2, $num3)
  // STRING_WITH_NUMBERS_IN_IT="First %d, second %d, third %d"

  $job_id         = $item->job_posting_id;
  $job_title      = $item->title;
  $logo_source    = $this->container->template->parsePath($item->jobLocation->Logo->thumbnail);
  $logo_caption   = $item->jobLocation->Logo->caption;
  $employer_id    = $item->hiringOrganization->organization_id;
  $tags = new \JHelperTags;
  $tags->getItemTags('com_cajobboard.jobpostings', $item->id);

  // @TODO set $saved to $this->saved field after the saved job join table is added to repository, and update in #7 "Saved Job" button
  $saved = false;

  // @TODO "Share this" social media button on job
?>

{{--
  #1 - Employer Logo, link to Employer Profile
--}}
@section('employer_logo')
  <a class="media-object employer-logo" href="@route('index.php?option=com_cajobboard&view=Employer&task=read&id='. (int) $employer_id)">
    <img src="{{{ $logo_source }}}" alt="{{{ $logo_caption }}}">
  </a>
  <p>{{-- $ --}}</p>
@overwrite

{{--
  #2 - Job Title
--}}
@section('job_title')
  <a class="job-title" href="@route('index.php?option=com_cajobboard&view=JobPosting&task=read&id='. (int) $job_id)">
    <span>{{{ $job_title }}}</span>
  </a>
@overwrite

{{--
  #3 - Job Tag, e.g. "New!" or "Featured" -- from parameters for item, or Joomla! tags?
--}}
@section('job_tag')
  <?php if ($tags->itemTags) : ?>
    <?php foreach ($tags->itemTags as $key => $tag) : ?>
        <span class="job-title-tag"><?php echo $tag->title; ?></span>
    <?php endforeach; ?>
  <?php else: ?>
    <span class="job-title-tag">Great!</span>
  <?php endif; ?>
@overwrite

{{--
  #4 - Name of Employer
--}}
@section('employer_name')
  <a class="employer-name" href="@route('index.php?option=com_cajobboard&view=Employer&task=read&id='. (int) $employer_id)">
    <span>{{{ $item->hiringOrganization->legal_name }}}</span>
  </a>
@overwrite

{{--
  #5 - Job Location, link to map slider via Javascript
--}}
@section('job_location')
  <p>Location</p>
  <p>{{-- $item->jobLocation --}}</p>
@overwrite

{{--
  #6 - Short Description of Job
--}}
@section('job_description')
  {{ $item->disambiguating_description }}
@overwrite

{{--
  #7 - "Save Job" Button
--}}
@section('save_job')
  @if ( $userId == 0 )
    {{-- Guest user. Only a singleton login / register modal included on page. --}}
    <button type="button" class="btn btn-primary btn-md btn-job-posting guest-save-job-button" data-toggle="modal" data-target="#login-or-register-modal">
      @lang('COM_CAJOBBOARD_JOB_POSTINGS_SAVE_JOB_BUTTON_LABEL')
    </button>

  @elseif ( !$saved )
    {{-- Logged-in user, job hasn't been saved --}}
    <button type="button" id="registered-save-job-button-{{{ $job_id }}}" class="btn btn-primary btn-md btn-job-posting save-job-button">
      @lang('COM_CAJOBBOARD_JOB_POSTINGS_SAVE_JOB_BUTTON_LABEL')
    </button>
    {{-- Hidden success button to show after saved --}}
    {{-- @TODO: Add hyperlink to saved jobs list view --}}
    <button type="button" id="job-saved-button-{{{ $job_id }}}" class="btn btn-primary btn-md btn-job-posting job-saved-button hidden" disabled="disabled">
      @lang('COM_CAJOBBOARD_JOB_POSTINGS_JOB_SAVED_BUTTON_LABEL')
    </button>
  @else
    {{-- Logged-in user, job has already been saved --}}
    {{-- @TODO: Add hyperlink to saved jobs list view --}}
    <button type="button" class="btn btn-primary btn-md btn-job-posting job-saved-button" disabled="disabled">
      @lang('COM_CAJOBBOARD_JOB_POSTINGS_JOB_SAVED_BUTTON_LABEL')
    </button>
  @endif
@overwrite

{{--
  #8 - "Email Job" Button

  Javascript links a singleton modal into all buttons
--}}
@section('email_job')
  @if ( $userId == 0 )
    {{-- Guest user. Only a singleton login / register modal included on page. --}}
    <button type="button" class="btn btn-primary btn-md btn-job-posting guest-email-job-button" data-toggle="modal" data-target="#login-or-register-modal">
      @lang('COM_CAJOBBOARD_JOB_POSTINGS_EMAIL_JOB_BUTTON_LABEL')
    </button>
  @else
    {{-- Logged-in user, show modal for emailing a job --}}
    <button
      type="button"
      id="email-job-button-{{{ $job_id }}}"
      class="btn btn-primary btn-xs email-job-button registered-email-job-button"
      data-toggle="modal"
      data-target="#email-a-job-modal"
      data-jobid="{{{ $job_id }}}"
    >
      @lang('COM_CAJOBBOARD_JOB_POSTINGS_EMAIL_JOB_BUTTON_LABEL')
    </button>
  @endif
@overwrite

{{--
  #9 - "Report Job" Button

  Javascript links a singleton modal into all buttons
--}}
@section('report_job')
  @if ( $userId == 0 )
    {{-- Guest user. Only a singleton login / register modal included on page. --}}
    <button type="button" class="btn btn-primary btn-md btn-job-posting guest-email-job-button" data-toggle="modal" data-target="#login-or-register-modal">
      @lang('COM_CAJOBBOARD_JOB_POSTINGS_REPORT_JOB_BUTTON_LABEL')
    </button>
  @else
    {{-- Logged-in user, show modal for emailing a job --}}
    <button
      type="button"
      id="report-job-button-{{{ $job_id }}}"
      class="btn btn-primary btn-xs email-job-button report-job-button"
      data-toggle="modal"
      data-target="#report-job-modal"
      data-jobid="{{{ $job_id }}}"
    >
      @lang('COM_CAJOBBOARD_JOB_POSTINGS_REPORT_JOB_BUTTON_LABEL')
    </button>
  @endif
@overwrite

{{--
  #10 - Job Rating, e.g. 1-5 stars and link to Reviews page
--}}
@section('job_rating')
  <span>Job Rating</span>
@overwrite

{{--
  #11 - Job Reviews, e.g. number of reviews and link to Reviews page
--}}
@section('job_reviews')
  <span>Job Reviews</span>
@overwrite

{{--
  #12 - "Quick Apply" Button
--}}
@section('quick_apply')
  <button type="button" class="btn btn-primary btn-xs">
    @lang('COM_CAJOBBOARD_JOB_POSTINGS_QUICK_APPLY_BUTTON_LABEL')
  </button>
@overwrite

{{--
  #13 - Date Job Posted, format adjustable in parameters
--}}
@section('date_job_posted')
  <span>Date Posted</span>
  <p>{{-- $item->created_on --}}</p>
  <p>{{-- $item->modified_on --}}</p>
@overwrite

{{--
  #14 - Job Hours, e.g. Part-Time, Full-Time
--}}
@section('job_hours')
  <span>Hours</span>
  <p>{{-- $item->employmentType --}}</p>
@overwrite

{{--
  #15 - Benefits, e.g. "Includes medical and dental insurance"
--}}
@section('job_benefits')
  <span>Benefits</span>
@overwrite

{{--
  #16 - Pay, e.g. "$14 - $15 Per Hour"
--}}
@section('job_pay')
  <span>Pay</span>
  <p>{{-- $item->base_salary__max_value --}}</p>
  <p>{{-- $item->base_salary__value --}}</p>
  <p>{{-- $item->base_salary__min_value --}}</p>
  <p>{{-- $item->base_salary__duration --}}  {{-- P0H1 per hour, P1D per day, P1W per week, P2W biweekly, P1M per month, P1Y annually --}}
@overwrite

{{--
  #17 - Tag Line, e.g. "Earn Extra Cash"
--}}
@section('tag_line')
  <span>Tag Line</span>
@overwrite

{{-- Responsive container for desktop and mobile --}}
<div class="job-posting-list-item">{{-- @TODO: Need to make the main container linkable $item->slug, and add special class if $item->featured --}}

  {{-- sm, md, and large screens only: #1 Employer Logo --}}
  <div class="employer-logo-container col-md-2 hidden-xs">
    @yield('employer_logo')
  </div>

  {{-- Main container --}}
  <div class="job-posting-list-item-main-container col-md-10 col-xs-12">

    {{-- #2 Job Title, #3 Job Tag, #7 "Save Job" Button, #12 "Quick Apply" Button  --}}
    <div class="row">
      <div class="col-md-9 col-xs-12">
        <div class="row">
          <div class="col-xs-12">
            {{-- #2 Job Title --}}
            @yield('job_title')
            {{-- #3 Job Tag --}}
            @yield('job_tag')
          </div>
        </div>
        <div class="row">
          {{-- #17 Tag Line --}}
          <div class="col-xs-12">
            @yield('tag_line')
          </div>
        </div>
      </div>
      {{-- md and lg screens only: #12 "Quick Apply" button --}}
      <div class="col-md-9  hidden-sm hidden-xs">
        @yield('quick_apply')
      </div>
    </div>

    {{-- #4 Name of Employer, #10 Job Rating, #11 Job Reviews --}}
    <div class="row">
      {{-- #4 Name of Employer --}}
      <div class="col-md-8 col-sm-9">
        @yield('employer_name')
      </div>
      {{-- #10 Job Rating --}}
      <div class="col-md-2 col-sm-3">
        @yield('job_rating')
      </div>
      {{-- md and lg screens only: #11 Job Reviews --}}
      <div class="col-md-2 hidden-sm hidden-xs">
        @yield('job_reviews')
      </div>
    </div>

    {{-- #5 Job Location, #15 Benefits, #14 Job Hours, #16 Pay --}}
    <div class="row">
      <div class="col-md-9 col-xs-6">
        <div class="row">
          {{-- #5 Job Location --}}
          <div class="col-xs-12">
            @yield('job_location')
          </div>
        </div>

          {{-- md and lg screens only: #15 Benefits --}}
        <div class="row hidden-sm hidden-xs">
          <div class="col-xs-12">
            @yield('job_benefits')
          </div>
        </div>
      </div>

      {{-- md and lg screens: Job Hours and Pay are stacked --}}
      <div class="col-md-3 hidden-sm hidden-xs">
        <div class="row">
          {{-- #14 Job Hours --}}
          <div class="col-xs-12">
            @yield('job_hours')
          </div>
        </div>

        <div class="row">
          {{-- #16 Pay --}}
          <div class="col-xs-12">
            @yield('job_pay')
          </div>
        </div>
      </div>

      {{-- sm and xs screens: Job Hours and Pay are side-by-side --}}
      <div class="col-xs-3 hidden-lg hidden-md">
        {{-- #14 Job Hours --}}
        @yield('job_hours')
      </div>

      <div class="col-xs-3 hidden-lg hidden-md">
        {{-- #16 Pay --}}
        @yield('job_pay')
      </div>
    </div>

    {{-- #6 Short Description of Job --}}
    <div class="row">
      <div class="col-xs-12">
        @yield('job_description')
      </div>
    </div>

    {{-- md and lg screens: #7 "Save Job" Button, #8 "Email Job" Button, #9 "Report Job" Button, #13 Date Job Posted --}}
    <div class="row hidden-sm hidden-xs">
      <div class="col-md-3">
        {{-- #7 "Save Job" Button --}}
        @yield('save_job')
        @yield('save_job_modal')
      </div>

      <div class="col-md-3">
        {{-- #8 "Email Job" Button --}}
        @yield('email_job')
      </div>

      <div class="col-md-3">
        {{-- #9 "Report Job" Button --}}
        @yield('report_job')
      </div>

      <div class="col-md-3">
        {{-- #13 Date Job Posted --}}
        @yield('date_job_posted')
      </div>
    </div>

    {{-- sm and xs screens: #13 Date Job Posted --}}
    <div class="row hidden-lg hidden-md">
      <div class="col-xs-12">
        @yield('date_job_posted')
      </div>
    </div>

    {{-- sm and xs screens: Modal for #7 "Save Job" Button and #8 "Email Job" Button, #9 Report Job, and #17 "Quick Apply" --}}
    <div class="row hidden-lg hidden-md">
      {{-- Button to trigger modal --}}
      <span class="pull-left">
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#save-job-{{ $this->job_posting_id }}">
          @lang('COM_CAJOBBOARD_JOB_POSTINGS_SAVE_JOB')
        </button>
      </span>
      {{-- #9 "Report Job" Button --}}
      <span class="pull-left">
        @yield('report_job')
      </span>
    </div>

    {{-- sm and xs screens: Save modal --}}
    <div
      class="modal fade hidden-lg hidden-md"
      id="save-job-{{ $this->job_posting_id }}"
      tabindex="-1"
      role="dialog"
      aria-labelledby="@lang('COM_CAJOBBOARD_JOB_POSTINGS_SAVE_MODAL_ARIA_LABEL')"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            {{-- #7 "Save Job" Button --}}
            <div class="row">
              <div class="col-xs-12">
                @yield('save_job')
              </div>
            </div>
            {{-- #8 "Email Job" Button --}}
            <div class="row">
              <div class="col-xs-12">
                @yield('email_job')
              </div>
            </div>
            {{-- #12 "Quick Apply" Button --}}
            <div class="row">
              <div class="col-xs-12">
                @yield('quick_apply')
              </div>
            </div>
          </div>{{-- End modal body --}}
        </div>{{-- End modal content --}}
      </div>{{-- End modal dialog --}}
    </div>{{-- End save modal --}}

  </div>{{-- End main container --}}
  <div class="clearfix"></div>
</div>{{-- End responsive container --}}
