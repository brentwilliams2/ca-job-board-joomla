<?php
/**
 * Persons Admin Edit View Template
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

  use \FOF30\Utils\FEFHelper\BrowseView;

  // no direct access
  defined('_JEXEC') or die;

  // Add component JS and CSS in view templates so that they're properly handled if HMVC in use
  $this->container->AssetFiles->addComponentCss($this);
  $this->container->AssetFiles->addViewJavascript($this);

  /** @var \Calligraphic\Cajobboard\Admin\Model\Persons $item */
  $item = $this->getItem();
?>

@extends('admin:com_cajobboard/Common/edit')

{{-----------------------------------------------------------------------------}}
{{-- SECTION: Default edit form tab in this section ---------------------------}}
{{-----------------------------------------------------------------------------}}


'name'
'username'
'email'
'registerDate'
'lastvisitDate'
'activation'
'block'
'params'

@section('basic-options')
  <fieldset name="text" class="control-group">
      <div class="control-label">
        <label
          for="text"
          class="hasTip"
          title="@lang('COM_CAJOBBOARD_ANSWERS_TEXT_FIELD_TOOLTIP_TITLE')::@lang('COM_CAJOBBOARD_ANSWERS_TEXT_FIELD_TOOLTIP_TEXT')"
        >
          @lang('COM_CAJOBBOARD_ANSWERS_TEXT_FIELD_LABEL')
        </label>
      </div>
      <div class="controls">
        @jhtml('FEFHelper.edit.editor', 'text', $item->text)
      </div>
  </fieldset>
@stop


{{-----------------------------------------------------------------------------}}
{{-- SECTION: Advanced options form tab in this section -----------------------}}
{{-----------------------------------------------------------------------------}}

@section('advanced-options')
  {{-- Answer Description textbox --}}
  <fieldset
    name="description"
    class="control-group hasTip"
    title="@lang('COM_CAJOBBOARD_ANSWERS_DESCRIPTION_FIELD_TOOLTIP_TITLE')::@lang('COM_CAJOBBOARD_ANSWERS_DESCRIPTION_FIELD_TOOLTIP_TEXT')"
  >
    <div class="control-label">
      <label for="description">
        @lang('COM_CAJOBBOARD_ANSWERS_DESCRIPTION_FIELD_LABEL')
      </label>
    </div>
    <div class="controls">
      <textarea name="description" id="description" rows="5">{{ $item->description }}</textarea>
    </div>
  </fieldset>

  {{-- Answer Upvote count input box --}}
  <fieldset
    name="upvote_count"
    class="control-group hasTip"
    title="@lang('COM_CAJOBBOARD_ANSWERS_UPVOTE_COUNT_FIELD_TOOLTIP_TITLE')::@lang('COM_CAJOBBOARD_ANSWERS_UPVOTE_COUNT_FIELD_TOOLTIP_TEXT')"
  >
    <div class="control-label">
      <label for="upvote_count">
        @lang('COM_CAJOBBOARD_ANSWERS_UPVOTES_BUTTON_LABEL')
      </label>
    </div>
    <div class="controls">
      <input type="number" step="1" name="upvote_count" id="upvote_count"" value="{{{ $item->upvote_count }}}"/>
    </div>
  </fieldset>

  {{-- Answer Downvote count input box --}}
  <fieldset
    name="downvote_count"
    class="control-group hasTip"
    title="@lang('COM_CAJOBBOARD_ANSWERS_DOWNVOTE_COUNT_FIELD_TOOLTIP_TITLE')::@lang('COM_CAJOBBOARD_ANSWERS_DOWNVOTE_COUNT_FIELD_TOOLTIP_TEXT')"
  >
    <div class="control-label">
      <label for="downvote_count">
        @lang('COM_CAJOBBOARD_ANSWERS_DOWNVOTES_BUTTON_LABEL')
      </label>
    </div>
    <div class="controls">
      <input type="number" step="1" name="downvote_count" id="downvote_count" value="{{{ $item->downvote_count }}}"/>
    </div>
  </fieldset>

@stop
