<?php
 /**
  * Image Objects (photos) List View Template
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

  // collection of review postings model objects for this list view
  $items = $this->getItems();
?>


@section('header')
  <h1></h1>
@show


@section('sidebar')
  <p></p>
@show


@section('item')
  <div class="container-fluid job-posting-list">
      {{--@each('site:com_cajobboard/ImageObjects/default_item', $items, 'item', 'text|COM_CAJOBBOARD_JOB_POSTINGS_NO_JOB_POSTS_FOUND')--}}

    @forelse($items as $item)
      @include('site:com_cajobboard/ImageObjects/default_item', array('item' => $item, 'displaySize' => 'large'))
    @empty
      @lang('COM_CAJOBBOARD_JOB_POSTINGS_NO_JOB_POSTS_FOUND')
    @endforelse

  </div>
@show


@section('footer')
  <p></p>
@show
