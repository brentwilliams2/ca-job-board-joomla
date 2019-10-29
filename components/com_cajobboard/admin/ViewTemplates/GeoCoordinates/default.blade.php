<?php
/**
 * Geo Coordinates Admin Default View Template
 *
 * @package   Calligraphic Job Board
 * @version   May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * see /Calligraphic/Cajobboard/Helper/Html/browsewidget.php for Helper widgets
 */

use \FOF30\Utils\FEFHelper\BrowseView;
use \FOF30\Utils\SelectOptions;
use \Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;

/** @var \Calligraphic\Cajobboard\Site\Model\GeoCoordinates   $item */
/** @var  FOF30\View\DataView\Html                            $this */

// The width of each of the table columns as a percentage
$widthPct = array
(
  '#1'  => '1',  // Drag-and-drop icons in record fields for ordering browse records
  '#2'  => '1',  // "select all" checkbox to apply Toolbar actions to all records
  '#3'  => '8',  // Filter on whether records are published, unpublished, or both
  '#4'  => '35', // Geo Coordinate title
  '#5'  => '10', // Access, e.g. "public"
  '#6'  => '10', // Author name
  '#7'  => '10', // Language
  '#8'  => '10', // Date Created
  '#9'  => '5',  // Hits counter
)
?>

@extends('admin:com_cajobboard/Common/browse')

{{-----------------------------------------------------------------------------}}
{{-- SECTION: Filters above the table. ----------------------------------------}}
{{-----------------------------------------------------------------------------}}

@section('browse-filters')
  <span class="pagination-select btn-group pull-right">
    {{ $this->pagination->getLimitBox() }}
  </span>
@stop

{{-------------------------------------------------------------------------------------}}
{{-- SECTION: Table column headers and filters displayed above the data columns -------}}
{{-------------------------------------------------------------------------------------}}

@section('browse-table-header')
  <tr>
    {{-- COLUMN #1: Drag-and-drop icons in record fields for ordering browse records. DB Table must have `ordering` field to support. --}}
    @jhtml('helper.browseWidgets.orderingHeader', $widthPct['#1'])

    {{-- COLUMN #2: "select all" checkbox to apply Toolbar actions to all records. --}}
    @jhtml('helper.browseWidgets.selectAllHeader', $widthPct['#2'])
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
      @jhtml('helper.browseWidgets.orderingField', $widthPct['#1'], $item)

      {{-- COLUMN #2: "select" checkbox to apply Toolbar actions to this record. --}}
      @jhtml('helper.browseWidgets.selectAllField', $widthPct['#2'], $item, $i)
    </tr>
  @endforeach
@stop

