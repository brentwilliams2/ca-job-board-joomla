<?php
/**
 * Issue Report Categories Admin Default View Template
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

/** @var \Calligraphic\Cajobboard\Site\Model\IssueReportCategoriss   $item */
/** @var  FOF30\View\DataView\Html                                   $this */

// The width of each of the table columns as a percentage
$widthPct = array
(
  '#1'  => '1',  // "select all" checkbox to apply Toolbar actions to all records
  '#2'  => '40',  // Category
  '#3'  => '40',  // URL
)
?>

@extends('admin:com_cajobboard/Common/browse')

{{-------------------------------------------------------------------------------------}}
{{-- SECTION: Table column headers and filters displayed above the data columns -------}}
{{-------------------------------------------------------------------------------------}}

@section('browse-table-header')
  <tr>
    {{-- COLUMN #1: "select all" checkbox to apply Toolbar actions to all records. --}}
    @jhtml('helper.browseWidgets.selectAllHeader', $widthPct['#1'])

    {{-- COLUMN #2:  --}}
    @jhtml('helper.browseWidgets.bespokeCategoryHeader', $widthPct['#2'])

    {{-- COLUMN #3:  --}}
    @jhtml('helper.browseWidgets.urlHeader', $widthPct['#3'], $this->getName() )
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
      @jhtml('helper.browseWidgets.selectAllField', $widthPct['#1'], $item, $i)

      {{-- COLUMN #2:  --}}
      @jhtml('helper.browseWidgets.bespokeCategoryField', $widthPct['#2'], $item, $i)

      {{-- COLUMN #3:  --}}
      @jhtml('helper.browseWidgets.urlField', $widthPct['#3'], $item, $i)
    </tr>
  @endforeach
@stop

