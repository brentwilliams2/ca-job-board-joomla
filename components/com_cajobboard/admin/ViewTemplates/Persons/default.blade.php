<?php
/**
 * Persons Admin Default View Template
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Language\Text;
use \Calligraphic\Cajobboard\Site\Model\Persons;
use \FOF30\View\DataView\Form;
use \FOF30\Utils\FEFHelper\BrowseView;
use \FOF30\Utils\SelectOptions;

// no direct access
defined('_JEXEC') or die;

// Javascript libraries to include
HTMLHelper::_('behavior.tooltip');
HTMLHelper::_('formbehavior.chosen', 'select');

// Add component JS and CSS in view templates so that they're properly handled if HMVC in use
$this->container->AssetFiles->addComponentCss($this);
$this->container->AssetFiles->addViewJavascript($this);

/**
 * @var  Form       $this
 * @var  Persons    $item
 */

// The width of each of the table columns as a percentage
$widthPct = array
(
  '#1'  => '2',  // "select all" checkbox to apply Toolbar actions to all records
  '#2'  => '8',  // Filter on whether user is activated
  '#3'  => '8',  // Filter on whether user is blocked
  '#4'  => '25', // User's real name
  '#5'  => '25', // User's username
  '#6'  => '16', // Registration date
  '#7'  => '16', // Last Visit date
)
?>

@extends('admin:com_cajobboard/Common/browse')

{{-------------------------------------------------------------------------------------}}
{{-- SECTION: Toolbar shown at top of admin page, with search, filters, and ordering --}}
{{-------------------------------------------------------------------------------------}}

@section('browse-filters')
  <span class="filter-search btn-group pull-left">
    {{-- \FOF30\Utils\FEFHelper\BrowseView::searchFilter --}}
    {{-- @TODO: modal is empty, no drop-down of author list: need to write helper to do join and get author names --}}
    @searchfilter('username', null, Text::_('COM_CAJOBBOARD_PERSONS_FILTER_BY_USERNAME'))
  </span>

  {{-- @TODO: Expand search options --}}

  {{-- @TODO: Clear filters --}}

  {{-- @TODO: Choose sort order (lists different options - by date, name, etc.) --}}

  {{-- @TODO: Number of results to show per page --}}

  <span class="filter-search btn-group pull-left">
    {{ BrowseView::publishedFilter('enabled', 'JSTATUS') }}
  </span>

  <span class="filter-search btn-group pull-left">
    {{ BrowseView::accessFilter('access', 'JFIELD_ACCESS_LABEL') }}
  </span>

  <span class="pagination-select btn-group pull-right">
    {{ $this->pagination->getLimitBox() }}
  </span>

  {{-- @TODO: Filter by category --}}

  {{-- @TODO: Filter by language, need to helper to handle '*'  --}}

  {{-- @TODO: Filter by  tags --}}
@stop


{{-------------------------------------------------------------------------------------}}
{{-- SECTION: Table column headers and filters displayed above the data columns -------}}
{{-------------------------------------------------------------------------------------}}

@section('browse-table-header')
  <tr>
    {{-- COLUMN #1: "select all" checkbox to apply Toolbar actions to all records. --}}
    <th width="{{ $widthPct['#1'] }}%" class="center header-select">
      {{-- \FOF30\Utils\FEFHelper\FEFHelperBrowse::checkall --}}
      @jhtml('FEFHelper.browse.checkall', 'Select')
    </th>

    {{-- COLUMN #2: Filter on whether user is activated. --}}
    <th width="{{ $widthPct['#2'] }}%" class="center header-activated">
      {{-- \FOF30\Utils\FEFHelper\BrowseView::sortGrid --}}
      @sortgrid('activation', 'COM_CAJOBBOARD_PERSON_ACTIVATED')
    </th>

    {{-- COLUMN #3: Filter on whether user is blocked. --}}
    <th width="{{ $widthPct['#3'] }}%" class="center header-blocked">
      {{-- \FOF30\Utils\FEFHelper\BrowseView::sortGrid --}}
      @sortgrid('blocked', 'COM_CAJOBBOARD_PERSON_BLOCKED')
    </th>

    {{-- COLUMN #4: User name, allows sorting ASC / DESC by clicking the field name in the column header. --}}
    <th width="{{ $widthPct['#4'] }}%" class="header-name">
      {{-- \FOF30\Utils\FEFHelper\BrowseView::sortGrid --}}
      @sortgrid('name', 'COM_CAJOBBOARD_PERSON_SYSTEM_NAME')
    </th>

    {{-- COLUMN #5: System username, allows sorting ASC / DESC by clicking the field name in the column header. --}}
    <th width="{{ $widthPct['#5'] }}%" class="header-username">
      {{-- \FOF30\Utils\FEFHelper\BrowseView::sortGrid --}}
      @sortgrid('usernamename', 'JGLOBAL_USERNAME')
    </th>

    {{-- COLUMN #6: Date Registered --}}
    <th width="{{ $widthPct['#6'] }}%" class="center header-registered">
      {{-- \FOF30\Utils\FEFHelper\BrowseView::sortGrid --}}
      @sortgrid('registerDate', 'COM_CAJOBBOARD_PERSON_REGISTERED_DATE_LABEL')
    </th>

    {{-- COLUMN #7: Last visit date --}}
    <th width="{{ $widthPct['#7'] }}%" class="center header-last-visit-date">
      {{-- \FOF30\Utils\FEFHelper\BrowseView::sortGrid --}}
      @sortgrid('lastvisitDate', 'COM_CAJOBBOARD_PERSON_LAST_VISIT_DATE_LABEL')
    </th>
  </tr>
@stop



{{-------------------------------------------------------------------------------------}}
{{-- SECTION: Table body shown when records are present -------------------------------}}
{{-------------------------------------------------------------------------------------}}

@section('browse-table-body-withrecords')
    {{-- Table body shown when records are present. --}}
  <?php $i = 0; ?>

  @foreach($this->items as $item)
    <?php ++$i; ?>
    <tr>
      {{-- COLUMN #1: "select" checkbox to apply Toolbar actions to this record. --}}
      <td width="{{ $widthPct['#1'] }}%" class="center row-select">
        {{-- \FOF30\Utils\FEFHelper\FEFHelperBrowse::id --}}
        @jhtml('FEFHelper.browse.id', $i, $item->getId())
      </td>

      {{-- COLUMN #2: Icon (checkmark or "X") to show whether the user is activated or not. --}}
      <td width="{{ $widthPct['#2'] }}%" class="center row-activated">
        <div class="btn-group">
          @jhtml('helper.browseWidgets.activated', $item->activation, $i)
        </div>
      </td>

      {{-- COLUMN #3: Icon (checkmark or "X") to show whether the user is blocked or not. --}}
      <td width="{{ $widthPct['#3'] }}%" class="center row-blocked">
        <div class="btn-group">
          @jhtml('helper.browseWidgets.blocked', $item->block, $i)
        </div>
      </td>

      {{-- COLUMN #4: Full name of the user --}}
      <td width="{{ $widthPct['#4'] }}%" class="row-name">
        <div>
          <a href="@route(\FOF30\Utils\FEFHelper\BrowseView::parseFieldTags('index.php?option=com_cajobboard&view=Persons&task=edit&id=[ITEM:ID]', $item))">
            @jhtml('helper.browseWidgets.title', $item->name, $item->text)
          </a>
        </div>
      </td>

      {{-- COLUMN #5: User's username --}}
      <td width="{{ $widthPct['#5'] }}%" class="row-username">
        <div>
          <a href="@route(\FOF30\Utils\FEFHelper\BrowseView::parseFieldTags('index.php?option=com_cajobboard&view=Persons&task=edit&id=[ITEM:ID]', $item))">
            @jhtml('helper.browseWidgets.title', $item->username, $item->text)
          </a>
        </div>
      </td>

      {{-- COLUMN #6: Date Registered --}}
      <td width="{{ $widthPct['#6'] }}%" class="center row-registered">
        {{ $this->container->Format->date($item->registerDate) }}
      </td>

      {{-- COLUMN #7: Last Visit Date --}}
      <td width="{{ $widthPct['#7'] }}%" class="center row-last-visit-date">
        {{ $this->container->Format->date($item->lastvisitDate) }}
      </td>
    </tr>
  @endforeach
@stop

