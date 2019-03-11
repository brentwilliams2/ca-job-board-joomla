<?php
 /**
  * Admin Common Edit (form) View Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  * Use this by extending it, using -at- instead of the at-sign
  * -at-extends('admin:com_cajobboard/Common/edit')
  *
  * Override the following sections in your Blade template:
  *
  * edit-page-top
  *      Content to put above the form
  *
  * edit-page-bottom
  *      Content to put below the form
  *
  * edit-form-body
  *      The page's body, inside the form
  *
  * edit-hidden-fields
  *      [ Optional ] Any additional hidden INPUTs to add to the form. By default this is empty.
  *      The default hidden fields (option, view, task, ordering fields, boxchecked and token) can
  *      not be removed.
  *
  * Do not override any other section
  */

  // no direct access
  defined('_JEXEC') or die;

  use FOF30\Utils\FEFHelper\Html as FEFHtml;

  /** @var  FOF30\View\DataView\Html  $this */

  $item = $this->getItem();
?>

{{--
  CSS-triggered tooltip example with tooltip title and tooltip text in form <tooltip title>::<tooltip text>

  <span class="hasTooltip" title="Text Tooltip Title::This is a tooltip attached to text">
     Hover on this text to see the tooltip
  </span>
--}}
@jhtml('behavior.tooltip')

{{--
  JHtmlFormbehavior::chosen(string $selector = '.advancedSelect', mixed $debug = null, array $options = array())

  $(document).find("select").chosen({
    "disable_search_threshold": 10,
    "search_contains": true,
    "allow_single_deselect": true,
    "placeholder_text_multiple": "**Type or select some options**",
    "placeholder_text_single": "**Select an option**",
    "no_results_text": "**No results match**"
  });
--}}
@jhtml('formbehavior.chosen', 'select', True, [])

{{-----------------------------------------------------------------------------}}
{{-- SECTION: Header at top of form -------------------------------------------}}
{{-----------------------------------------------------------------------------}}

@section('header')
  <div class="form-inline form-inline-header">
    <fieldset name="title" class="control-group">
      <div class="control-label">
        <label for="name">
          @lang('JFIELD_TITLE_DESC')
        </label>
      </div>
      <div class="controls">
        <input
          type="text"
          name="name"
          id="name"
          value="{{{ $item->name }}}"
          size="40"
          required="required"
          aria-required="true"
          aria-invalid="false"
        >
      </div>
    </fieldset>

    <fieldset name="alias" class="control-group">
      <div class="control-label">
        <label for="alias">
          @lang('JFIELD_ALIAS_LABEL')
        </label>
      </div>
      <div class="controls">
        <input
          type="text"
          name="slug"
          id="slug"
          value="{{{ $item->slug }}}"
          size="40"
          placeholder="@lang('JFIELD_ALIAS_PLACEHOLDER')"
          aria-invalid="false"
        >
      </div>
    </fieldset>
  </div>
@stop


{{-----------------------------------------------------------------------------}}
{{-- SECTION: Regular edit form tab in this section ---------------------------}}
{{-----------------------------------------------------------------------------}}

@section('basic-options')
@stop


{{-----------------------------------------------------------------------------}}
{{-- SECTION: Advanced options form tab in this section -----------------------}}
{{-----------------------------------------------------------------------------}}

@section('advanced-options')
@stop


{{-----------------------------------------------------------------------------}}
{{-- SECTION: Permissions tab in this section ---------------------------------}}
{{-----------------------------------------------------------------------------}}

@section('permissions-options')
  {{-- @include('admin:com_cajobboard/Common/PermissionsTab', ['item' => $item]) --}}
@stop


{{-----------------------------------------------------------------------------}}
{{-- SECTION: Additional hidden fields in this section ------------------------}}
{{-----------------------------------------------------------------------------}}

@section('edit-hidden-fields')
@stop


{{-----------------------------------------------------------------------------}}
{{-- SECTION: Joomla! sidebar -------------------------------------------------}}
{{-----------------------------------------------------------------------------}}
{{-- Override in child view template to change what default fields are hidden--}}
{{-----------------------------------------------------------------------------}}

@section('sidebar')
  @include('admin:com_cajobboard/Common/SideBar', ['item' => $item, 'fieldsToHide' => array('parent')])
@stop


{{-----------------------------------------------------------------------------}}
{{-- MAIN EDIT FORM BODY ------------------------------------------------------}}
{{-----------------------------------------------------------------------------}}

@yield('edit-page-top')

{{-- Administrator form for edit views --}}
<form
  action="index.php"
  method="post"
  name="adminForm"
  id="adminForm"
  {{-- Joomla client-side form validation class to trigger javascript --}}
  class="form-validate"
>
  @yield('header')

  {{-- Tabbed pages --}}
	<div class="form-horizontal">
    {{--
      startTabSet(string $selector = 'myTab', array $params = array())
        $selector  The pane identifier.
        $params  Array. 'active' key specifies which tab pane $id to set as active on page load.
    --}}
    <?php echo JHtml::_('bootstrap.startTabSet', 'edit-form-tabs', array('active' => 'basic-options')); ?>

      {{--
        addTab(string $selector, string $id, string $title)
          $selector  Name of the tabset this pane belongs to
          $id  The unique ID of the div element
      --}}

      {{-- "Basic" tab --}}
      <?php echo JHtml::_('bootstrap.addTab', 'edit-form-tabs', 'basic-options', JText::_('COM_CAJOBBOARD_ADMIN_EDIT_MAIN_TAB')); ?>
        <div class="row-fluid">
          <div class="span9">
            <div class="form-vertical">
              @yield('basic-options')
            </div>
          </div>
          <div class="span3">
            @yield('sidebar')
          </div>
        </div>
      <?php echo JHtml::_('bootstrap.endTab'); ?>

      {{-- "Advanced" tab --}}
      <?php echo JHtml::_('bootstrap.addTab', 'edit-form-tabs', 'advanced-options', JText::_('JOPTIONS')); ?>
        @yield('advanced-options')
      <?php echo JHtml::_('bootstrap.endTab'); ?>

      {{-- "Publish" tab --}}
      <?php echo JHtml::_('bootstrap.addTab', 'edit-form-tabs', 'publishing-options', JText::_('JGLOBAL_FIELDSET_PUBLISHING')); ?>
        @include('admin:com_cajobboard/Common/PublishTab', [ 'item' => $item ])
      <?php echo JHtml::_('bootstrap.endTab'); ?>

      {{-- "Permissions" tab --}}
      <?php echo JHtml::_('bootstrap.addTab', 'edit-form-tabs', 'permissions-options', JText::_('JCONFIG_PERMISSIONS_LABEL')); ?>
        @yield('permissions-options')
      <?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>
	</div>

  {{-- Hidden form fields --}}
  <div class="cajobboard-hidden-fields-container">
    @section('browse-default-hidden-fields')
      <input type="hidden" name="option" id="option" value="{{{ $this->getContainer()->componentName }}}"/>
      <input type="hidden" name="view" id="view" value="{{{ $this->getName() }}}"/>
      <input type="hidden" name="task" id="task" value="{{{ $this->getTask() }}}"/>
      <input type="hidden" name="id" id="id" value="{{{ $this->getItem()->getId() }}}"/>
      <input type="hidden" name="@token()" value="1"/>
    @show

    @yield('edit-hidden-fields')
  </div>
</form>

@yield('edit-page-bottom')

<?php
/*
 *  Example Controls
 *
 *  Label, with example translation string generated based on current view:
 *
 *    @fieldtitle('title')
 *    COM_CAJOBBOARD_ANSWER_FIELD_TITLE
 *
 *  Text input:
 *
 *    <input type="text" name="fieldName" id="fieldName" value="{{{ $item->fieldName }}}"/>
 *
 *  Text area:
 *
 *    <textarea name="notes" id="notes" cols="40" rows="5">{{ $item->notes }}</textarea>
 *
 *  Drop-down combo box with preset values:
 *
 *    $typeOptions = [
 *      'value'       => JText::_('COM_CAJOBBOARD_COUPON_TYPE_VALUE'),
 *      'percent'     => JText::_('COM_CAJOBBOARD_COUPON_TYPE_PERCENT'),
 *      'lastpercent' => JText::_('COM_CAJOBBOARD_COUPON_TYPE_LASTPERCENT'),
 *    ];
 *
 *    @jhtml('FEFHelper.select.genericlist', $typeOptions, 'type', ['list.select' => $item->type])
 *
 *  Number with step value:
 *
 *    <input type="number" step="0.01" name="value" id=value" value="{{{ $item->value }}}"/>
 *
 *  Boolean:
 *
 *    @jhtml('FEFHelper.select.booleanswitch', 'enabled', $item->enabled)
 *
 *  Calendar:
 *
 *    calendar ( $value, $name, $id, $format= '%Y-%m-%d', $attribs=null )
 *      $attribs is additional html attributes
 *    @jhtml('calendar', $item->publish_up, 'publish_up', 'publish_up', '%Y-%m-%d %H:%M:%S')
 *
 *  Select a user (same format for calling any template with an array of values):
 *
 *    @include('admin:com_cajobboard/Common/EntryUser', ['field' => 'user', 'item' => $item, 'required' => true])
 *
 *  Email entry:
 *
 *    <input type="email" name="email" id=email" value="{{{ $item->email }}}"/>
 *
 *  User group drop-down combo box, pre-populated:
 *
 *    @jhtml('FEFHelper.select.genericlist', \FOF30\Utils\SelectOptions::getOptions('usergroups'), 'type', ['list.select' => $item->type, 'list.attr' => ['multiple' => 'multiple']])
 *
 *  Drop-down combo box populated from a foreign model field:
 *
 *    <?php echo BrowseView::modelSelect('subscriptions[]', 'Levels', $item->subscriptions, ['fof.autosubmit' => false, 'translate' => false, 'list.attr' => ['multiple' => 'multiple']]) ?>
 *
 *  Access levels:
 *
 *    @jhtml('FEFHelper.select.genericlist', \FOF30\Utils\SelectOptions::getOptions('access'), 'access', ['list.select' => $item->access])
 *
 *  Editor:
 *
 *    @jhtml('FEFHelper.edit.editor', 'description', $item->description)
 *
 *  Currency value:
 *
 *    @include('admin:com_akeebasubs/Common/EntryPrice', ['field' => 'signupfee', 'item' => $item])
 *
 *
 *
 *  Keep session alive, for example, while editing or creating an article:
 *
 *    JHtml::_('behavior.keepalive');
 *
 *  Client-side form validation, see https://docs.joomla.org/Client-side_form_validation
 *
 *    JHtml::_('behavior.formvalidator');
 *
 *  action URL for <form> field:
 *
 *   <?php echo JRoute::_('index.php?option=com_cajobboard&layout=edit&id=' . (int) $item->answer_id); ?>
 *
 */
