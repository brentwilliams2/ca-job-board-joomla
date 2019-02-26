<?php
/**
 * Admin Answers Default View Template
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

use Joomla\CMS\HTML\HTMLHelper;

use Calligraphic\Cajobboard\Site\Model\Answers;
use Calligraphic\Cajobboard\Admin\Helper\Format;

use FOF30\Utils\FEFHelper\BrowseView;
use FOF30\Utils\SelectOptions;

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
    @searchfilter('created-by', null, JText::_('COM_CAJOBBOARD_ANSWERS_FILTER_BY_AUTHOR'))
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
      <th width="1%" class="nowrap center hidden-phone">
        {{-- \FOF30\Utils\FEFHelper\FEFHelperBrowse::orderfield --}}
        @jhtml('FEFHelper.browse.orderfield', 'ordering', 'icon-menu-2')
      </th>

      {{-- COLUMN #2: "select all" checkbox to apply Toolbar actions to all records. --}}
      <th width="1%" class="center">
        {{-- \FOF30\Utils\FEFHelper\FEFHelperBrowse::checkall --}}
        @jhtml('FEFHelper.browse.checkall', 'Select')
      </th>

      {{-- COLUMN #3: Filter on whether records are published, unpublished, or both. --}}
      <th width="8%">
        {{-- \FOF30\Utils\FEFHelper\BrowseView::sortGrid --}}
        @sortgrid('enabled', 'JSTATUS')
      </th>

      {{-- COLUMN #4: Author name, allows sorting ASC / DESC by clicking the field name in the column header. --}}
      <th width="15%">
        @sortgrid('created_by', 'COM_CAJOBBOARD_ANSWER_AUTHOR')
      </th>

      {{-- COLUMN #5: Comment text, allows sorting ASC / DESC by clicking the field name in the column header. --}}
      <th>
        {{-- \FOF30\Utils\FEFHelper\BrowseView::sortGrid --}}
        @lang('COM_CAJOBBOARD_ANSWER_TEXT')
      </th>

      {{-- COLUMN #6: Publish Up date, allows sorting ASC / DESC by clicking the field name in the column header. --}}
      <th width="15%">
        {{-- \FOF30\Utils\FEFHelper\BrowseView::sortGrid --}}
        @sortgrid('publish_up', 'COM_CAJOBBOARD_ANSWERS_FILTER_BY_PUBLISH_UP_DATE')
      </th>

      {{-- COLUMN #7: Publish Down date, allows sorting ASC / DESC by clicking the field name in the column header. --}}
      <th width="15%">
        {{-- \FOF30\Utils\FEFHelper\BrowseView::sortGrid --}}
        @sortgrid('publish_down', 'COM_CAJOBBOARD_ANSWERS_FILTER_BY_PUBLISH_DOWN_DATE')
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
    <?php
      $canChange  = true; // @TODO: do authentication like $user->authorise('core.edit.state', 'com_banners.category.' . $item->catid) && $canCheckin;
    ?>

    <tr>
      {{-- COLUMN #1: Drag-and-drop icon in record field for ordering browse records. --}}
      <td>
        {{-- \FOF30\Utils\FEFHelper\FEFHelperBrowse::order --}}
        @jhtml('FEFHelper.browse.order', 'ordering', $item->ordering, 'sortable-handler tip-top hasTooltip', 'icon-menu', 'icon-menu')
      </td>

      {{-- COLUMN #2: "select" checkbox to apply Toolbar actions to this record. --}}
      <td>
        {{-- \FOF30\Utils\FEFHelper\FEFHelperBrowse::id --}}
        @jhtml('FEFHelper.browse.id', ++$i, $item->getId())
      </td>

      {{-- COLUMN #3: Icon (checkmark or "X") to show whether record is in published or unpublished state. --}}
      <td class="center">
        <div class="btn-group">
          {{-- \Helper\HelperBrowseWidgets::published($value, $i, $prefix = '') --}}
          @jhtml('helper.browseWidgets.published', $item->enabled, $i, 'answers.')

          <?php if ($canChange): // Create dropdown items and render the dropdown list ?>
            @jhtml('actionsdropdown.' . ((int) $item->state === 2  ? 'un' : '') . 'archive', 'cb' . $i, 'banners');
            @jhtml('actionsdropdown.' . ((int) $item->state === -2 ? 'un' : '') . 'trash', 'cb' . $i, 'banners');
            @jhtml('actionsdropdown.render', $this->escape($item->name));
          <?php endif; ?>
        </div>
      </td>

      {{-- COLUMN #4: Author name --}}
      <td>
        @TODO: Author Name
        {{-- $item->Author->name --}}
      </td>

      {{-- COLUMN #5: Comment text --}}
      <td>
        <a href="@route(\FOF30\Utils\FEFHelper\BrowseView::parseFieldTags('index.php?option=com_cajobboard&view=Answers&task=edit&id=[ITEM:ID]', $item))">
          {{{ $item->text }}}
        </a>
      </td>

      {{-- COLUMN #6: Publish Up date --}}
      <td>
        {{ Format::date($item->publish_up) }}
      </td>

      {{-- COLUMN #7: Publish Down date --}}
      <td>
        {{ Format::date($item->publish_down) }}
      </td>

    </tr>
  @endforeach
@stop
