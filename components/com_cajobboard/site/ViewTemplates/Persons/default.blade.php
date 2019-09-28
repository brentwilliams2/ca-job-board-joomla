<?php
 /**
  * Persons Site List View Template
  *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // no direct access
  defined('_JEXEC') or die;

  // Add component JS and CSS in view templates so that they're properly handled if HMVC in use
  $this->container->AssetFiles->addComponentCss($this);
  $this->container->AssetFiles->addViewJavascript($this);
?>

@section('header')
  <div class="persons-header">

    <h4>@lang('PEOPLE')</h4>

    @if ($this->showLimitBox)
      <span class="pagination-select pull-right">
        @include('site:com_cajobboard/Common/PaginationSelectResultsLimit')
      </span>
    @endif

    <a class="person-new" href="@route('index.php?option=com_cajobboard&view=Persons&task=add')">
      <button type="button" class="btn btn-primary btn-sm btn-person add-person-button pull-right">
        @lang('JTOOLBAR_NEW')
      </button>
    </a>

    <div class="clearfix"></div>
  </div>
@show

@section('item')
  <div class="container-fluid persons-list">
    @each('site:com_cajobboard/Persons/default_item', $this->items, 'item', 'text|COM_CAJOBBOARD_PERSONS_NO_PERSONS_FOUND')
  </div>
  <div class="clearfix"></div>
@show

@section('footer')
  <div class="persons-footer">
    {{ $this->pagination->getPaginationLinks('joomla.pagination.links') }}
  </div>
@show
