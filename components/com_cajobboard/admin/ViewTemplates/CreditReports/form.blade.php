<?php
/**
 * Credit Reports Admin Edit View Template
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

  /** @var \Calligraphic\Cajobboard\Admin\Model\CreditReports $item */
  $item = $this->getItem();

  // Using an include so that local vars in the included file are in scope here also
  include(JPATH_COMPONENT_ADMINISTRATOR . '/ViewTemplates/CreditReports/local_vars.php');
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
  {{-- Credit Report Description textbox --}}
  @jhtml('helper.editWidgets.textbox', 'description', $item)

  @jhtml('helper.enumwidgets.actionStatus', $currentActionStatus)
@stop
