<?php
 /**
  * Organizations List Item View Template
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
  $organizationID       = $item->organization_id;                       // Surrogate primary key
  $aggregateRating	    = $item->AggregateRating;                       // The overall rating, based on a collection of reviews or ratings, of the item, FK to organization_reviews table
  $createdBy            = $item->created_by;                            // User ID who created the record
  $createdOn            = $item->created_on;                            // Timestamp of record creation
  $diversityPolicy      = $item->DiversityPolicy;	                      // Statement on diversity policy of the organization,  FK to #__content table via DiversityPolicies model
  $email                = $item->email;                                 // RFC 3696 Email address.
  $employees            = $item->Employees;                             // Someone working for this organization. Supersedes employees, FK to user table
  $faxNumber            = $item->fax_number;                            // The E.164 PSTN fax number.
  $featured             = $item->featured;                              // Whether this content item is featured or not.
  $hits                 = $item->hits;                                  // Number of hits the content item has received on the site.
  $pictures             = $item->Image;                                 // Images of the organization, FK to ImageObjects table
  $MainOfficeStreet     = $item->Locations->address__street_address;    // Street address of the main office
  $MainOfficeLocality   = $item->Locations->address__address_locality;  // City or locality of the main office
  $MainOfficePostalCode = $item->Locations->address__postal_code;       // Zip or postal code of the main office
  $MainOfficeRegion     = $item->Locations->address__address_region;    // State or region of the main office
  $MainOfficeCountry    = $item->Locations->address__address_country;   // Country of the main office
  $MainOfficeGeo        = $item->Locations->geo;                        // Longitude and latitude of the main office
  $MainOfficeopenHours  = $item->Locations->openingHoursSpecification;  // Business hours for the main office
  $logoSlug             = $item->Logo->slug;                            // A logo for this organization, FK to ImageObjects table
  $logoURL              = $item->Logo->url;                             // URL of the logo
  $logoThumbnail        = $item->Logo->thumbnail;                       // URL of a thumbnail of the logo
  $logoHeight           = $item->Logo->height;                          // Height of the logo
  $logoWidth            = $item->Logo->width;                           // Width of the logo
  $logoAltText          = $item->Logo->name;                            // Alternate text to use for the logo
  $memberOf             = $item->member_of;                             // An Organization (or ProgramMembership) to which this Person or Organization belongs.
  $modifiedBy           = $item->modified_by;                           // User ID who modified the record
  $modifiedOn           = $item->modified_on;                           // Timestamp of record modification
  $legalName            = $item->legal_name;                            // The official name of the organization.
  $organizationName     = $item->name;                                  // The name of this organization.
  $numberOfEmployees    = $item->number_of_employees;                   // The number of employees in an organization e.g. business.
  $organizationType     = $item->OrganizationType->itemListElement;     // The type of organization e.g. Employer, Recruiter, etc., FK to OrganizationType
  $parentOrganization   = $item->ParentOrganization;                    // The larger organization that this organization is a subOrganization of, if any.
  $reviews              = $item->Reviews;                               // A review of the item. Supersedes reviews.
  $shortDescription     = $item->disambiguating_description;            // A short description of the organization, for example to use on listing pages.
  $slug                 = $item->slug;                                  // Alias for SEF URL
  $telephone            = $item->telephone;                             // The E.164 PSTN telephone number, array with required "default" key and optional alternative numbers
  $url                  = $item->url;                                   // URL of organization's website.
  $RoleName             = $item->RoleName->role_name;                   // The role of the organization e.g. Employer, Recruiter, etc., FK to #__cajobboard_organization_role
  $Branches             = $item->Branches;

  // current user ID
  $userId = $this->container->platform->getUser()->id;
?>

{{--
  #1 - Employer Name
--}}
@section('organization_name')
  <h4>@lang('COM_CAJOBBOARD_ORGANIZATIONS_EMPLOYER_NAME')</h4>
  {{{ $organizationName }}}
@overwrite


{{--
  #2 - Employer Logo
--}}
@section('organization_logo')
  {{-- @TODO: use slug --}}
  <a class="media-object organization-logo" href="@route('index.php?option=com_cajobboard&view=Employer&task=read&id='. (int) $organizationID)">
    <img src="{{{ $logoURL }}}" alt="{{{ $logoAltText }}}">
  </a>
@overwrite


{{--
  #3 -
--}}
@section('organization_type')
  <h4>@lang('COM_CAJOBBOARD_ORGANIZATIONS_ORGANIZATION_TYPE')</h4>
  @lang($organizationType)
@overwrite


{{--
  #4 -
--}}
@section('role_name')
  <h4>@lang('COM_CAJOBBOARD_ORGANIZATIONS_ROLE_NAME')</h4>
  @lang($roleName)
@overwrite


{{--
  #5 -
--}}
@section('')
  <h4>@lang('COM_CAJOBBOARD_ORGANIZATIONS_')</h4>
  {{{ $organizationName }}}
@overwrite


{{--
  #6 -
--}}
@section('')
  <h4>@lang('COM_CAJOBBOARD_ORGANIZATIONS_')</h4>
  {{{ $organizationName }}}
@overwrite


{{--
  #7 -
--}}
@section('')
  <h4>@lang('COM_CAJOBBOARD_ORGANIZATIONS_')</h4>
  {{{ $organizationName }}}
@overwrite


{{--
  #8 -
--}}
@section('')
  <h4>@lang('COM_CAJOBBOARD_ORGANIZATIONS_')</h4>
  {{{ $organizationName }}}
@overwrite


{{--
  #9 -
--}}
@section('')
  <h4>@lang('COM_CAJOBBOARD_ORGANIZATIONS_')</h4>
  {{{ $organizationName }}}
@overwrite


{{--
  #10 -
--}}
@section('')
  <h4>@lang('COM_CAJOBBOARD_ORGANIZATIONS_')</h4>
  {{{ $organizationName }}}
@overwrite


{{--
  #11 -
--}}
@section('')
  <h4>@lang('COM_CAJOBBOARD_ORGANIZATIONS_')</h4>
  {{{ $organizationName }}}
@overwrite


{{--
  Responsive container for desktop and mobile
--}}
<div class="organization-list-item">{{-- @TODO: Need to make the main container linkable $item->slug, and add special class if $item->featured --}}
  <div>
    @yield('organization_logo')
    @yield('organization_name')
    @yield('organization_type')
    @yield('role_name')

  </div>{{-- End main container --}}
  <div class="clearfix"></div>
</div>{{-- End responsive container --}}
