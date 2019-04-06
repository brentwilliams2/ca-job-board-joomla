<?php
 /**
  * Reviews Item View Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // Framework classes

  // no direct access
  defined('_JEXEC') or die;

  $item = $this->getItem();

  // model data fields
  $reviewID               = $item->review_id;
  //$author                 = $item->Author;                  // The author of this content or rating (always hidden), FK to #__users
  $createdBy              = $item->created_by;                // userid of the creator of this comment.
  $createdOn              = $item->created_on;
  $description            = $item->description;               // A short description of this comment.
  $employerName           = $item->ItemReviewed->name;        // The employer being reviewed/rated
  $employerID             = $item->ItemReviewed->organization_id;
  $featured               = $item->featured;                  // bool whether this comment is featured or not
  $hits                   = $item->hits;                      // Number of hits this comment has received
  $modifiedBy             = $item->modified_by;               // userid of person that modified this comment.
  $modifiedOn             = $item->modified_on;
  $ratingValue            = $item->rating_value;              // The rating for the content. Default worstRating 1 and bestRating 5 assumed.
  $reviewBody             = $item->review_body;               // The actual body of the review.
  $slug                   = $item->slug;                      // Alias for SEF URL
  $title                  = $item->name;                      //  A title for this review.

  // current user ID
  $userId = $this->container->platform->getUser()->id;
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
    <button type="button" class="btn btn-primary btn-xs btn-review show-full-review-button pull-right">
      @lang('COM_CAJOBBOARD_REVIEWS_SHOW_FULL_REVIEW_BUTTON_LABEL')
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
    <button type="button" class="btn btn-primary btn-xs btn-review guest-report-review-button" data-toggle="modal" data-target="#login-or-register-modal">
      @lang('COM_CAJOBBOARD_REPORT_REVIEW_BUTTON_LABEL')
    </button>
  @else
    {{-- Logged-in user, show modal for emailing a job --}}
    <button
      type="button"
      id="report-job-button-{{{ $reviewID }}}"
      class="btn btn-danger btn-xs btn-review report-review-button pull-right"
      data-toggle="modal"
      data-target="#report-review-modal"
      data-reviewid="{{ $reviewID }}"
    >
      @lang('COM_CAJOBBOARD_REPORT_REVIEW_BUTTON_LABEL')
    </button>
  @endif
@overwrite

{{--
  #6 - Edit Button for logged-in users
--}}
@section('edit_review')
  {{-- @TODO: Fix access control on edit review button --}}
  @if ($userId != 0)
    <a class="edit-review-link" href="@route('index.php?option=com_cajobboard&view=Review&task=edit&id='. (int) $reviewID)">
      <button type="button" class="btn btn-warning btn-xs btn-review edit-review-button pull-right">
        @lang('COM_CAJOBBOARD_REVIEWS_EDIT_REVIEW_BUTTON_LABEL')
      </button>
    </a>
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

    <div>
      @yield('edit_review')
      @yield('report_review')
      @yield('show_full_review')
    </div>

  </div>{{-- End main container --}}
  <div class="clearfix"></div>
</div>{{-- End responsive container --}}
