<?php
 /**
  * Answers List View Item Template
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

  // model data fields
  $answerID = $item->answer_id;
  $created_by = $item->created_by; // userid of the creator of this answer.
  $createdOn = $item->created_on;
  $description = $item->description; // Text of the answer.
  $downvoteCount = $item->downvote_count; // Downvote count for this item.
  $featured = $item->featured; // bool whether this answer is featured or not
  $hits = $item->hits; // Number of hits this answer has received
  $isPartOf = $item->isPartOf; // This property points to a QAPage entity associated with this answer. FK to #__cajobboard_qapage(qapage_id)
  $modifiedBy = $item->modified_by; // userid of person that modified this answer.
  $modifiedOn = $item->modified_on;
  $name = $item->name; // A title to use for the answer.
  $parentItem = $item->parentItem; // The question this answer is intended for. FK to #__cajobboard_questionss(question_id)
  $Publisher = $item->Publisher; // The company that wrote this answer. FK to #__organizations(organization)id).
  $slug = $item->slug; // Alias for SEF URL
  $text = $item->text; // The actual text of the answer itself.
  $upvoteCount = $item->upvote_count; // Upvote count for this item.

?>

{{--
  #1 - Employer reviewed
--}}
@section('employer')
  {{-- link to employer profile, unless this is being showed on that page already --}}
  <a class="media-object employer-logo" href="@route('index.php?option=com_cajobboard&view=Employer&task=read&id='. (int) $employerID)">
    {{{ $employerName }}}
  </a>
@overwrite

{{--
  #2 - Total rating value for employer
--}}
@section('review_rating')
  <div class="rating" data-rate-value={{ $ratingValue }}></div>
@overwrite

{{--
  #3 - Body text of review
--}}
@section('review_text')
  <p class="review-text">
    {{{ $reviewBody }}}
  </p>
@overwrite

{{--
  #4 - "Show Full Review" Button

  Javascript links a singleton modal into all buttons
--}}
@section('show_full_review')
  <a class="show-full-review-anchor" href="@route('index.php?option=com_cajobboard&view=Review&task=read&id='. (int) $reviewID)">
    <button type="button" class="btn btn-primary btn-xs btn-reviews show-full-review-button pull-right">
      @lang('COM_CAJOBBOARD_SHOW_FULL_REVIEW_BUTTON_LABEL')
    </button>
  </a>
@overwrite

{{--
  #5 - "Report Rating" Button

  Javascript links a singleton modal into all buttons
--}}
@section('report_review')
  @if ( $userId == 0 )
    {{-- Guest user. Only a singleton login / register modal included on page. --}}
    <button type="button" class="btn btn-primary btn-xs btn-reviews guest-report-review-button" data-toggle="modal" data-target="#login-or-register-modal">
      @lang('COM_CAJOBBOARD_REPORT_REVIEW_BUTTON_LABEL')
    </button>
  @else
    {{-- Logged-in user, show modal for emailing a job --}}
    <button
      type="button"
      id="report-job-button-{{{ $reviewID }}}"
      class="btn btn-danger btn-xs btn-reviews report-review-button pull-right"
      data-toggle="modal"
      data-target="#report-review-modal"
      data-reviewid="{{ $reviewID }}"
    >
      @lang('COM_CAJOBBOARD_REPORT_REVIEW_BUTTON_LABEL')
    </button>
  @endif
@overwrite


{{--
  Responsive container for desktop and mobile
--}}
<div class="review-list-item">{{-- @TODO: Need to make the main container linkable $item->slug, and add special class if $item->featured --}}
  <div>

    @yield('employer')
    @yield('review_rating')
    @yield('review_text')
    @yield('report_review')
    @yield('show_full_review')

  </div>{{-- End main container --}}
  <div class="clearfix"></div>
</div>{{-- End responsive container --}}
