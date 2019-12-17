<?php
/**
 * Organization Roles Admin Default View Template
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

/** @var \Calligraphic\Cajobboard\Site\Model\OrganizationRoles  $item */
/** @var  FOF30\View\DataView\Html                              $this */

// The width of each of the table columns as a percentage
$widthPct = array
(
  '#1'  => '1',  // "select all" checkbox to apply Toolbar actions to all records
  '#2'  => '35', // OrganizationType title
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

    {{-- COLUMN #2: Organization Role title, allows sorting ASC / DESC by clicking the field name in the column header. --}}
    @jhtml('helper.browseWidgets.titleHeader', $widthPct['#2'], $this->getName() )
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

      {{-- COLUMN #2: Organization Role title and category --}}
      @jhtml('helper.browseWidgets.titleField', $widthPct['#2'], $item)
    </tr>
  @endforeach
@stop

