<?php
/**
 * Comments Admin Edit View Template
 *
 * @package   Calligraphic Job Board
 * @version   October 17, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

  use \FOF30\Utils\FEFHelper\BrowseView;

  // no direct access
  defined('_JEXEC') or die;

  /** @var \Calligraphic\Cajobboard\Admin\Model\Comments  $item */
  $item = $this->getItem();
?>

@extends('admin:com_cajobboard/Common/edit')

{{-----------------------------------------------------------------------------}}
{{-- SECTION: Default edit form tab in this section ---------------------------}}
{{-----------------------------------------------------------------------------}}

@section('basic-options')
  <fieldset name="text" class="control-group">
      <div class="controls">
        @jhtml('helper.editorWidgets.editor', 'text', $item->text)
      </div>
  </fieldset>
@stop


{{-----------------------------------------------------------------------------}}
{{-- SECTION: Advanced options form tab in this section -----------------------}}
{{-----------------------------------------------------------------------------}}

@section('advanced-options')
  {{-- Comment Description textbox --}}
  @jhtml('helper.editWidgets.textbox', 'description', $item)

  {{-- Comment Upvote count input box --}}
  @jhtml('helper.editWidgets.inputNumber', 'upvote_count', $item)

  {{-- Comment Downvote count input box --}}
  @jhtml('helper.editWidgets.inputNumber', 'downvote_count', $item)
@stop
