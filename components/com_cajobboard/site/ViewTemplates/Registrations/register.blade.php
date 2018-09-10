<?php
 /**
  * Registrations Dialog Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // Framework classes
  use JUri;

  // no direct access
  defined('_JEXEC') or die;

  $params = $this->getPageParams();

  $emailPlaceholder       = $params->get('registration_email_placeholder'

  // parameters set in admin for password strength
  $usersConfig = Container::getInstance('com_users')->params;
  $minPasswordLength      = $usersConfig->get('minimum_length');
  $minNumberOfIntegers    = $usersConfig->get('minimum_integers');
  $minNumberOfUppercase   = $usersConfig->get('minimum_uppercase');
  $minNumberOfSymbols     = $usersConfig->get('minimum_symbols');
?>

@js('media:com_cajobboard/js/registerForm.js')

{{--
  Create account with email
--}}
@section('email')
  <form id="email-registration-form">

    <div id="registration-email" class="form-group">
      <label for="email-input">
        @lang('COM_CAJOBBOARD_REGISTRATION_EMAIL_INPUT_LABEL')
      </label>
      <input type="email" class="form-control" id="email-input" placeholder="{{{ $emailPlaceholder }}}">
    </div>

    <div id="registration-password" class="form-group hidden">
      <label for="password-input">
        @lang('COM_CAJOBBOARD_REGISTRATION_PASSWORD_INPUT_LABEL')
      </label>
      <input type="password" class="form-control" id="password-input" placeholder="{{{ @lang('COM_CAJOBBOARD_REGISTRATION_PASSWORD_INPUT_PLACEHOLDER') }}}">
    </div>

    <div>
      <button id="email-continue-button" type="button" class="btn btn-default pull-right">
        @lang('COM_CAJOBBOARD_REGISTRATION_EMAIL_CONTINUE_BUTTON')
      </button>
    </div>

    <input id="minPasswordLength"    type="hidden" value="{{{ $minPasswordLength }}}">
    <input id="minNumberOfIntegers"  type="hidden" value="{{{ $minNumberOfIntegers }}}">
    <input id="minNumberOfUppercase" type="hidden" value="{{{ $minNumberOfUppercase }}}">
    <input id="minNumberOfSymbols"   type="hidden" value="{{{ $minNumberOfSymbols }}}">

    <input id="invalidEmailMessage"    type="hidden" value="{{{ @lang('COM_CAJOBBOARD_REGISTRATION_INVALID_EMAIL_MESSAGE') }}}">
    <input id="invalidPasswordMessage" type="hidden" value="{{{ @lang('COM_CAJOBBOARD_REGISTRATION_INVALID_PASSWORD_MESSAGE', $minPasswordLength) }}}">
  </form>
@show

{{--
  Create account with Google
--}}
@section('google')
  @if ($params->get('google_login_enabled'))
    <div class="row">
      <a href="#" class="btn social-button social-button-text social-button-pill social-button-shadow-bottom social-button-google">
        <i class="fa fa-google"></i>
        @lang('COM_CAJOBBOARD_REGISTRATION_GOOGLE')
      </a>
    </div>
  @endif
@show

{{--
  Create account with Facebook
--}}
@section('facebook')
  @if ($params->get('facebook_login_enabled'))
    <div class="row">
      <a href="#" class="btn social-button social-button-text social-button-pill social-button-shadow-bottom social-button-facebook">
        <i class="fa fa-facebook"></i>
        @lang('COM_CAJOBBOARD_REGISTRATION_FACEBOOK')
      </a>
    </div>
  @endif
@show

{{--
  Create account with Linkedin
--}}
@section('linkedin')
  @if ($params->get('linkedin_login_enabled'))
    <div class="row">
      <a href="#" class="btn social-button social-button-text social-button-pill social-button-shadow-bottom social-button-linkedin">
        <i class="fa fa-linkedin"></i>
        @lang('COM_CAJOBBOARD_REGISTRATION_LINKEDIN')
      </a>
    </div>
  @endif
@show

{{--
  Create account with Instagram
--}}
@section('instagram')
  @if ($params->get('instagram_login_enabled'))
    <div class="row">
      <a href="#" class="btn social-button social-button-text social-button-pill social-button-shadow-bottom social-button-instagram">
        <i class="fa fa-instagram"></i>
        @lang('COM_CAJOBBOARD_REGISTRATION_INSTAGRAM')
      </a>
    </div>
  @endif
@show

{{--
  Create account with Twitter
--}}
@section('twitter')
  @if ($params->get('twitter_login_enabled'))
    <div class="row">
      <a href="#" class="btn social-button social-button-text social-button-pill social-button-shadow-bottom social-button-twitter">
        <i class="fa fa-twitter"></i>
        @lang('COM_CAJOBBOARD_REGISTRATION_TWITTER')
      </a>
    </div>
  @endif
@show

{{--
  Register new user / social login dialog box
--}}
@section('login-or-register')

  @yield('')
  @yield('')
  @yield('')
  @yield('')
  @yield('')
  @yield('')

@show
