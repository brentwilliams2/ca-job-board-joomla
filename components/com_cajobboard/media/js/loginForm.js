/**
 * Login Form Javascript
 *
 * Handle switching between Registrations/register.blade.php and Persons/login_modal.blade.php
 * modal dialogs on user pressing "sign in" (register modal) or "create account" (login modal)
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

/*global $ jQuery*/

/**
 * Register modules in this file with global onload handler
 */
$(document).ready(function() {
  LoginForm.init();
});

// @TODO needs functionality here and in back-end to complete login process and
// redirect to current page, passing any state about what modal (save job, report job,
// email job) was open when this form hit and what job listing (id) it was triggered from

/**
 * Handle interaction on Register form
 *
 * @return  method  init  Initialize the register form module
 */
const LoginForm = (function($) {
  // state of email input box, to toggle password input box from hidden and enable
  // not validating email address until user tries to leave input box the first time
  let emailEdited = false;

  /**
  * Store references to all DOM elements used in this module
  *
  * @param  object  elementRefs  References to all elements for this module
  */
  const elementRef = {
    emailLoginForm: null,
    socialButtons: null,
    emailInput: null,
    passwordInput: null
  };

  /**
  * Central entry point to the module
  */
  const init = function() {
    // reference to the whole form
    elementRef.emailLoginForm = $('#email-login-form');

    // reference to all of the register-with-social-account buttons
    elementRef.socialButtons = $('.social-sign-in');

    elementRef.emailInput = $('#email-input');
    if (elementRef.emailInput.length === 0) throw new Error('loginForm/init method requires a form input with ID #email-or-username-login-input');

    elementRef.passwordInput = $('#registration-password-input');
    if (elementRef.passwordInput.length === 0) throw new Error('loginForm/init method requires a form input with ID #login-password-input');

    bindEventListeners();
  };

  /**
  * All event listeners should be bound here
  */
  const bindEventListeners = function() {
    // set the form to initiate XHR request on submit
    elementRef.emailLoginForm.submit( function(event) { login(event); } );

    // bind all of the login-with-social-account buttons to a handler
    elementRef.socialButtons.forEach( function(element) {
      element.click( function(event) { loginWithSocial(event); } );
      element.keyup( function(event) { if (event.keyCode == 13) loginWithSocial(event); } );
    });

    elementRef.emailInput.focusout( function() { setPasswordInputVisible(); } );
  };

  /**
   * Password box is initially hidden, make password box visible after user exits it the first time
   */
  const setPasswordInputVisible = function() {
    // enable state variable, and if not visible show password box
    if (emailEdited == false)
    {
      // show password box, initially hidden
      if (elementRef.passwordInput.hasClass('hidden')) elementRef.passwordInput.removeClass('hidden');

      emailEdited = true;
    }
  };

  /**
  * Login a user with email and password
  *
  * @return object  A jQuery element of the error message
  */
  const login = function (event) {
    event.preventDefault();

    $.ajax({
      type: 'post',
      url: '/index.php?controller=Person&task=Login',
      data: elementRef.emailLoginForm.serialize(),
      success: function() {
        // @TODO: do something on success of logging user in, this probably redirects?
      }
    });
  };

  /**
  * Login a user with a social account
  *
  * @return object  A jQuery element of the error message
  */
  const loginWithSocial = function (event) {
    event.preventDefault();

    $.ajax({
      type: 'post',
      // login with social account buttons should have a 'data-network' data attribute with the name of the social network
      url: '/index.php?controller=Person&task=LoginWithSocialAccount&network=' . event.target.dataset.network,
      success: function() {
        // @TODO do something on success of social login, this probably redirects?
      }
    });
  };

  return {
    init: init,
  };
})(jQuery);
