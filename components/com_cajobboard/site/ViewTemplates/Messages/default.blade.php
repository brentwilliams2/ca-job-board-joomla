<?php
 /**
  * Comments Site List View Template
  *
  * @package   Calligraphic Job Board
  * @version   September 12, 2019
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2019 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  */

  // no direct access
  defined('_JEXEC') or die;

  use \Joomla\CMS\Language\Text;

  /** @var  FOF30\View\DataView\Html                    $this */

  // Using an include so that local vars in the included file are in scope here also
  include(JPATH_COMPONENT . '/ViewTemplates/Common/common_local_vars.blade.php');

  // The name of the crud view
  $crud = 'browse';

  $noItemsFoundMssg = Text::sprintf('COM_CAJOBBOARD_NO_ITEMS_FOUND', $humanViewNamePlural);
?>

@include('site:com_cajobboard/Common/Modal/report_item_modal')

@section('header')
  <div class="well @jhtml('helper.commonwidgets.getAttributeClass', 'header', $prefix, $crud)">
    <span class="h4 pull-left">@lang('COM_CAJOBBOARD_' . $transKey . '_PAGE_TITLE')</span>

    @if ($this->paginationHelper->shouldDisplayLimitBox())
      <span class="pagination-select pull-right">
        @include('site:com_cajobboard/Common/pagination_results_limit')
      </span>
    @endif

    @if ($canUserAdd)
      @jhtml('helper.buttonwidgets.addNew', $this, $prefix, $crud)
    @endif

    <div class="clearfix"></div>
  </div>
@show

@section('item')
  <div class="container-fluid @jhtml('helper.commonwidgets.getAttributeClass', 'list', $prefix, $crud)">
    @each('site:com_cajobboard/' . $viewName . '/default_item', $this->items, 'item', 'text|' . $noItemsFoundMssg)
  </div>
  <div class="clearfix"></div>
@show

@section('footer')
  @if ($this->paginationHelper->shouldDisplayLimitBox())
    <div class="@jhtml('helper.commonwidgets.getAttributeClass', 'footer', $prefix, $crud)">
      {{ $this->pagination->getPaginationLinks('joomla.pagination.links') }}
    </div>
  @endif
@show


{{--
  Modal templates used in common for all default_item views, only
  take bandwidth hit of including modal HTML if user is logged in
--}}
@if (!$isGuestUser)
  @yield('report-item-modal')
@endif
