<?php
 /**
  * Places Edit View Template
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
  $placeID                    = $item->place_id;
  $address__address_country   = $item->address__address_country;  // The two-letter ISO 3166-1 alpha-2 country code
  $address__address_locality  = $item->address__address_locality; // The locality, e.g. Mountain View
  $address__postal_code       = $item->address__postal_code;      // The postal code, e.g. 94043
  $address__street_address    = $item->address__street_address;   // The street address, e.g. 1600 Amphitheatre Pkwy
  $address_region             = $item->address_region;            // The name of the region, e.g. California', FK to #__cajobboard_util_address_region(address_region)
  $branch_code                = $item->branch_code;               // A short textual code that uniquely identifies a place of business
  $created_by                 = $item->created_by;                // userid of the creator of this place.
  $createdOn                  = $item->created_on;                // When this place record was created
  $description                = $item->description;               // A long description of this place.
  $fax_number                 = $item->fax_number;                // The E.164 PSTN fax number
  $featured                   = $item->featured;                  // bool whether this place is featured or not
  $geo                        = $item->geo;                       // Array of MySQL GIS spatial data type latitude and longitude of place, e.g. [longitude, latitude];
  $hits                       = $item->hits;                      // Number of hits this place has received
  $logoAltText                = $item->logo->name;                // Alt text for the logo image
  $logoURL                    = $item->logo->thumbnail;           // A logo image that represents this place, FK to #__cajobboard_images(image_id)
  $modifiedBy                 = $item->modified_by;               // userid of person that modified this place.
  $modifiedOn                 = $item->modified_on;               // When this place record was modified
  $openingHoursSpecification  = $item->openingHoursSpecification; // The days and times this location is open.
  $photos                     = $item->photo;                     // A photograph of this place, FK M:M relationship in to #__cajobboard_images(image_id)
  $placeName                  = $item->name;                      // A name for this place.
  $public_access              = $item->public_access;             // A boolean flag to signal that the Place is open to public visitors. If this property is omitted there is no assumed default boolean value
  $telephone                  = $item->telephone;                 // The E.164 PSTN telephone number

  // current user ID
  $userId = $this->container->platform->getUser()->id;

  // URL to post the form to
  $task = $this->getTask();
  $action = 'index.php?option=' . $this->getContainer()->componentName . '&view=' . $this->getName();
  if ($task === 'edit') $action .= '&id=' . $this->getItem()->getId();
?>

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





{{--
  Modal templates used in common for all default_item views, only
  take bandwidth hit of including modal HTML if user is logged in
--}}
@if ( !$isGuestUser )
  @yield('report-item-modal')
@endif
