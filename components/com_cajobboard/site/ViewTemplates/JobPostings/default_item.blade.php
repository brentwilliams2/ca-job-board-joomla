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
  use Jlog;

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

  JLog::add($item->hiringOrganization->legal_name, JLog::DEBUG, 'cajobboard');
?>

{{--
  #1 - Employer Logo, link to Employer Profile
--}}
@section('employer_logo')
  <span>Logo</span>
  <a href="#">
    <img class="media-object" src="" alt="">
  </a>
  <p>{{-- $item->hiringOrganization --}}</p>
@endsection

{{--
  #2 - Job Title
--}}
@section('job_title')
  {{{ $item->title }}}
@endsection

{{--
  #3 - Job Tag, e.g. "New!" or "Featured"
--}}
@section('job_tag')
  <span>Job Tag</span>
@endsection

{{--
  #4 - Name of Employer
--}}
@section('employer_name')
  <span>Employer Name</span>
  <p>{{-- $item->hiringOrganization --}}</p>
@endsection

{{--
  #5 - Job Location, link to map slider via Javascript
--}}
@section('job_location')
  <p>Location</p>
  <p>{{-- $item->jobLocation --}}</p>
@endsection

{{--
  #6 - Short Description of Job
--}}
@section('job_description')
  {{ $item->disambiguating_description }}
@endsection

{{--
  #7 - "Save Job" Button
--}}
@section('save_job')
  <button type="button" class="btn btn-primary">
    @lang('COM_CAJOBBOARD_JOB_POSTINGS_SAVE_JOB_BUTTON_LABEL')
  </button>
@endsection

{{--
  #8 - "Email Job" Button
--}}
@section('email_job')
  <button type="button" class="btn btn-primary">
    @lang('COM_CAJOBBOARD_JOB_POSTINGS_EMAIL_JOB_BUTTON_LABEL')
  </button>
@endsection

{{--
  #9 - "Report Job" Button
--}}
@section('report_job')
  <button type="button" class="btn btn-warning">
    @lang('COM_CAJOBBOARD_JOB_POSTINGS_REPORT_JOB_BUTTON_LABEL')
  </button>
@endsection

{{--
  #10 - Job Rating, e.g. 1-5 stars and link to Reviews page
--}}
@section('job_rating')
  <span>Job Rating</span>
@endsection

{{--
  #11 - Job Reviews, e.g. number of reviews and link to Reviews page
--}}
@section('job_reviews')
  <span>Job Reviews</span>
@endsection

{{--
  #12 - "Quick Apply" Button
--}}
@section('quick_apply')
  <button type="button" class="btn btn-primary">
    @lang('COM_CAJOBBOARD_JOB_POSTINGS_QUICK_APPLY_BUTTON_LABEL')
  </button>
@endsection

{{--
  #13 - Date Job Posted, format adjustable in parameters
--}}
@section('date_job_posted')
  <span>Date Posted</span>
  <p>{{-- $item->created_on --}}</p>
  <p>{{-- $item->modified_on --}}</p>
@endsection

{{--
  #14 - Job Hours, e.g. Part-Time, Full-Time
--}}
@section('job_hours')
  <span>Hours</span>
  <p>{{-- $item->employmentType --}}</p>
@endsection

{{--
  #15 - Benefits, e.g. "Includes medical and dental insurance"
--}}
@section('job_benefits')
  <span>Benefits</span>
@endsection

{{--
  #16 - Pay, e.g. "$14 - $15 Per Hour"
--}}
@section('job_pay')
  <span>Pay</span>
  <p>{{-- $item->base_salary__max_value --}}</p>
  <p>{{-- $item->base_salary__value --}}</p>
  <p>{{-- $item->base_salary__min_value --}}</p>
  <p>{{-- $item->base_salary__duration --}}  {{-- P0H1 per hour, P1D per day, P1W per week, P2W biweekly, P1M per month, P1Y annually --}}
@endsection

{{--
  #17 - Tag Line, e.g. "Earn Extra Cash"
--}}
@section('tag_line')
  <span>Tag Line</span>
@endsection

{{-- Responsive container for desktop and mobile --}}
<div class="job-posting-list-item wrapper">{{-- @TODO: Need to make the main container linkable $item->slug, and add special class if $item->featured --}}

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
</div>{{-- End responsive container --}}



