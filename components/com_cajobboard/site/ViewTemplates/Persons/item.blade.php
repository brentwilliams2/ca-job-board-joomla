<?php
 /**
  * Persons Site Item View Template
  *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  use \Calligraphic\Cajobboard\Site\Helper\User;
  use \Calligraphic\Cajobboard\Site\Helper\Format;

  // no direct access
  defined('_JEXEC') or die;

  // Add component JS and CSS in view templates so that they're properly handled if HMVC in use
  $this->container->AssetFiles->addComponentCss($this);
  $this->container->AssetFiles->addViewJavascript($this);

  /** @var \Calligraphic\Cajobboard\Site\Model\Persons $item */
  $item = $this->getItem();

  /*
    Limit access to personally identifiable information:

    @if ($this->getContainer()->platform->getUser()->authorise('com_cajobboard.pii', 'com_cajobboard'))
      protected content
    @endif
   */
?>

{{--
  Person Real Name
--}}
@section('person_name')
  {{-- link to individual person --}}
  <a class="person-title" href="@route('index.php?option=com_cajobboard&view=Persons&task=read&id=' . $item->id)">
      {{{ $item->name }}}
  </a>
@overwrite

{{--
  User's system user name
--}}
@section('person_username')
  <span class="person-username">
    <b>{{{ $item->name }}}</b>
  </span>
@overwrite


{{--
  User's Email
--}}
@section('person_email')
  <span class="person-email">
    {{{ $item->email }}}
  </span>
@overwrite

{{--
  Whether user is Activated
--}}
@section('person_activation')
  <input type="checkbox" name="activation" class="person-activation" value="{{ $item->activation }}">
@overwrite

{{--
  Whether user is blocked
--}}
@section('person_block')
  <input type="checkbox" name="block" class="person-block" value="{{ $item->block }}">
@overwrite

{{--
  User's registration date
--}}
@section('person_register_date')
  <span class="person-register-date">
    {{ $this->container->Format->date($item->registerDate) }}
  </span>
@overwrite

{{--
  User's last visited date
--}}
@section('person_last_visited_date')
  <span class="person-last-visited-date">
    {{ $this->container->Format->date($item->lastvisitDate) }}
  </span>
@overwrite

{{--
  User's Profiles
--}}
@section('person_profile_fields')
  <span class="person-profile-fields">
    @TODO: Add User Profile Fields
  </span>
@overwrite

{{--
  "Report person" Button
--}}
@section('report_person')
  <button type="button" class="btn btn-primary btn-xs btn-person report-person pull-right" data-toggle="modal" data-target="#report-person">
    @lang('COM_CAJOBBOARD_REPORT_PERSON_BUTTON_LABEL')
  </button>
@overwrite

{{--
  Edit Button for logged-in users that have permission to edit the item
--}}
@section('edit_person')
  @if ($canUserEdit)

    <a class="delete-person-link" onClick="removeSubmit( {{ $item->id }} )">
      <button type="button" class="btn btn-danger btn-xs btn-person delete-person-button pull-right">
        @lang('COM_CAJOBBOARD_DELETE_PERSON_BUTTON_LABEL')
      </button>
    </a>

    <a class="edit-person-link" href="@route('index.php?option=com_cajobboard&view=person&task=edit&id='. (int) $item->id)">
      <button type="button" class="btn btn-warning btn-xs btn-person edit-person-button pull-right">
        @lang('COM_CAJOBBOARD_EDIT_PERSON_BUTTON_LABEL')
      </button>
    </a>

  @endif
@overwrite


{{--
  Responsive container for desktop and mobile
--}}
<div class="row person-list-item media">
    <h4>
      @yield('person_name')
    </h4>

    <div>
      @yield('person_username')
    </div>

    <div>
      @yield('person-email')
    </div>

    <div>
      @yield('person_activation')
    </div>

    <div>
      @yield('person_block')
    </div>

    <div>
      @yield('person_register_date')
    </div>

    <div>
      @yield('person_last_visited_date')
    </div>

    <div>
        @yield('person_profile_fields')
    </div>

    <div>
      @yield('report_person')
    </div>
  </div>

{{-- Form with CSRF field for remove action --}}
<form action="@route('index.php?option=com_cajobboard&view=Persons&task=remove&id=' . $item->id)" method="post" name="removeForm" id="removeForm-{{ $item->id }}">
  <input type="hidden" name="@token()" value="1"/>
</form>

<div class="clearfix"></div>

{{--
  Modal templates used in common for all default_item views, only
  take bandwidth hit of including modal HTML if user is logged in
--}}
@if ( !$isGuestUser )
  @yield('report-item-modal')
@endif
