<?php
 /**
  * Reviews List View Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // Framework classes
  // use JUri;

  // no direct access
  defined('_JEXEC') or die;

  // collection of review postings model objects for this list view
  $items = $this->getItems();

  // current user ID
  $userId = $this->container->platform->getUser()->id;
?>

@section('header')
  <h4>Reviews</h4>
@show

@section('sidebar')
  <p></p>
@show

@section('item')
  <div class="container-fluid review-posting-list">
    @each('site:com_cajobboard/Reviews/default_item', $items, 'item', 'text|COM_CAJOBBOARD_REVIEWS_NO_REVIEWS_FOUND')
  </div>
@show

@section('footer')
  <p></p>
@show


{{--
  Singleton "report a review" modal (only load once)

  Javascript links a singleton modal into all buttons
--}}
{{-- @TODO: Javascript to power report review modal, and give the form a target to send to --}}
@section('report-review-modal')
  {{-- only take bandwidth hit of including modal HTML if user is logged in --}}
  @if ( !$userId == 0 )
    <div class="modal fade" id="report-review-modal" tabindex="-1" role="dialog" aria-labelledby="reportReviewModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

          <div class="modal-header">
            {{-- button with an "X" to close the modal, top right-hand corner --}}
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="reportReviewModalLabel">
                @lang('COM_CAJOBBOARD_REVIEWS_REPORT_REVIEW_HEADER_DESC')
            </h4>
          </div>

          <div class="modal-body">
            <form id="report-review-form">
              {{-- "Describe the problem" and text input form element --}}
              <div id="report-review" class="form-group">
                <textarea class="form-control" id="report-review-text-box">
                    @lang('COM_CAJOBBOARD_REPORT_REVIEW_INPUT_BOX_PLACEHOLDER')
                </textarea>
              </div>

              {{-- Javascript responsible for setting a hidden input with id="report-review-id" with value of that review's id number --}}
              <input id="report-review-id" type="hidden" value="0">
            </form>
          </div>

          <div class="modal-footer">
            <div>
              <div> {{-- button row --}}
                {{-- "Send" button to report review --}}
                <span class="float-right">
                  <button id="submit-review-report-button" class="btn btn-primary btn-xs" type="submit" form="report-review-form">
                    @lang('COM_CAJOBBOARD_REPORT_REVIEW_SUBMIT_BUTTON_LABEL')
                  </button>
                </span>

                {{-- Close button to cancel modal --}}
                <span class="float-right">
                  <button type="button" class="btn btn-default btn-xs" data-dismiss="modal">
                    @lang('COM_CAJOBBOARD_CLOSE_BUTTON_LABEL');
                  </button>
                </span>
              </div> {{-- END button row --}}
            </div>
          </div> {{-- End Footer --}}

        </div>
      </div>
    </div>
  @endif
@show


{{--
  Load singleton "login or register" modal if user is a guest
--}}
@if ( $userId == 0 )
  @include('site:com_cajobboard/ViewTemplateHelpers/login_or_register_modal')
@endif
