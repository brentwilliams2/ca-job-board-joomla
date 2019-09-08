<?php
 /**
  * Job Postings Site Browse View Template
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

  // collection of job postings model objects for this list view
  // @TODO: Move to directive?
  $items = $this->getItems();
?>

@section('header')
  {{--
    First row of input boxes for searches:
      job title
      location

    Second row of combo box searches:
      job type search box (part-time, etc.)
      date posted search box (last day, last week, etc.)
      easy apply included / easy apply only
      salary range (glassdoor has nice histogram graph and option for "include jobs with no salary data")
      more: modal with drop downs for distance, ratings, city, industry, company, size

    Create job alert button
  --}}
  <h1></h1>
@show


@section('sidebar')
  <p></p>
@show


@section('item')
  <div class="container-fluid job-posting-list">
    @each('site:com_cajobboard/JobPostings/default_item', $items, 'item', 'text|COM_CAJOBBOARD_JOB_POSTINGS_NO_JOB_POSTS_FOUND')
  </div>
@show


@section('footer')
  <p></p>
@show


{{-- only take bandwidth hit of including modal HTML if user is logged in --}}
@if ( $this->isUserLoggedIn() )
  @yield('email-a-job-modal')
  @yield('report-job-modal')
  @yield('login-or-register-modal')
@endif
