<?php
 /**
  * Admin Common Browse View Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  * Use this by extending it, using -at- instead of the at-sign
  * -at-extends('admin:com_cajobboard/Common/browse')
  *
  * Override the following sections in the View's Blade template:
  *
  * browse-page-top
  *      Content to put above the form
  *
  * browse-page-bottom
  *      Content to put below the form
  *
  * browse-filters
  *      Filters to place above the table. They are placed inside an inline form. Wrap them in
  *      <div class="cajobboard-filter-element cajobboard-form-group">
  *
  * browse-table-header
  *      The table header. At the very least you need to add the table column headers. You can
  *      optionally add one or more <tr> with filters at the top.
  *
  * browse-table-body-withrecords
  *      [ Optional ] Loop through the records and create <tr>s.
  *
  * browse-table-body-norecords
  *      [ Optional ] The <tr> to show when no records are present. Default is the "no records" text.
  *
  * browse-table-footer
  *      [ Optional ] The table footer. By default that's just the pagination footer.
  *
  * browse-hidden-fields
  *      [ Optional ] Any additional hidden INPUTs to add to the form. By default this is empty.
  *      The default hidden fields (option, view, task, ordering fields, boxchecked and token) can
  *      not be removed.
  *
  * Do not override any other section
  */

  // no direct access
  defined('_JEXEC') or die;

  /** @var  FOF30\View\DataView\Html  $this */
?>

{{-----------------------------------------------------------------------------}}
{{-- SECTION: Filters above the table. ----------------------------------------}}
{{-----------------------------------------------------------------------------}}

@section('browse-filters')
@stop


{{-----------------------------------------------------------------------------}}
{{-- SECTION: Table column headers and filters --------------------------------}}
{{-----------------------------------------------------------------------------}}

@section('browse-table-header')
@stop


{{-----------------------------------------------------------------------------}}
{{-- SECTION: Table body shown when no records are present. -------------------}}
{{-----------------------------------------------------------------------------}}

@section('browse-table-body-norecords')
  <tr>
    <td colspan="99">
      @lang('COM_CAJOBBOARD_COMMON_NORECORDS')
    </td>
  </tr>
@stop


{{-----------------------------------------------------------------------------}}
{{-- SECTION: Table body shown when records are present. ----------------------}}
{{-----------------------------------------------------------------------------}}

@section('browse-table-body-withrecords')
  <?php $i = 0; ?>

  @foreach($this->items as $row)
    <tr>
      {{-- IMPLEMENT IN CHILD CLASSES --}}
    </tr>
  @endforeach
@stop


{{-----------------------------------------------------------------------------}}
{{-- SECTION: Table footer. The default is showing the pagination footer. -----}}
{{-----------------------------------------------------------------------------}}

@section('browse-table-footer')
    <tr>
        <td colspan="99" class="center">
            {{ $this->pagination->getListFooter() }}
        </td>
    </tr>
@stop


{{-----------------------------------------------------------------------------}}
{{-- SECTION: Put your additional hidden fields in this section ---------------}}
{{-----------------------------------------------------------------------------}}

@section('browse-hidden-fields')
@stop


{{-----------------------------------------------------------------------------}}
{{-- Main template, pulling in sections. --------------------------------------}}
{{-----------------------------------------------------------------------------}}

{{-- Any content displayed above the toolbar on admin pages --}}
@yield('browse-page-top')

{{-- Administrator form for browse views --}}
<form action="index.php" method="post" name="adminForm" id="adminForm" class="cajobboard-admin-form">
  <div id="j-main-container" class="span10">

    {{-- Toolbar shown at top of admin page, with search, filters, and ordering --}}
    <div id="filter-bar" class="btn-toolbar">
      @yield('browse-filters')
    </div>

    {{-- Main browse-view table for admin pages with column headers, body, and footer --}}
    <table class="table table-striped" id="itemsList">
      <thead>
        @yield('browse-table-header')
      </thead>

      <tfoot>
        @yield('browse-table-footer')
      </tfoot>

      <tbody>
        @unless(count($this->items))
          @yield('browse-table-body-norecords')
        @else
          @yield('browse-table-body-withrecords')
        @endunless
      </tbody>
    </table>

    {{-- Default hidden form fields --}}
    <div class="cajobboard-hidden-fields-container">
      @section('browse-default-hidden-fields')
        <input type="hidden" name="option" id="option" value="{{{ $this->getContainer()->componentName }}}"/>
        <input type="hidden" name="view" id="view" value="{{{ $this->getName() }}}"/>
        <input type="hidden" name="boxchecked" id="boxchecked" value="0"/>
        <input type="hidden" name="task" id="task" value="{{{ $this->getTask() }}}"/>
        <input type="hidden" name="filter_order" id="filter_order" value="{{{ $this->lists->order }}}"/>
        <input type="hidden" name="filter_order_Dir" id="filter_order_Dir" value="{{{ $this->lists->order_Dir }}}"/>
        <input type="hidden" name="@token()" value="1"/>
      @show

      {{-- Component-specific hidden form fields --}}
      @yield('browse-hidden-fields')
    </div>

  </div>
</form>

{{-- Any content displayed below the pagination footer on admin pages --}}
@yield('browse-page-bottom')
