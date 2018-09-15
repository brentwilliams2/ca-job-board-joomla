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
  use JText;

  // no direct access
  defined('_JEXEC') or die;

  $params = $this->getPageParams();

  // parameters for email input box
  $emailPlaceholder = $params->get('registration_email_placeholder'

  // link for forgot password input box
  $forgotPasswordURL = "<a href=" . JRoute::_('index.php?option=com_users&view=reset') . "\">";

  // admin parameters for links
  $terms_of_service = JRoute::_('index.php?Itemid=' . $params->get('terms_of_use'));
  $privacy_policy = JRoute::_('index.php?Itemid=' . $params->get('privacy_policy'));
?>

@js('media:com_cajobboard/js/loginForm.js')

{{--
  Login to account with email
--}}
@section('email')
  <form id="email-login-form">

    <div id="login-email" class="form-group">
      <label for="email-input" class="control-label">
        @lang('COM_CAJOBBOARD_LOGIN_USERNAME_OR_EMAIL_INPUT_LABEL')
      </label>
      <input type="email" class="form-control" id="email-or-username-login-input" placeholder="{{{ $emailPlaceholder }}}">
    </div>

    <div id="login-password" class="form-group hidden">
      <label for="login-password-input" class="control-label">
        @lang('COM_CAJOBBOARD_LOGIN_PASSWORD_INPUT_LABEL')
      </label>
      <input type="password" class="form-control" id="login-password-input" placeholder="{{{ @lang('COM_CAJOBBOARD_REGISTRATION_PASSWORD_INPUT_PLACEHOLDER') }}}">
    </div>

    <div class="checkbox" class="form-control">
      <input type="checkbox" name="remember" id="persons-login-remember" value="yes">
      <label for="persons-login-remember">
        <?php echo JText::_('COM_CAJOBBOARD_LOGIN_REMEMBER_ME_LABEL'); ?>
      </label>
    </div>

    <div>
      @lang('COM_CAJOBBOARD_LOGIN_FORGOT_PASSWORD_TEXT', $forgotPasswordURL)
    </div>

    <div class="form-control">
      <button id="email-signin-button" type="submit" class="btn btn-default pull-right">
        @lang('COM_CAJOBBOARD_LOGIN_EMAIL_SIGNIN_BUTTON')
      </button>
    </div>

  </form>
@show


{{--
  Sign in with Google
--}}
@section('google')
  @if ($params->get('google_login_enabled'))
    <div class="row">
      <button
        id="sign-in-with-google"
        class="btn social-button social-button-text social-button-pill social-button-shadow-bottom social-button-google social-sign-in"
        data-network="google"
      >
        <i class="fa fa-google"></i>
        @lang('COM_CAJOBBOARD_LOGIN_GOOGLE')
      </button>
    </div>
  @endif
@show

{{--
  Sign in with Facebook
--}}
@section('facebook')
  @if ($params->get('facebook_login_enabled'))
    <div class="row">
      <button
        id="sign-in-with-facebook"
        class="btn social-button social-button-text social-button-pill social-button-shadow-bottom social-button-facebook social-sign-in"
        data-network="facebook"
      >
        <i class="fa fa-facebook"></i>
        @lang('COM_CAJOBBOARD_LOGIN_FACEBOOK')
      </button>
    </div>
  @endif
@show

{{--
  Sign in with Linkedin
--}}
@section('linkedin')
  @if ($params->get('linkedin_login_enabled'))
    <div class="row">
      <button
        id="sign-in-with-linkedin"
        class="btn social-button social-button-text social-button-pill social-button-shadow-bottom social-button-linkedin social-sign-in"
        data-network="linkedin"
      >
        <i class="fa fa-linkedin"></i>
        @lang('COM_CAJOBBOARD_LOGIN_LINKEDIN')
      </button>
    </div>
  @endif
@show

{{--
  Sign in with Instagram
--}}
@section('instagram')
  @if ($params->get('instagram_login_enabled'))
    <div class="row">
      <button
        id="sign-in-with-instagram"
        class="btn social-button social-button-text social-button-pill social-button-shadow-bottom social-button-instagram social-sign-in"
        data-network="instagram"
      >
        <i class="fa fa-instagram"></i>
        @lang('COM_CAJOBBOARD_LOGIN_INSTAGRAM')
      </button>
    </div>
  @endif
@show

{{--
  Sign in with Twitter
--}}
@section('twitter')
  @if ($params->get('twitter_login_enabled'))
    <div class="row">
      <button
        id="sign-in-with-twitter"
        class="btn social-button social-button-text social-button-pill social-button-shadow-bottom social-button-twitter social-sign-in"
        data-network="twitter"
      >
        <i class="fa fa-twitter"></i>
        @lang('COM_CAJOBBOARD_LOGIN_TWITTER')
      </button>
    </div>
  @endif
@show

{{--
  login dialog box
--}}
@section('login')
  @yield('google')
  @yield('facebook')
  @yield('linkedin')
  @yield('instagram')
  @yield('twitter')

  <hr class="hr-text" data-content="@lang('COM_CAJOBBOARD_REGISTRATION_OR_SPACER')">

  @lang('COM_CAJOBBOARD_LOGIN_WITH_EMAIL')
  @yield('email')

  @lang('COM_CAJOBBOARD_REGISTRATION_TOS_AND_PRIVACY_POLICY_STATEMENT', $terms_of_service, $privacy_policy)
@show
