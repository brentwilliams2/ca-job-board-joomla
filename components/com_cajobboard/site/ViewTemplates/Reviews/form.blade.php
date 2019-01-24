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

  $isEditTask = $this->task == 'edit';
  
  // model data fields
  $reviewID               = $item->review_id;
  //$author                 = $item->Author;                  // The author of this content or rating (always hidden), FK to #__users
  $createdBy              = $item->created_by;                // userid of the creator of this review.
  $createdOn              = $item->created_on;
  $featured               = $item->featured;                  // bool whether this review is featured or not
  $hits                   = $item->hits;                      // Number of hits this review has received
  $modifiedBy             = $item->modified_by;               // userid of person that modified this review.
  $modifiedOn             = $item->modified_on;
  $ratingValue            = $item->rating_value;              // The rating for the content. Default worstRating 1 and bestRating 5 assumed.  Nullable.
  $reviewBody             = $item->review_body;               // The actual body of the review.
  $slug                   = $item->slug;                      // Alias for SEF URL
  $title                  = $item->name;                      // A title for this review.

  $employerName           = $isEditTask ? $item->ItemReviewed->name : null;        // The employer being reviewed/rated
  $employerID             = $isEditTask ? $item->ItemReviewed->organization_id : null;

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
        @lang('COM_CAJOBBOARD_REVIEWS_EMPLOYER_NAME_EDIT')
    </label>
  </h4>
  {{-- @TODO: fill employer list from database, see controller. Don't set value if this is an add screen. --}}
  <select class="form-control" name="item_reviewed" id="employer" value="{{{ $employerName }}}" >
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
        @lang('COM_CAJOBBOARD_REVIEWS_RATING_EDIT')
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
        @lang('COM_CAJOBBOARD_REVIEWS_TITLE_EDIT_LABEL')
    </label>
  </h4>
  <input type="text" class="form-control" name="name" id="review_title" value="{{{ $title }}}" placeholder="@lang('COM_CAJOBBOARD_REVIEWS_TITLE_EDIT_PLACEHOLDER')" />
@overwrite

{{--
  #4 - Body text of review
--}}
@section('review_text')
  <h4>
    <label for="title">
        @lang('COM_CAJOBBOARD_REVIEWS_TEXT_EDIT')
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
              @lang('COM_CAJOBBOARD_REVIEWS_EDIT_REVIEW_HEADER')
            @else
              @lang('COM_CAJOBBOARD_REVIEWS_ADD_REVIEW_HEADER')
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




