<?php
/**
 * Admin Publish Tab Common View Template
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Intended for use on the "Publish" tab of back-end item edit forms
 *
 *  Usage:
 *
 *   @include('admin:com_cajobboard/Common/PublishTab', [ 'item' => $item ])
 */

  // no direct access
  defined('_JEXEC') or die;

  $robot_value = $item->metadata->get('robots');

  // Options for robots metadata tag
  $robot_values = array(
    'JGLOBAL_USE_GLOBAL' => '',
    'JGLOBAL_INDEX_FOLLOW' => 'index, follow',
    'JGLOBAL_NOINDEX_FOLLOW' => 'noindex, follow',
    'JGLOBAL_INDEX_NOFOLLOW' => 'index, nofollow',
    'JGLOBAL_NOINDEX_NOFOLLOW' => 'noindex, nofollow',
  );
?>

{{-----------------------------------------------------------------------------------}}
{{-- SECTION: "Publishing" pane of Publishing" options tab in admin item view edit --}}
{{-----------------------------------------------------------------------------------}}

@section('publishing-data')

  <fieldset name="created_date">
    <label for="created_date">
      @lang('JGLOBAL_FIELD_CREATED_DESC')
    </label>
    @jhtml('calendar', $item->created_on, 'created_on', 'created_on', '%Y-%m-%d %H:%M:%S')
  </fieldset>

  <fieldset name="created_by">
    <label for="created_by">
      @lang('JGLOBAL_FIELD_CREATED_BY_LABEL')
    </label>
    @include('admin:com_cajobboard/Common/UserSelect', ['userID' => $item->created_by, 'name' => 'created_by', 'item' => $item, 'required' => true])
  </fieldset>

  <fieldset name="modified_date">
    <label for="modified_date">
      @lang('JGLOBAL_FIELD_MODIFIED_LABEL')
    </label>
    @jhtml('calendar', $item->modified_on, 'modified_on', 'modified_on', '%Y-%m-%d %H:%M:%S')
  </fieldset>

  <fieldset name="modified_by">
    <label for="modified_by">
      @lang('JGLOBAL_FIELD_MODIFIED_BY_LABEL')
    </label>
    @include('admin:com_cajobboard/Common/UserSelect', ['userID' => $item->modified_by, 'name' => 'modified_by', 'item' => $item, 'required' => true])
  </fieldset>

  <fieldset name="hits">
    <label for="hits">
      @lang('JGLOBAL_HITS')
    </label>
    <input type="number" name="hits" id="hits" value="{{{ $item->hits }}}" class="" size="15" step="1" min="0" aria-invalid="false">
  </fieldset>
@stop


{{----------------------------------------------------------------------------------}}
{{-- SECTION: "Metadata" pane of "Publishing" options tab in admin item view edit --}}
{{----------------------------------------------------------------------------------}}

@section('metadata')
  {{-- Metadata Description field --}}
  <fieldset name="meta_description">
    <label for="metadesc">
      @lang('JFIELD_META_DESCRIPTION_LABEL')
    </label>
    <textarea name="metadesc" id="metadesc" cols="40" rows="3" aria-invalid="false">{{ $item->metadesc }}</textarea>
  </fieldset>

  {{-- Metadata Keywords field --}}
  <fieldset name="meta_keywords">
    <label for="metakey">
      @lang('JFIELD_META_KEYWORDS_LABEL')
    </label>
    <textarea name="metakey" id="metakey" cols="40" rows="3" aria-invalid="false">{{ $item->metakey }}</textarea>
  </fieldset>

  {{-- Metadata Author field --}}
  <fieldset name="author">
    <label for="metadata_author">
      @lang('JAUTHOR')
    </label>
    <input type="text" name="metadata_author" id="metadata_author" value="{{{ $item->metadata->get('author') }}}"/>
  </fieldset>

  {{-- Metadata Robots field --}}
  <fieldset name="robots">
    <label for="metadata_robots">
      @lang('JFIELD_METADATA_ROBOTS_LABEL')
    </label>
    <select id="metadata_robots" name="metadata_robots" style="display: none;">
      @foreach ($robot_values as $translation_string => $value)
        <option value={{{ $value }}}
          @if($value === $robot_value)
            selected
          @endif
        >
          @lang($translation_string)
        </option>
      @endforeach
    </select>
  </fieldset>
@stop


{{-----------------------------------------------------------------------------}}

<div class="row-fluid form-horizontal-desktop">
  <div class="span6">
    @yield('publishing-data')
  </div>

  <div class="span6">
    @yield('metadata')
  </div>
</div>
