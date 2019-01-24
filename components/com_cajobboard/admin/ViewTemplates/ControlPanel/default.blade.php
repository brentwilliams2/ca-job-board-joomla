<?php
 /**
  * Admin Control Panel View Template
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
  <h1>@lang('COM_CAJOBBOARD_ADMIN_CONTROL_PANEL_PAGE_TITLE')</h1>
@overwrite


@section('sidebar')
  <p></p>
@overwrite


@section('item')
  <p></p>
@overwrite


@section('footer')
  <p></p>
@overwrite


<div class="clearfix"></div>

<div>
  <div class="row">
    <div class="col-md-12 control-panel-header">
      @yield('header')
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
      @yield('sidebar')
    </div>

    <div class="col-md-8">
      <div class="row">
        @yield('item')
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      @yield('footer')
    </div>
  </div>
</div>