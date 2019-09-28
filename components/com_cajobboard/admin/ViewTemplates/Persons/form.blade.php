<?php
/**
 * Persons Admin Edit View Template
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

  use \FOF30\Utils\FEFHelper\BrowseView;
  use \Joomla\CMS\HTML\HTMLHelper;

  // no direct access
  defined('_JEXEC') or die;

  // Javascript libraries to include
  HTMLHelper::_('behavior.tooltip');

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

@section('basic-options')
  {{-- Full name --}}
  <fieldset
    name="name"
    class="control-group hasTip"
    title="@lang('COM_CAJOBBOARD_PERSONS_NAME_FIELD_TOOLTIP_TITLE')::@lang('COM_CAJOBBOARD_PERSONS_NAME_FIELD_TOOLTIP_TEXT')"
  >
    <div class="control-label">
      <label for="name">
        @lang('COM_CAJOBBOARD_PERSONS_NAME_FIELD_LABEL')
      </label>
    </div>
    <div>
      <input type="text" name="name" value="{{{ $item->name }}}">
    </div>
  </fieldset>


  {{-- User Name --}}
  <fieldset
    name="username"
    class="control-group hasTip"
    title="@lang('COM_CAJOBBOARD_PERSONS_USERNAME_FIELD_TOOLTIP_TITLE')::@lang('COM_CAJOBBOARD_PERSONS_USERNAME_FIELD_TOOLTIP_TEXT')"
  >
    <div class="control-label">
      <label for="username">
        @lang('COM_CAJOBBOARD_PERSONS_USERNAME_FIELD_LABEL')
      </label>
    </div>
    <div>
      <input type="text" name="username" value="{{{ $item->username }}}">
    </div>
  </fieldset>


  {{-- Email --}}
  <fieldset
    name="email"
    class="control-group hasTip"
    title="@lang('COM_CAJOBBOARD_PERSONS_EMAIL_FIELD_TOOLTIP_TITLE')::@lang('COM_CAJOBBOARD_PERSONS_EMAIL_FIELD_TOOLTIP_TEXT')"
  >
    <div class="control-label">
      <label for="email">
        @lang('COM_CAJOBBOARD_PERSONS_EMAIL_FIELD_LABEL')
      </label>
    </div>
    <div>
      @if ($item->sendEmail)
        <a href="index.php?option=com_cajobboard&view=EmailMessages&task=addByPersonId&recipient_id={{$item->id}}">
          <input type="email" name="username" value="{{{ $item->email }}}">
        </a>
      @else
        <input type="email" name="username" value="{{{ $item->email }}}">
      @endif
    </div>
  </fieldset>


  {{-- Is User Activated --}}
  <fieldset
    name="activation"
    class="control-group hasTip"
    title="@lang('COM_CAJOBBOARD_PERSONS_ACTIVATION_FIELD_TOOLTIP_TITLE')::@lang('COM_CAJOBBOARD_PERSONS_ACTIVATION_FIELD_TOOLTIP_TEXT')"
  >
    <div class="control-label">
      <label for="activation">
        @lang('COM_CAJOBBOARD_PERSONS_ACTIVATION_FIELD_LABEL')
      </label>
    </div>
    <div class="btn-group">
      <input type="checkbox" name="activation" value="{{ $item->activation }}">
    </div>
  </fieldset>


  {{-- Is User Blocked --}}
  <fieldset
    name="block"
    class="control-group hasTip"
    title="@lang('COM_CAJOBBOARD_PERSONS_BLOCK_FIELD_TOOLTIP_TITLE')::@lang('COM_CAJOBBOARD_PERSONS_BLOCK_FIELD_TOOLTIP_TEXT')"
  >
    <div class="control-label">
      <label for="block">
        @lang('COM_CAJOBBOARD_PERSONS_BLOCK_FIELD_LABEL')
      </label>
    </div>
    <div class="btn-group">
      <input type="checkbox" name="block" value="{{ $item->block }}">
    </div>
  </fieldset>


  {{-- Date Registered --}}
  <fieldset
    name="registerDate"
    class="control-group hasTip"
    title="@lang('COM_CAJOBBOARD_PERSONS_REGISTER_DATE_FIELD_TOOLTIP_TITLE')::@lang('COM_CAJOBBOARD_PERSONS_REGISTER_DATE_FIELD_TOOLTIP_TEXT')"
  >
    <div class="control-label">
      <label for="registerDate">
        @lang('COM_CAJOBBOARD_PERSONS_REGISTER_DATE_FIELD_LABEL')
      </label>
    </div>
    <div>
      <input type="date" name="registerDate" value="{{ $this->container->Format->date($item->registerDate) }}">
    </div>
  </fieldset>


  {{-- Last Visit Date --}}
  <fieldset
    name="lastvisitDate"
    class="control-group hasTip"
    title="@lang('COM_CAJOBBOARD_PERSONS_LAST_VISIT_DATE_FIELD_TOOLTIP_TITLE')::@lang('COM_CAJOBBOARD_PERSONS_LAST_VISIT_DATE_FIELD_TOOLTIP_TEXT')"
  >
    <div class="control-label">
      <label for="lastvisitDate">
        @lang('COM_CAJOBBOARD_PERSONS_LAST_VISIT_DATE_FIELD_LABEL')
      </label>
    </div>
    <div>
      <input type="date" name="lastvisitDate" value="{{ $this->container->Format->date($item->lastvisitDate) }}">
    </div>
  </fieldset>

  <h1>@TODO: Add Profile Fields</h1>
@stop


{{-----------------------------------------------------------------------------}}
{{-- SECTION: Advanced options form tab in this section -----------------------}}
{{-----------------------------------------------------------------------------}}


@section('advanced-options')

@stop