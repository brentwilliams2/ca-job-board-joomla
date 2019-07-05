<?php
 /**
  * Answers Site List View Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  use \Calligraphic\Cajobboard\Site\Helper\Pagination;

  // no direct access
  defined('_JEXEC') or die;

  // Add component JS and CSS in view templates so that they're properly handled if HMVC in use
  $this->container->AssetFiles->addComponentJS($this);
  $this->container->AssetFiles->addComponentJS($this);

  $isPaginated = $this->pagination instanceof Pagination;
?>

@section('header')
  <div class="answers-header">

    <h4>Answers</h4>

    @if ($isPaginated)
      <span class="pagination-select pull-right">
        {{ $this->pagination->getLimitBox() }}
      </span>
    @endif

    <a class="answer-new" href="@route('index.php?option=com_cajobboard&view=answer&task=add')">
      <button type="button" class="btn btn-primary btn-sm btn-answer add-answer-button pull-right">
        @lang('JTOOLBAR_NEW')
      </button>
    </a>

    <div class="clearfix"></div>
  </div>
@show

@section('item')
  <div class="container-fluid answers-list">
    @each('site:com_cajobboard/Answers/default_item', $this->items, 'item', 'text|COM_CAJOBBOARD_ANSWERS_NO_ANSWERS_FOUND')
  </div>
  <div class="clearfix"></div>
@show

@section('footer')
  @if ($isPaginated)
    <div class="answers-footer">
      <?php $options = array();
        /*
        * @TODO: Any options to pass?
        *        showPagesLinks - whether pagination links should appear on page
        *        showLimitStart - the hidden input box with 'limitstart' name and value
        */
      ?>
      {{ $this->pagination->getPaginationLinks('joomla.pagination.links', $options) }}
    </div>
  @endif
@show

