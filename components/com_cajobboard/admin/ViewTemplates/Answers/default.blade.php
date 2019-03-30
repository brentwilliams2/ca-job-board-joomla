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
use \FOF30\Utils\FEFHelper\BrowseView;
use \FOF30\Utils\SelectOptions;
use \FOF30\Model\DataModel;

// no direct access
defined('_JEXEC') or die;

// Javascript libraries to include
HTMLHelper::_('behavior.tooltip');
HTMLHelper::_('formbehavior.chosen', 'select');

/**
 * @var \FOF30\View\DataView\Form $this
 * @var  Answers                  $item
 * @var  Answers                  $model
 */
$model = $this->getModel();

 /** @var  FOF30\View\DataView\Html  $this */

$modelName = strtolower($this->getContainer()->inflector->pluralize($this->getName()));

// The width of each of the table columns as a percentage
$widthPct = array
(
  '#1'  => '1',  // Drag-and-drop icons in record fields for ordering browse records
  '#2'  => '1',  // "select all" checkbox to apply Toolbar actions to all records
  '#3'  => '8',  // Filter on whether records are published, unpublished, or both
  '#4'  => '30', // Answer title
  '#5'  => '10', // Access, e.g. "public"
  '#6'  => '10', // Author name
  '#7'  => '10', // Language
  '#8'  => '10', // Date Created
  '#9'  => '5',  // Hits counter
  '#10' => '5',  // Record id number in database (primary key)
)

/* UCM
 * @property int            $answer_id       Surrogate primary key.
 * @property string         $slug            Alias for SEF URL.
 * @property bool           $featured        Whether this answer is featured or not.
 * @property int            $hits            Number of hits this answer has received.
 * @property int            $created_by      Userid of the creator of this answer.
 * @property string         $createdOn       Date this answer was created.
 * @property int            $modifiedBy      Userid of person that last modified this answer.
 * @property string         $modifiedOn      Date this answer was last modified.
 *
 * SCHEMA: Thing
 * @property string         $name            A title to use for the answer.
 * @property string         $description     A description of the answer.
 *
 * SCHEMA: CreativeWork
 * @property QAPage         $isPartOf         This property points to a QAPage entity associated with this answer. FK to #__cajobboard_qapage(qapage_id).
 * @property Organization   $Publisher        The company that wrote this answer. FK to #__organizations(organization)id).
 * @property string         $text             The actual text of the answer itself.
 * @property Person         $Author           The author of this comment.  FK to #__persons.
 *
 * SCHEMA: Answer
 * @property Question       $parentItem       The question this answer is intended for. FK to #__cajobboard_questionss(question_id).
 * @property int            $upvote_count     Upvote count for this item.
 * @property int            $downvote_count   Downvote count for this item.
 */
?>

@extends('admin:com_cajobboard/Common/browse')

{{-------------------------------------------------------------------------------------}}
{{-- SECTION: Toolbar shown at top of admin page, with search, filters, and ordering --}}
{{-------------------------------------------------------------------------------------}}

@section('browse-filters')
  <div class="filter-search btn-group pull-left">
    {{-- \FOF30\Utils\FEFHelper\BrowseView::searchFilter --}}
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

      {{-- COLUMN #10: Record id number in database (primary key) --}}
      <th width="{{ $widthPct['#10'] }}%" class="center header-id">
        {{-- \FOF30\Utils\FEFHelper\BrowseView::sortGrid --}}
        <?php
          // pk field is usually singular model name with '_id' appended, e.g. 'answer_id'
          // but identity field can be overridden with aliases, and user model uses Joomla! 'id'
          $id = 'id';
          if ($this->items)
          {
            // array doesn't have zero-indexed element (Collection of DataModel objects)
            $id = $this->items[1]->getIdFieldName();
          }
        ?>
        @sortgrid($id, 'JGRID_HEADING_ID')
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
          @jhtml('helper.browseWidgets.published', $item->enabled, $modelName, $i)
          @jhtml('helper.browseWidgets.featured', $item->featured, $modelName, $i)
          @jhtml('actionsdropdown.' . ((int) $item->state === 2  ? 'un' : '') . 'archive', 'cb' . $i, 'banners');
          @jhtml('actionsdropdown.' . ((int) $item->state === -2 ? 'un' : '') . 'trash', 'cb' . $i, 'banners');
          @jhtml('actionsdropdown.render', $this->escape($item->name));
        </div>
      </td>


<?php

/*
HTML from the publish/feature combo control (not showing the checkmark icon):

<div class="btn-group">
  <aclass="btn btn-micro="" hastooltip"href="javascript:void(0);" onclick="return listItemTask('cb1', 'answers.publish')" title="Published" data-original-title="Unpublish Item">
    <span class="icon-publish" aria-hidden="true"></span>

    <a href="javascript:void(0)" onclick="return listItemTask('cb1', 'answers.featured')" class="btn btn-micro hasTooltip" title="" data-original-title="Toggle featured status.">
      <span class="icon-unfeatured" aria-hidden="true"></span>
    </a>;;

    <button data-toggle="dropdown" class="dropdown-toggle btn btn-micro">
      <span class="caret"></span>
      <span class="element-invisible">Actions for: Consciousness consists of electromagnetic resonance of quantum energy. “Quantum” means a maturing of the archetypal.</span>
    </button>

    <ul class="dropdown-menu">
      <li>
        <a href="javascript://" onclick="listItemTask('cb1', 'banners.archive')">
          <span class="icon-archive" aria-hidden="true"></span>
          Archive
        </a>
      </li>
      <li>
        <a href="javascript://" onclick="listItemTask('cb1', 'banners.trash')">
          <span class="icon-trash" aria-hidden="true"></span>
          Trash
        </a>
      </li>
    </ul>;
  </aclass="btn>
</div>
*/
?>



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

      {{-- COLUMN #10: Primary key (id number in database) --}}
      <td width="{{ $widthPct['#10'] }}%" class="center row-id">
        {{ $item->getId() }}
      </td>
    </tr>
  @endforeach
@stop

