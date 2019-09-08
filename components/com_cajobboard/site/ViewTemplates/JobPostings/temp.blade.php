


{{--
  #3 - Job Tag, e.g. "New!" or "Featured" -- from parameters for item, or Joomla! tags?
  // @TODO: Need to provide access control based on subscriptions / monetization for premium features
  // @TODO: Need Javascript to enable dynamic adding / removing buttons, like Answers?
--}}
@section('job_tag')
  <select
    class="form-control"
    name="job-title-text"
    id="job-title-text"
    value="{{{ $job_title }}}"
    rows="8"
    placeholder="<?php echo $this->escape(isset($job_title) ? $job_title : \JText::_('COM_CAJOBBOARD_JOB_POSTINGS_JOB_TAG_EDIT_PLACEHOLDER')); ?>"
  >
    <?php if ($tags->itemTags) : ?>

      <?php foreach ($tags->itemTags as $key => $tag) : ?>
        <option class="job-title-tag"><?php echo $tag->title; ?></option>
      <?php endforeach; ?>

    <?php else: ?>

      <option class="job-title-tag">
          @lang('COM_CAJOBBOARD_JOB_POSTINGS_JOB_TAG_EDIT_LABEL')
      </option>

    <?php endif; ?>
  </select>
@overwrite


{{--
  #4 - Description of Job
--}}
@section('job_description')
  <h4>
    <label for="text">
      @lang('COM_CAJOBBOARD_JOB_POSTINGS_JOB_DESCRIPTION_EDIT_LABEL')
    </label>
  </h4>

  {{-- @TODO: Tooltip for: @lang('COM_CAJOBBOARD_JOB_POSTINGS_ITEM_JOB_DESCRIPTION_DESC') --}}
  <span>
    {{ $item->description }}
  </span>
@overwrite


{{--
  #5 - Job Location, link to map slider via Javascript
  // @TODO: Need a query on all localities and regions to put into combo boxes
--}}
@section('job_location')
  <h4>
    <label for="text">
      @lang('COM_CAJOBBOARD_JOB_POSTINGS_LOCATION_EDIT_LABEL')
    </label>
  </h4>

  <p>{{{ $item->jobLocation->address__address_locality }}}</p>
  {{-- @TODO need to add $item->jobLocation->address__address_region after repository finished --}}
@overwrite


{{--
  #6 - Employer Rating, e.g. 1-5 stars and link to Reviews page
--}}
@section('employer_rating')
  <h4>
    <label for="text">
      @lang('COM_CAJOBBOARD_JOB_POSTINGS_TITLE_EDIT_LABEL')
    </label>
  </h4>

  <a href="/index.php?view=Employers&task=read&id={{ $aggregateReview->hiring_organization }}">
    <div class="rating" data-rate-value={{ $aggregateReview->rating_value }}></div>
  </a>
@overwrite

{{--
  #7 - Employer Reviews, e.g. number of reviews and link to Reviews page
--}}
@section('employer_reviews')
  <h4>
    <label for="text">
      @lang('COM_CAJOBBOARD_JOB_POSTINGS_TITLE_EDIT_LABEL')
    </label>
  </h4>

  <a href="/index.php?view=Employers&task=read&id={{ $aggregateReview->hiring_organization }}">
    @plural('COM_CAJOBBOARD_JOB_POSTINGS_REVIEW_COUNT', $aggregateReview->review_count)
  </a>
@overwrite


{{--
  #8 - Date Job Posted, format adjustable in parameters
--}}
@section('date_job_posted')
  <h4>
    <label for="text">
      @lang('COM_CAJOBBOARD_JOB_POSTINGS_TITLE_EDIT_LABEL')
    </label>
  </h4>

  <span>
    @lang('COM_CAJOBBOARD_JOB_POSTINGS_POSTED_TIME_AGO')
    <?php echo Format::convertToTimeAgoString($item->created_on, $item->modified_on); ?>
  </span>

  {{-- @TODO: check configuration for how to display, e.g. exact date and what format, or "days ago" format --}}
  <span class="comment-posted-date">
    @lang('COM_CAJOBBOARD_JOB_POSTINGS_POSTED_ON_BUTTON_LABEL')
    <?php echo date("d/m/Y", strtotime($createdOn)); ?>
  </span>

@overwrite


{{--
  #9 - Job Hours, e.g. Part-Time, Full-Time
--}}
@section('job_hours')
  <h4>
    <label for="text">
      @lang('COM_CAJOBBOARD_JOB_POSTINGS_TITLE_EDIT_LABEL')
    </label>
  </h4>

  <span>
    {{-- @TODO: Tooltip with description of employment type --}}
    {{ $employmentType }}
  </span>
@overwrite


{{--
  #10 - Pay, e.g. "$14 - $15 Per Hour"
--}}
@section('job_pay')
  @if ($formattedPay)
    <h4>
      <label for="text">
        @lang('COM_CAJOBBOARD_JOB_POSTINGS_TITLE_EDIT_LABEL')
      </label>
    </h4>

    <span>
      {{ $formattedPay }}
    </span>
  @endif
@overwrite


{{--
  #11 - Tag Line, e.g. "Earn Extra Cash"
--}}
@section('tag_line')
  {{-- @TODO: Implement tag line --}}
@overwrite


{{--
  #12 - Benefits, e.g. "Includes medical and dental insurance"
--}}
@section('job_benefits')
  @if($item->job_benefits)
    <h4>
      <label for="text">
        @lang('COM_CAJOBBOARD_JOB_POSTINGS_TITLE_EDIT_LABEL')
      </label>
    </h4>

    {{-- @TODO: Tooltip for: @lang('COM_CAJOBBOARD_JOB_POSTINGS_ITEM_JOB_BENEFITS_DESC') --}}
    <span>
      {{ $item->job_benefits }}
    </span>
  @endif
@overwrite


{{--
  #13 - Educational requirements for the job
--}}
@section('education_requirements')
  @if($item->education_requirements)
    <h4>
      @lang('COM_CAJOBBOARD_JOB_POSTINGS_ITEM_EDUCATION_REQUIREMENTS')
    </h4>
    {{-- @TODO: Tooltip for: @lang('COM_CAJOBBOARD_JOB_POSTINGS_ITEM_EDUCATION_REQUIREMENTS_DESC') --}}
    <span>
      {{ $item->education_requirements }}
    </span>
  @endif
@overwrite


{{--
  #14 - Experience requirements for the job
--}}
@section('experience_requirements')
  @if($item->experience_requirements)
    <h4>
      @lang('COM_CAJOBBOARD_JOB_POSTINGS_ITEM_EXPERIENCE_REQUIREMENTS')
    </h4>

    <h4>
      <label for="text">
        @lang('COM_CAJOBBOARD_JOB_POSTINGS_TITLE_EDIT_LABEL')
      </label>
    </h4>

    {{-- @TODO: Tooltip for: @lang('COM_CAJOBBOARD_JOB_POSTINGS_ITEM_EXPERIENCE_REQUIREMENTS_DESC') --}}
    <span>
      {{ $item->experience_requirements }}
    </span>
  @endif
@overwrite


{{--
  #15 - Any incentive or bonus compensation for the job
--}}
@section('incentive_compensation')
  @if($item->incentive_compensation)
    <h4>
      @lang('COM_CAJOBBOARD_JOB_POSTINGS_ITEM_INCENTIVE_COMPENSATION')
    </h4>

    <h4>
      <label for="text">
        @lang('COM_CAJOBBOARD_JOB_POSTINGS_TITLE_EDIT_LABEL')
      </label>
    </h4>

    {{-- @TODO: Tooltip for: @lang('COM_CAJOBBOARD_JOB_POSTINGS_ITEM_INCENTIVE_COMPENSATION_DESC') --}}
    <span>
      {{ $item->incentive_compensation }}
    </span>
  @endif
@overwrite


{{--
  #16 - Qualifications for job
--}}
@section('qualifications')
  @if($item->qualifications)
    <h4>
      @lang('COM_CAJOBBOARD_JOB_POSTINGS_ITEM_QUALIFICATIONS')
    </h4>

    <h4>
      <label for="text">
        @lang('COM_CAJOBBOARD_JOB_POSTINGS_TITLE_EDIT_LABEL')
      </label>
    </h4>

    {{-- @TODO: Tooltip for: @lang('COM_CAJOBBOARD_JOB_POSTINGS_ITEM_QUALIFICATIONS_DESC') --}}
    <span>
      {{ $item->qualifications }}
    </span>
  @endif
@overwrite


{{--
  #17 - Responsibilities of job
--}}
@section('responsibilities')
  @if($item->responsibilities)
    <h4>
      @lang('COM_CAJOBBOARD_JOB_POSTINGS_ITEM_RESPONSIBILITIES')
    </h4>

    <h4>
      <label for="text">
        @lang('COM_CAJOBBOARD_JOB_POSTINGS_TITLE_EDIT_LABEL')
      </label>
    </h4>

    {{-- @TODO: Tooltip for: @lang('COM_CAJOBBOARD_JOB_POSTINGS_ITEM_RESPONSIBILITIES_DESC') --}}
    <span>
      {{ $item->responsibilities }}
    </span>
  @endif
@overwrite


{{--
  #18 - Skills necessary to do this job
--}}
@section('skills')
  @if($item->skills)
    <h4>
      @lang('COM_CAJOBBOARD_JOB_POSTINGS_ITEM_SKILLS')
    </h4>

    <h4>
      <label for="text">
        @lang('COM_CAJOBBOARD_JOB_POSTINGS_TITLE_EDIT_LABEL')
      </label>
    </h4>

    {{-- @TODO: Tooltip for: @lang('COM_CAJOBBOARD_JOB_POSTINGS_ITEM_SKILLS_DESC') --}}
    <span>
      {{ $item->skills }}
    </span>
  @endif
@overwrite


{{--
  #19 - Any special commitments required for job - travelling, etc.
--}}
@section('special_commitments')
  @if($item->special_commitments)
    <h4>
      @lang('COM_CAJOBBOARD_JOB_POSTINGS_ITEM_SPECIAL_COMMITMENTS')
    </h4>

    <h4>
      <label for="text">
        @lang('COM_CAJOBBOARD_JOB_POSTINGS_TITLE_EDIT_LABEL')
      </label>
    </h4>

    {{-- @TODO: Tooltip for: @lang('COM_CAJOBBOARD_JOB_POSTINGS_ITEM_SPECIAL_COMMITMENTS_DESC') --}}
    <span>
      {{ $item->special_commitments }}
    </span>
  @endif
@overwrite


{{--
  Responsive component
--}}
@section('comment-edit-container')
  <form action="<?php echo $this->getFormActionUrl(); ?>" method="post" name="siteForm" id="siteForm" class="cajobboard-form">

    <div class="comment-edit-container">
      <div class="cajobboard-edit-form" id="cajobboard-comment-edit-form">

        <header class="block-header">
          <h3>
            @if($task === 'edit')
              @lang('COM_CAJOBBOARD_JOB_POSTINGS_EDIT_HEADER')
            @else
              @lang('COM_CAJOBBOARD_JOB_POSTINGS_ADD_HEADER')
            @endif
          </h3>
        </header>

        <div class="form-group">
          <h4>@yield('comment_title')</h4>
        </div>

        <div class="form-group">
          <p>@yield('comment_text')</p>
        </div>

        <div class="form-group">
          @yield('comment_posted_date')
        </div>

        <div class="form-group">
          @yield('comment_modified_date')
        </div>

        <button class="btn btn-primary pull-right comment-submit" type="submit">
          @lang('COM_CAJOBBOARD_SUBMIT_BUTTON_LABEL')
        </button>

      </div>
    </div>

    {{-- Hidden form fields --}}
    <div class="cajobboard-form-hidden-fields">
      <input type="hidden" name="@token()" value="1"/>
    </div>
  </form>
@show









{{--
  Responsive container for desktop and mobile
--}}
<div class="job-posting-item">{{-- @TODO: Need to make the main container linkable $item->slug, and add special class if $item->featured --}}

  {{-- sm, md, and large screens only: #1 Employer Logo --}}
  <div class="employer-logo-container col-md-2 hidden-xs">
    @yield('employer_logo')
  </div>

  {{-- Main container --}}
  <div class="job-posting-list-item-main-container col-md-10 col-xs-12">

    {{--
      #2 Job Title, #3 Job Tag, #7 "Save Job" Button, #12 "Quick Apply" Button
    --}}
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

    {{--
      #4 Name of Employer, #10 Employer Rating, #11 Employer Review
    --}}
    <div class="row">
      {{-- #4 Name of Employer --}}
      <div class="col-md-8 col-sm-9">
        @yield('employer_name')
      </div>
      {{-- #10 Employer Rating --}}
      <div class="col-md-2 col-sm-3">
        @yield('employer_rating')
      </div>
      {{-- md and lg screens only: #11 Employer Reviews --}}
      <div class="col-md-2 hidden-sm hidden-xs">
        @yield('employer_reviews')
      </div>
    </div>

    {{--
      #5 Job Location, #14 Job Hours, #15 Pay
    --}}
    <div class="row">
      <div class="col-md-9 col-xs-6">
        <div class="row">
          {{-- #5 Job Location --}}
          <div class="col-xs-12">
            @yield('job_location')
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

    {{--
      #6 Description of Job, #17 Benefits, #18 Education, #19 Experience, #20 Incentives, #21 Qualifications, #22 Responsibilities, #23 Skills, #24 Commitments
    --}}
    <div class="row">
      <div class="col-xs-12">
        {{-- #6 Job Description --}}
        @yield('job_description')
      </div>
    </div>

    <div class="row hidden-sm hidden-xs">
      <div class="col-xs-12">
        {{-- #17 Benefits --}}
        @yield('job_benefits')
      </div>
    </div>

    <div class="row hidden-sm hidden-xs">
      <div class="col-xs-12">
        {{-- #18 Educational Requirements --}}
        @yield('education_requirements')
      </div>
    </div>

    <div class="row hidden-sm hidden-xs">
      <div class="col-xs-12">
        {{-- #19 Experience Required --}}
        @yield('experience_requirements')
      </div>
    </div>

    <div class="row hidden-sm hidden-xs">
      <div class="col-xs-12">
        {{-- #20 Incentive Compensation --}}
        @yield('incentive_compensation')
      </div>
    </div>

    <div class="row hidden-sm hidden-xs">
      <div class="col-xs-12">
        {{-- #21 Qualifications Required --}}
        @yield('qualifications')
      </div>
    </div>

    <div class="row hidden-sm hidden-xs">
      <div class="col-xs-12">
        {{-- #22 Job Responsibilities --}}
        @yield('responsibilities')
      </div>
    </div>

    <div class="row hidden-sm hidden-xs">
      <div class="col-xs-12">
        {{-- #23 Skills Required --}}
        @yield('skills')
      </div>
    </div>

    <div class="row hidden-sm hidden-xs">
      <div class="col-xs-12">
        {{-- #24 Special Commitments Required --}}
        @yield('special_commitments')
      </div>
    </div>

    {{-- md and lg screens: #7 "Save Job" Button, #8 "Email Job" Button, #9 "Report Job" Button, #13 Date Job Posted --}}
    <div class="row hidden-sm hidden-xs">
      <span class="float-left">
        {{-- #7 "Save Job" Button --}}
        @yield('save_job')
        @yield('save_job_modal')
      </span>

      <span class="float-left">
        {{-- #8 "Email Job" Button --}}
        @yield('email_job')
      </span>

      <span class="float-left">
        {{-- #9 "Report Job" Button --}}
        @yield('report_job')
      </span>

      <span class="float-right">
        {{-- #13 Date Job Posted --}}
        @yield('date_job_posted')
      </span>
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
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#save-job-{{ $item->job_posting_id }}">
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
      id="save-job-{{ $item->job_posting_id }}"
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


INSERT INTO `j_cajobboard_job_postings`
(
  `slug`,
  `created_on`,
  `created_by`,
  `publish_up`,
  `params`,
  `cat_id`,
  `note`,
  `name`,
  `description`,
  `description__intro`,
  `image`,
  `education_requirements`,
  `experience_requirements`,
  `incentive_compensation`,
  `job_benefits`,
  `qualifications`,
  `responsibilities`,
  `skills`,
  `special_commitments`,
  `work_hours`,
  `job_location`,
  `hiring_organization`,
  `relevant_occupation_name`,
  `base_salary__value`,
  `base_salary__currency`,
  `base_salary__duration`,
  `identifier`,
  `same_as`,
  `employment_type`,
  `occupational_category`
)
VALUES
(
  `test-job-posting`,
  `2017-04-27 07:01:50`,
  `815`,
  `2017-04-27 07:01:50`,
  `params`,
  `55`,
  `some test note text`,
  `Hiring Dishwashers`,
  `A description of dishwashing job`,
  `A short description of dishwashing job`,
  `image`,
  `some test education requirements`,
  `some test experience requirements`,
  `some test incentive compensation`,
  `some test job benefits`,
  `some test qualifications`,
  `some test responsibilities`,
  `some test skills`,
  `some test special commitments`,
  `Days`,
  `1`,
  `1`,
  `some test relevant occupation name (job title)`,
  `2000`,
  `USD`,
  `P2W`,
  `identifier`,
  `same_as`,
  `employment_type`,
  `occupational_category`
);