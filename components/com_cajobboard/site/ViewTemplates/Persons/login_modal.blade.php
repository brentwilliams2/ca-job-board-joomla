<?php
 /**
  * Login Modal Dialog Template
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
?>

{{--
  Sign in with email
--}}
@section('email')
  username or email
  password
  Sign in (button)
  keep me logged in (checkbox)
  forgot password (button)
  don't have a {job board} account? (sign up)
@show


{{--
  Sign in with Google
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
  Sign in with Facebook
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
  Sign in with Linkedin
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
  Sign in with Instagram
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
  Sign in with Twitter
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

@show
