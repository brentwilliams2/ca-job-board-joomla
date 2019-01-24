<?php
 /**
  * Admin Media List View Template
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
?>


@section('header')
  <h1></h1>
@overwrite


@section('sidebar')
  <div>
    {{ $this->sidebar }}
  </div>
@overwrite


@section('item')
  <div class="container-fluid media-list">
    Job Board Media Manager
  </div>
@overwrite


@section('footer')
  <p></p>
@overwrite

<div class="media-content-container">
  <div class="row">
    <div class="span12">
      @yield('header')
    </div>
  </div>

  <div class="row">
    <div class="span2">
      @yield('sidebar')
    </div>
    <div class="span10">
      @yield('item')
    </div>
  </div>

  <div class="row">
    <div class="span12">
      @yield('footer')
    </div>
  </div>
</div>
