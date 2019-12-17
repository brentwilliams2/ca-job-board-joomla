<?php
/**
 * Image Objects Admin Default View Template
 *
 * @package   Calligraphic Job Board
 * @version   October 31, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * see /Calligraphic/Cajobboard/Helper/Html/browsewidget.php for Helper widgets
 */

use \FOF30\Utils\FEFHelper\BrowseView;
use \FOF30\Utils\SelectOptions;

// no direct access
defined('_JEXEC') or die;

/** @var \Calligraphic\Cajobboard\Site\Model\ImageObjects   $item */
/** @var  FOF30\View\DataView\Html                          $this */

// The width of each of the table columns as a percentage
$widthPct = array
(
  '#1'  => '1',  // Drag-and-drop icons in record fields for ordering browse records
  '#2'  => '1',  // "select all" checkbox to apply Toolbar actions to all records
  '#3'  => '8',  // Filter on whether records are published, unpublished, or both
  '#4'  => '35', // ImageObjects title
  '#5'  => '10', // Access, e.g. "public"
  '#6'  => '10', // Author name
  '#7'  => '10', // Language
  '#8'  => '10', // Date Created
  '#9'  => '5',  // Hits counter
)
?>

@extends('admin:com_cajobboard/Common/browse')

{{-------------------------------------------------------------------------------------}}
{{-- SECTION: Table column headers and filters displayed above the data columns -------}}
{{-------------------------------------------------------------------------------------}}

@section('browse-table-header')
  <tr>
    {{-- COLUMN #1: Drag-and-drop icons in record fields for ordering browse records. DB Table must have `ordering` field to support. --}}
    @jhtml('helper.browseWidgets.orderingHeader', $widthPct['#1'])

    {{-- COLUMN #2: "select all" checkbox to apply Toolbar actions to all records. --}}
    @jhtml('helper.browseWidgets.selectAllHeader', $widthPct['#2'])

    {{-- COLUMN #3: Filter on whether records are published, unpublished, or both. --}}
    @jhtml('helper.browseWidgets.publishedHeader', $widthPct['#3'])

    {{-- COLUMN #4: Image Object title, allows sorting ASC / DESC by clicking the field name in the column header. --}}
    @jhtml('helper.browseWidgets.titleHeader', $widthPct['#4'], $this->getName() )

    {{-- COLUMN #5: Access, e.g. "public" --}}
    @jhtml('helper.browseWidgets.accessHeader', $widthPct['#5'])

    {{-- COLUMN #6: Author name, allows sorting ASC / DESC by clicking the field name in the column header. --}}
    @jhtml('helper.browseWidgets.authorNameHeader', $widthPct['#6'])

    {{-- COLUMN #7: Language --}}
    @jhtml('helper.browseWidgets.languageHeader', $widthPct['#7'])

    {{-- COLUMN #8: Date Created --}}
    @jhtml('helper.browseWidgets.createdOnHeader', $widthPct['#8'])

    {{-- COLUMN #9: Hits counter --}}
     @jhtml('helper.browseWidgets.hitsHeader', $widthPct['#9'])
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

      {{-- COLUMN #3: Icon (checkmark or "X") to show whether record is in published or unpublished state. --}}
      @jhtml('helper.browseWidgets.publishedField', $widthPct['#3'], $item, $i)

      {{-- COLUMN #4: Image Object title and category --}}
      @jhtml('helper.browseWidgets.titleField', $widthPct['#4'], $item)

      {{-- COLUMN #5: Access, e.g. 'Published' --}}
      @jhtml('helper.browseWidgets.accessField', $widthPct['#5'], $item)

      {{-- COLUMN #6: Author name --}}
      @jhtml('helper.browseWidgets.authorNameField', $widthPct['#6'], $item)

      {{-- COLUMN #7: Language --}}
      @jhtml('helper.browseWidgets.languageField', $widthPct['#7'], $item)

      {{-- COLUMN #8: Date Created --}}
      @jhtml('helper.browseWidgets.createdOnField', $widthPct['#8'], $item)

      {{-- COLUMN #9: Hits Counter --}}
      @jhtml('helper.browseWidgets.hitsField', $widthPct['#9'], $item)
    </tr>
  @endforeach
@stop

