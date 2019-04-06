<?php
/**
 * Answers Admin Default View Template
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

use Joomla\CMS\HTML\HTMLHelper;
use \Calligraphic\Cajobboard\Site\Model\Answers;
use \Calligraphic\Cajobboard\Admin\Helper\FormatHelper;
use \FOF30\View\DataView\Form;
use \FOF30\Utils\FEFHelper\BrowseView;
use \FOF30\Utils\SelectOptions;

// no direct access
defined('_JEXEC') or die;

// Javascript libraries to include
HTMLHelper::_('behavior.tooltip');
HTMLHelper::_('formbehavior.chosen', 'select');

/**
 * @var  Form       $this
 * @var  Answers    $item
 */

$modelName = strtolower($this->getContainer()->inflector->pluralize($this->getName()));

// The width of each of the table columns as a percentage
$widthPct = array
(
  '#1'  => '1',  // Drag-and-drop icons in record fields for ordering browse records
  '#2'  => '1',  // "select all" checkbox to apply Toolbar actions to all records
  '#3'  => '8',  // Filter on whether records are published, unpublished, or both
  '#4'  => '35', // Answer title
  '#5'  => '10', // Access, e.g. "public"
  '#6'  => '10', // Author name
  '#7'  => '10', // Language
  '#8'  => '10', // Date Created
  '#9'  => '5',  // Hits counter
)
?>

@extends('admin:com_cajobboard/Common/browse')

{{-------------------------------------------------------------------------------------}}
{{-- SECTION: Toolbar shown at top of admin page, with search, filters, and ordering --}}
{{-------------------------------------------------------------------------------------}}

@section('browse-filters')
  <div class="filter-search btn-group pull-left">
    {{-- \FOF30\Utils\FEFHelper\BrowseView::searchFilter --}}
    {{-- @TODO: modal is empty, no drop-down of author list --}}
    @searchfilter('created-by', null, \JText::_('COM_CAJOBBOARD_ANSWERS_FILTER_BY_AUTHOR'))
  </div>

  <div class="filter-search btn-group pull-left">
    {{-- \FOF30\Utils\FEFHelper\BrowseView::publishedFilter --}}
    {{ BrowseView::publishedFilter('enabled', 'JENABLED') }}
  </div>
@stop


{{-------------------------------------------------------------------------------------}}
{{-- SECTION: Table column headers and filters displayed above the data columns -------}}
{{-------------------------------------------------------------------------------------}}

@section('browse-table-header')
    <tr>
      {{-- COLUMN #1: Drag-and-drop icons in record fields for ordering browse records. DB Table must have `ordering` field to support. --}}
      <th width="{{ $widthPct['#1'] }}%" class="nowrap center header-reorder hidden-phone">
        {{-- \FOF30\Utils\FEFHelper\FEFHelperBrowse::orderfield --}}
        @jhtml('FEFHelper.browse.orderfield', 'ordering', 'icon-menu-2')
      </th>

      {{-- COLUMN #2: "select all" checkbox to apply Toolbar actions to all records. --}}
      <th width="{{ $widthPct['#2'] }}%" class="center header-select">
        {{-- \FOF30\Utils\FEFHelper\FEFHelperBrowse::checkall --}}
        @jhtml('FEFHelper.browse.checkall', 'Select')
      </th>

      {{-- COLUMN #3: Filter on whether records are published, unpublished, or both. --}}
      <th width="{{ $widthPct['#3'] }}%" class="center header-published">
        {{-- \FOF30\Utils\FEFHelper\BrowseView::sortGrid --}}
        @sortgrid('enabled', 'JSTATUS')
      </th>

      {{-- COLUMN #4: Answer title, allows sorting ASC / DESC by clicking the field name in the column header. --}}
      <th width="{{ $widthPct['#4'] }}%" class="header-title">
        {{-- \FOF30\Utils\FEFHelper\BrowseView::sortGrid --}}
        @sortgrid('name', 'COM_CAJOBBOARD_ANSWER_NAME')
      </th>

      {{-- COLUMN #5: Access, e.g. "public" --}}
      <th width="{{ $widthPct['#5'] }}%" class="center header-access">
        {{-- \FOF30\Utils\FEFHelper\BrowseView::sortGrid --}}
        @sortgrid('access', 'JFIELD_ACCESS_LABEL')
      </th>

      {{-- COLUMN #6: Author name, allows sorting ASC / DESC by clicking the field name in the column header. --}}
      <th width="{{ $widthPct['#6'] }}%" class="center header-author">
        @sortgrid('created_by', 'COM_CAJOBBOARD_ANSWER_AUTHOR')
      </th>

      {{-- COLUMN #7: Language --}}
      <th width="{{ $widthPct['#7'] }}%" class="center header-language">
        {{-- \FOF30\Utils\FEFHelper\BrowseView::sortGrid --}}
        @sortgrid('language', 'JFIELD_LANGUAGE_LABEL')
      </th>

      {{-- COLUMN #8: Date Created --}}
      <th width="{{ $widthPct['#8'] }}%" class="center header-created">
        {{-- \FOF30\Utils\FEFHelper\BrowseView::sortGrid --}}
        @sortgrid('created_on', 'JGLOBAL_FIELD_CREATED_LABEL')
      </th>

      {{-- COLUMN #9: Hits counter --}}
      <th width="{{ $widthPct['#9'] }}%" class="center header-hits">
        {{-- \FOF30\Utils\FEFHelper\BrowseView::sortGrid --}}
        @sortgrid('hits', 'JGLOBAL_HITS')
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
      {{-- COLUMN #1: Drag-and-drop icon in record field for ordering browse records. --}}
      <td width="{{ $widthPct['#1'] }}%" class="center row-reorder">
        {{-- \FOF30\Utils\FEFHelper\FEFHelperBrowse::order --}}
        @jhtml('FEFHelper.browse.order', 'ordering', $item->ordering, 'sortable-handler tip-top hasTooltip', 'icon-menu', 'icon-menu')
      </td>

      {{-- COLUMN #2: "select" checkbox to apply Toolbar actions to this record. --}}
      <td width="{{ $widthPct['#2'] }}%" class="center row-select">
        {{-- \FOF30\Utils\FEFHelper\FEFHelperBrowse::id --}}
        @jhtml('FEFHelper.browse.id', $i, $item->getId())
      </td>

      {{-- COLUMN #3: Icon (checkmark or "X") to show whether record is in published or unpublished state. --}}
      <td width="{{ $widthPct['#3'] }}%" class="center row-published">
        <div class="btn-group">
          @jhtml('helper.browseWidgets.published', $item->enabled, $i)
          @jhtml('helper.browseWidgets.featured', $item->featured, $i)
          @jhtml('helper.browseWidgets.publishedDropdown', $item->enabled, $item->name, $i)
        </div>
      </td>

      {{-- COLUMN #4: Answer title and category --}}
      <td width="{{ $widthPct['#4'] }}%" class="row-title">
        <div>
          <a href="@route(\FOF30\Utils\FEFHelper\BrowseView::parseFieldTags('index.php?option=com_cajobboard&view=Answers&task=edit&id=[ITEM:ID]', $item))">
            @jhtml('helper.browseWidgets.title', $item->name, $item->text)
          </a>

          @jhtml('helper.browseWidgets.alias', $item->slug)
        </div>

        @jhtml('helper.browseWidgets.category', $item->cat_id)
      </td>

      {{-- COLUMN #5: Access, e.g. 'Published' --}}
      <td width="{{ $widthPct['#5'] }}%" class="center row-access">
        @jhtml('helper.commonWidgets.access', $item->access)
      </td>

      {{-- COLUMN #6: Author name --}}
      <td width="{{ $widthPct['#6'] }}%" class="row-author">
        @if($item->Author instanceof DataModel)
          {{{ $item->Author->name }}}
        @endif
      </td>

      {{-- COLUMN #7: Language --}}
      <td width="{{ $widthPct['#7'] }}%" class="center row-language">
          @jhtml('helper.browseWidgets.language', $item->language)
      </td>

      {{-- COLUMN #8: Date Created --}}
      <td width="{{ $widthPct['#8'] }}%" class="center row-created">
        {{ FormatHelper::date($item->created_on) }}
      </td>

      {{-- COLUMN #9: Hits Counter --}}
      <td width="{{ $widthPct['#9'] }}%" class="center row-hits">
        @jhtml('helper.commonWidgets.hits', $item->hits)
      </td>
    </tr>
  @endforeach
@stop

