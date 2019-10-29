<?php
 /**
  * Places Item View Template
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
?>

{{--
  #1 -
--}}
@section('employer')
  {{-- link to employer profile, unless this is being showed on that page already --}}
  <a class="media-object employer-logo" href="@route('index.php?option=com_cajobboard&view=Employer&task=read&id='. (int) $employerID)">
    {{{ $employerName }}}
  </a>
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

{{--
  Modal templates used in common for all default_item views, only
  take bandwidth hit of including modal HTML if user is logged in
--}}
@if ( !$isGuestUser )
  @yield('report-item-modal')
@endif
