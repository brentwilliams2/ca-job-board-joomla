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

  // no direct access
  defined('_JEXEC') or die;
?>

@section('header')
  <div class="answers-header">

    <h4>Answers</h4>

    <span class="pagination-select btn btn-primary btn-xs btn-answer btn-group pull-right">
      {{ $this->pagination->getLimitBox() }}
    </span>

    <a class="answer-new" href="@route('index.php?option=com_cajobboard&view=answer&task=add')">
      <button type="button" class="btn btn-primary btn-xs btn-answer add-answer-button pull-right">
        @lang('JTOOLBAR_NEW')
      </button>
    </a>

  </div>
  <div class="clearfix"></div>
@show

@section('item')
  <div class="container-fluid answers-list">
    @each('site:com_cajobboard/Answers/default_item', $this->items, 'item', 'text|COM_CAJOBBOARD_ANSWERS_NO_ANSWERS_FOUND')
  </div>
@show

@section('footer')
  <tr>
    <td colspan="99" class="center">
        {{ $this->pagination->getListFooter() }}
    </td>
  </tr>
@show

<?php /*

Limit Box:

<span class="pagination-select btn-group pull-right">
  <select id="limit" name="limit" class="inputbox input-mini" size="1" onchange="this.form.submit()">
    <option value="5">5</option>
    <option value="10">10</option>
    <option value="15">15</option>
    <option value="20" selected="selected">20</option>
    <option value="25">25</option>
    <option value="30">30</option>
    <option value="50">50</option>
    <option value="100">100</option>
    <option value="0">All</option>
  </select>
</span>

List Footer:

<div class="pagination pagination-toolbar clearfix">
  <nav role="navigation" aria-label="Pagination">
    <ul class="pagination-list">

        <li class="disabled">
          <span><span class="icon-backward icon-first" aria-hidden="true"></span></span>
        </li>

        <li class="disabled">
          <span><span class="icon-step-backward icon-previous" aria-hidden="true"></span>	</span>
        </li>

        <li class="active">
        <span aria-current="true" aria-label="Page 1">1</span>
        </li>

        <li class="hidden-phone">
          <a aria-label="Go to page 2" href="#" onclick="document.adminForm.limitstart.value=5; Joomla.submitform();return false;">2</a>
        </li>

        <li>
          <a aria-label="Go to next page" class="hasTooltip" title="" href="#" onclick="document.adminForm.limitstart.value=5; Joomla.submitform();return false;" data-original-title="Next">
            <span class="icon-step-forward icon-next" aria-hidden="true"></span>
          </a>
        </li>

        <li>
          <a aria-label="Go to end page" class="hasTooltip" title="" href="#" onclick="document.adminForm.limitstart.value=5; Joomla.submitform();return false;" data-original-title="End (Page 2 of 2)">
            <span class="icon-forward icon-last" aria-hidden="true"></span>
          </a>
        </li>

    </ul>
  </nav>
  <input type="hidden" name="limitstart" value="0">
</div>
*/ ?>
