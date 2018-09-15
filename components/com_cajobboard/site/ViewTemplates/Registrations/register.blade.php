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
  use JRoute;

  // no direct access
  defined('_JEXEC') or die;

  params = $this->getPageParams();

  // parameters for email input box
  $emailPlaceholder       = $params->get('registration_email_placeholder');

  // parameters set in admin for password strength
  $usersConfig = Container::getInstance('com_users')->params;
  $minPasswordLength      = $usersConfig->get('minimum_length');
  $minNumberOfIntegers    = $usersConfig->get('minimum_integers');
  $minNumberOfUppercase   = $usersConfig->get('minimum_uppercase');
  $minNumberOfSymbols     = $usersConfig->get('minimum_symbols');

  // admin parameters for links
  $terms_of_service = JRoute::_('index.php?Itemid=' . $params->get('terms_of_use'));
  $privacy_policy = JRoute::_('index.php?Itemid=' . $params->get('privacy_policy'));


  // Load and initialize captcha plugin if enabled in global configuration
  $captcha = JFactory::getApplication()->get('captcha', 0);
  // Global captcha configuration: 0 if not enabled, or name of captcha plugin to use
  if($captcha) {
    JPluginHelper::importPlugin('captcha', $captcha);
    $dispatcher = JDispatcher::getInstance();
    $dispatcher->trigger('onInit', $captcha);
  }
?>

@js('media:com_cajobboard/js/registerForm.js')

{{--
  Create account with email
--}}
@section('email')
  <form id="email-registration-form">

    <div id="registration-email" class="form-group">
      <label for="email-input" class="control-label">
        @lang('COM_CAJOBBOARD_REGISTRATION_EMAIL_INPUT_LABEL')
      </label>
      <input type="email" class="form-control" id="email-input" placeholder="{{{ $emailPlaceholder }}}">
    </div>

    <div id="registration-password" class="form-group hidden">
      <label for="registration-password-input" class="control-label">
        @lang('COM_CAJOBBOARD_REGISTRATION_PASSWORD_INPUT_LABEL')
      </label>
      <input type="password" class="form-control" id="registration-password-input" placeholder="{{{ @lang('COM_CAJOBBOARD_REGISTRATION_PASSWORD_INPUT_PLACEHOLDER') }}}">
    </div>

    {{-- Captcha --}}
    @if( $captcha )
      <div id="registration-captcha" class="form-group">
        <label for="registration-dynamic-captcha" class="control-label">
          @lang('COM_CAJOBBOARD_REGISTRATION_CAPTCHA_DESC')
        </label>
        <?php echo $dispatcher->trigger( 'onDisplay', [ null, 'registration-dynamic-captcha' ] ); ?>
      </div>
    @endif

    <div class="form-group">
      <button id="email-continue-button" type="submit" class="btn btn-default pull-right">
        @lang('COM_CAJOBBOARD_REGISTRATION_EMAIL_CONTINUE_BUTTON')
      </button>
    </div>

    <input id="invalidEmailMessage"  type="hidden" value="{{{ @lang('COM_CAJOBBOARD_REGISTRATION_INVALID_EMAIL_MESSAGE') }}}">

    <input id="passwordLength"       type="hidden" value="{{{ $minPasswordLength) }}}">
    <input id="passwordIntegers"     type="hidden" value="{{{ $minNumberOfIntegers) }}}">
    <input id="passwordUppercase"    type="hidden" value="{{{ $minNumberOfUppercase) }}}">
    <input id="passwordSymbols"      type="hidden" value="{{{ $minNumberOfSymbols) }}}">

    <input id="invalidPasswordLengthMessage"    type="hidden" value="{{{ @lang('COM_CAJOBBOARD_REGISTRATION_INVALID_LENGTH_PASSWORD_MESSAGE', $minPasswordLength) }}}">
    <input id="invalidPasswordIntegersMessage"  type="hidden" value="{{{ @lang('COM_CAJOBBOARD_REGISTRATION_INVALID_INTEGERS_PASSWORD_MESSAGE', $minNumberOfIntegers) }}}">
    <input id="invalidPasswordUppercaseMessage" type="hidden" value="{{{ @lang('COM_CAJOBBOARD_REGISTRATION_INVALID_UPPERCASE_PASSWORD_MESSAGE', $minNumberOfUppercase) }}}">
    <input id="invalidPasswordSymbolsMessage"   type="hidden" value="{{{ @lang('COM_CAJOBBOARD_REGISTRATION_INVALID_SYMBOLS_PASSWORD_MESSAGE', $minNumberOfSymbols) }}}">
  </form>
@show

{{--
  Create account with Google
--}}
@section('google')
  @if ($params->get('google_login_enabled'))
    <div class="row">
      <button
        id="registration-with-google"
        class="btn social-button social-button-text social-button-pill social-button-shadow-bottom social-button-google social-register"
        data-network="google"
      >
        <i class="fa fa-google"></i>
        @lang('COM_CAJOBBOARD_REGISTRATION_GOOGLE')
      </button>
    </div>
  @endif
@show

{{--
  Create account with Facebook
--}}
@section('facebook')
  @if ($params->get('facebook_login_enabled'))
    <div class="row">
      <button
        id="registration-with-facebook"
        class="btn social-button social-button-text social-button-pill social-button-shadow-bottom social-button-facebook social-register"
        data-network="facebook"
      >
        <i class="fa fa-facebook"></i>
        @lang('COM_CAJOBBOARD_REGISTRATION_FACEBOOK')
      </button>
    </div>
  @endif
@show

{{--
  Create account with Linkedin
--}}
@section('linkedin')
  @if ($params->get('linkedin_login_enabled'))
    <div class="row">
      <button
        id="registration-with-linkedin"
        class="btn social-button social-button-text social-button-pill social-button-shadow-bottom social-button-linkedin social-register"
        data-network="linkedin"
      >
        <i class="fa fa-linkedin"></i>
        @lang('COM_CAJOBBOARD_REGISTRATION_LINKEDIN')
      </button>
    </div>
  @endif
@show

{{--
  Create account with Instagram
--}}
@section('instagram')
  @if ($params->get('instagram_login_enabled'))
    <div class="row">
      <button
        id="registration-with-instagram"
        class="btn social-button social-button-text social-button-pill social-button-shadow-bottom social-button-instagram social-register"
        data-network="instagram"
      >
        <i class="fa fa-instagram"></i>
        @lang('COM_CAJOBBOARD_REGISTRATION_INSTAGRAM')
      </button>
    </div>
  @endif
@show

{{--
  Create account with Twitter
--}}
@section('twitter')
  @if ($params->get('twitter_login_enabled'))
    <div class="row">
      <button
        id="registration-with-twitter"
        class="btn social-button social-button-text social-button-pill social-button-shadow-bottom social-button-twitter social-register"
        data-network="twitter"
      >
        <i class="fa fa-twitter"></i>
        @lang('COM_CAJOBBOARD_REGISTRATION_TWITTER')
      </button>
    </div>
  @endif
@show

{{--
  Register new user / social login dialog box
--}}
@section('register')
  @lang('COM_CAJOBBOARD_REGISTRATION_TOS_AND_PRIVACY_POLICY_STATEMENT', $terms_of_service, $privacy_policy)

  @yield('google')
  @yield('facebook')
  @yield('linkedin')
  @yield('instagram')
  @yield('twitter')

  <hr class="hr-text" data-content="@lang('COM_CAJOBBOARD_REGISTRATION_OR_SPACER')">
  @lang('COM_CAJOBBOARD_REGISTRATION_CREATE_ACCOUNT_INVITE')
  @yield('email')
@show
