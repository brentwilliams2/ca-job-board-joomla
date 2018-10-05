<?php
 /**
  * Common Edit View Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  * Use by extending:
  *
  * @extends('site:com_cajobboard/ViewTemplateHelpers/edit')
  *
  * Override the following sections in the Blade form template:
  *
  * edit-page-top
  *      Content to put above the form
  *
  * edit-page-bottom
  *      Content to put below the form
  *
  * edit-form-body
  *      The page's body, inside the form
  *
  * edit-hidden-fields
  *      [ Optional ] Any additional hidden INPUTs to add to the form. By default this is empty.
  *      The default hidden fields (option, view, task, ordering fields, boxchecked and token) can
  *      not be removed.
  *
  * Do not override any other section
  */

  // no direct access
  defined('_JEXEC') or die;
?>

@section('edit-form-body')
  {{-- Put form body in this section --}}
@stop

@section('edit-hidden-fields')
  {{-- Put additional hidden fields in this section --}}
@stop

@yield('edit-page-top')

{{-- Edit form --}}
<form action="index.php" method="post" name="siteForm" id="siteForm" class="cajobboard-form">
  {{-- Main form body --}}
  @yield('edit-form-body')

  {{-- Hidden form fields --}}
  <div class="akeeba-hidden-fields-container">
    @section('browse-default-hidden-fields')
      <input type="hidden" name="option"  id="option" value="{{{ $this->getContainer()->componentName }}}"/>
      <input type="hidden" name="view"    id="view"   value="{{{ $this->getName() }}}"/>
      <input type="hidden" name="task"    id="task"   value="{{{ $this->getTask() }}}"/>
      <input type="hidden" name="id"      id="id"     value="{{{ $this->getItem()->getId() }}}"/>
      {{-- <input type="hidden" name="@token()" value="1"/> --}}
    @show

    @yield('edit-hidden-fields')
  </div>
</form>

@yield('edit-page-bottom')
