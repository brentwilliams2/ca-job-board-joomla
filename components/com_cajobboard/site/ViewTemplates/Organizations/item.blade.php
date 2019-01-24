<?php
 /**
  * Organizations Item View Template
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

  $item = $this->getItem();

  // model data fields
  $organization_id      = $item->organization_id;               // Surrogate primary key
  $AggregateRating	    = $item->AggregateRating;               // The overall rating, based on a collection of reviews or ratings, of the item, FK to employer_reviews table
  $createdBy            = $item->created_by;                    // User ID who created the record, auto-filled by save().
  $createdOn            = $item->created_on;                    // Timestamp of record creation, auto-filled by save().
  $description          = $item->description;                   // A description of the item.
  $DiversityPolicy      = $item->DiversityPolicy;	              // Statement on diversity policy of the employer,  FK to #__content table via DiversityPolicies model
  $email                = $item->email;                         // RFC 3696 Email address.
  $Employee             = $item->Employee;                      // Someone working for this organization. Supersedes employees, FK to user table
  $faxNumber            = $item->fax_number;                    // The E.164 PSTN fax number.
  $featured             = $item->featured;                      // Whether this content item is featured or not.
  $hits                 = $item->hits;                          // Number of hits the content item has received on the site.
  $Image                = $item->Image;                         // Images of the employer, FK to ImageObjects table
  $Location             = $item->Location;                      // Where the organization is located, FK to Places
  $Logo                 = $item->Logo;                          // A logo for this organization, FK to ImageObjects table
  $memberOf             = $item->member_of;                     // An Organization (or ProgramMembership) to which this Person or Organization belongs.
  $modifiedBy           = $item->modified_by;                   // User ID who modified the record, auto-filled by save(), touch().
  $modifiedOn           = $item->modified_on;                   // Timestamp of record modification, auto-filled by save(), touch().
  $name                 = $item->legal_name;                    // The official name of the employer.
  $name                 = $item->name;                          // The name of this organization.
  $numberOfEmployees    = $item->number_of_employees;           // The number of employees in an organization e.g. business.
  $OrganizationType     = $item->OrganizationType;              // The type of organization e.g. Employer, Recruiter, etc., FK to OrganizationType
  $ParentOrganization   = $item->ParentOrganization;            // The larger organization that this organization is a subOrganization of, if any.
  $Review               = $item->Review;                        // A review of the item. Supersedes reviews.
  $shortDescription     = $item->disambiguating_description;    // A short description of the employer, for example to use on listing pages.
  $slug                 = $item->slug;                          // Alias for SEF URL
  $telephone            = $item->telephone;                     // The E.164 PSTN telephone number, array with required "default" key and optional alternative numbers
  $url                  = $item->url;                           // URL of employer's website.

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
