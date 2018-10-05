<?php
 /**
  * Reviews Edit View Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // Framework classes
  JLog::add('in form.blade.php', JLog::DEBUG, 'cajobboard');

  // no direct access
  defined('_JEXEC') or die;

  $item = $this->getItem();

  // model data fields
  $reviewID     = $item->review_id;
  $employerName = $reviewID ? $item->ItemReviewed->legal_name : null;  // The employer being reviewed/rated
  $employerID   = $reviewID ? $item->ItemReviewed->organization_id : null;
  $reviewTitle  = $item->name;  // A name for this review, used to automatically generate the URL slug
  $reviewBody   = $item->review_body;   // The actual body of the review.
  $ratingValue  = $item->rating_value ? $item->rating_value : 5;  // The rating for the content. Default worstRating 1 and bestRating 5 assumed. Set to 5 by default for new reviews.
  // $item->Author;        // The author of this content or rating (always hidden), FK to #__users

  // current user ID
  $userId = $this->container->platform->getUser()->id;

  // URL to post the form to
  $task = $this->getTask();
  $action = 'index.php?option=' . $this->getContainer()->componentName . '&view=' . $this->getName();
  if ($task === 'edit') $action .= '&id=' . $this->getItem()->getId();
?>

{{-- @TODO: move JQuery module loads to View file --}}
@js('media://com_cajobboard/js/rater.min.js')

{{--
  #1 - Employer reviewed
--}}
@section('employer')
  <h4>
    <label for="employer">
        @lang('COM_CAJOBBOARD_EDIT_REVIEW_EMPLOYER_NAME')
    </label>
  </h4>
  {{-- @TODO: fill employer list from database, see controller --}}
  <select class="form-control" name="item_reviewed" id="employer" value="{{{ $employerName }}}">
      <option value="1">Elite Properties</option>
      <option value="2">Action Property</option>
  </select>
@overwrite

{{--
  #2 - Total rating value for employer
--}}
@section('review_rating')
  <h4>
    <label>
        @lang('COM_CAJOBBOARD_EDIT_REVIEW_RATING')
    </label>
  </h4>
  <div class="rating" data-rate-value={{ $ratingValue }}></div>
@overwrite


{{--
  #3 - A title for this review
--}}
@section('review_title')
  <h4>
    <label>
        @lang('COM_CAJOBBOARD_EDIT_REVIEW_TITLE')
    </label>
  </h4>
  <input type="text" class="form-control" name="name" id="review_title" value="{{{ $reviewTitle }}}" placeholder="@lang('COM_CAJOBBOARD_EDIT_REVIEW_TITLE_INPUT_BOX_PLACEHOLDER')" />
@overwrite

{{--
  #4 - Body text of review
--}}
@section('review_text')
  <h4>
    <label for="title">
        @lang('COM_CAJOBBOARD_EDIT_REVIEW_TEXT')
    </label>
  </h4>
  <textarea name="review_body" id="review_text" class="form-control" rows="8">
    {{{ $reviewBody }}}
  </textarea>
@overwrite


{{--
  Responsive component
--}}
@section('review-edit-container')
  <form action="{{{ $action }}}" method="post" name="siteForm" id="siteForm" class="cajobboard-form">

    <div class="review-edit-container">
      <div class="cajobboard-edit-form" id="cajobboard-review-edit-form">

        <header class="block-header">
          <h3>
            @if($task === 'edit')
              @lang('COM_CAJOBBOARD_EDIT_REVIEW_HEADER')
            @else
              @lang('COM_CAJOBBOARD_ADD_REVIEW_HEADER')
            @endif
          </h3>
        </header>

        <div class="form-group">
          @yield('review_title')
        </div>

        <div class="form-group">
          @yield('employer')
        </div>

        <div class="form-group">
            @yield('review_rating')
        </div>

        <div class="form-group">
            @yield('review_text')
        </div>

        <button class="btn btn-primary pull-right review-submit" type="submit">
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




