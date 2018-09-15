/**
 * Register Form Javascript
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

/*global $ validationHelper validationUI*/

/**
 * Register modules in this file with global onload handler
 */
$(document).ready(function() {
  RegisterForm.init();
});

// @TODO needs functionality here and in back-end to complete registration process and
// redirect to current page, passing any state about what modal (save job, report job,
// email job) was open when this form hit and what job listing (id) it was triggered from

/**
 * Handle interaction on Register form
 *
 * @return  method  init  Initialize the register form module
 */
const RegisterForm = (function($) {
  // state of email input box, to toggle password input box from hidden and enable
  // not validating email address until user tries to leave input box the first time
  let emailEdited = false;

  // state of password input box to enable not validating password until user
  // tries to leave input box the first time
  let passwordEdited = false;

  // Parameter values for password validity checks
  const passwordParams = {};

  /**
  * Store references to all DOM elements used in this module
  *
  * @param  object  elementRefs  References to all elements for this module
  */
  const elementRef = {
    emailRegisterForm: null,
    socialButtons: null,
    emailInput: null,
    passwordInput: null
  };

  /**
  * Stores all parameters for this module
  *
  * @param  object  params  The parameters for this module
  */
  const params = {
    emailEntered: null,
    passwordEntered: null
  };

  /**
  * Central entry point to the module
  */
  const init = function() {
    // reference to the whole form
    elementRef.emailRegisterForm = $('#email-registration-form');

    // reference to all of the register-with-social-account buttons
    elementRef.socialButtons = $('.social-register');

    elementRef.emailInput = $('#email-input');
    if (elementRef.emailInput.length === 0) throw new Error('registerForm/init method requires a form input with ID #email-input');

    elementRef.passwordInput = $('#registration-password-input');
    if (elementRef.passwordInput.length === 0) throw new Error('registerForm/init method requires a form input with ID #registration-password-input');

    bindEventListeners();
  };

  /**
  * All event listeners should be bound here
  */
  const bindEventListeners = function() {
    // set the form to initiate XHR request on submit
    elementRef.emailRegisterForm.submit( function(event) { register(event); } );

    // bind all of the register-with-social-account buttons to a handler
    elementRef.socialButtons.forEach( function(element) {
      element.click( function(event) { registerWithSocial(event) } );
      element.keyup( function(event) { if (event.keyCode == 13) registerWithSocial(event); } );
    });

    // event listeners for email input box
    const emailListeners = function(event) { checkEmail(elementRef.emailInput.val(), event) };
    elementRef.emailInput.focusout( function(event) { emailListeners(event); } );
    elementRef.emailInput.click( function(event) { emailListeners(event); } );
    elementRef.emailInput.keyup( function(event) { emailListeners(event); } );

    // even listeners for password input box
    const passwordListeners = function(event) { checkPassword(elementRef.passwordInput.val(), event); };
    elementRef.passwordInput.focusout( function(event) { passwordListeners(event); } );
    elementRef.passwordInput.click( function(event) { passwordListeners(event); } );
    elementRef.passwordInput.keyup( function(event) { passwordListeners(event); } );
  };

  // @TODO: duplicating the checkEmail and binding events to email input box here and in jobPostings.js

  /**
   * Check if email is valid, and if not return error message element to add to DOM
   *
   * @param  string  email  The email address to validate
   */
  const checkEmail = function(email, event) {
    // don't validate email until user has left input box for first time
    if (!event.target === 'focusout' && !emailEdited) return;

    // enable state variable, and if not visible show password box
    if (event.target === 'focusout' && !emailEdited)
    {
      // show password box, initially hidden
      if (elementRef.passwordInput.hasClass('hidden')) elementRef.passwordInput.removeClass('hidden');

      emailEdited = true;
    }

    // validateEmail() returns false if valid email, or text string with error message if invalid
    const isValid = validationHelper.validateEmail(email);

    if (!isValid) {
      // make email input box look nice since it's valid
      validationUI.setSuccess(elementRef.emailInput);
      // store valid email address
      params.emailEntered = email;
    } else {
      // email address is invalid, show error border on email input box
      validationUI.setFailure(elementRef.emailInput, getErrorMessageElement(isValid + 'Message'));
    }
  };

  /**
  * Check if password is valid, and if not return error message element to add to DOM
  *
  * @param  string  password  The password to validate
  * @param  object  params    An object setting validation parameters
  *
  * @return  bool|object  True if the password is valid, or a JQuery DOM object with the error message
  */
  const checkPassword = function(password, event) {
    // don't validate password until user has left input box for first time
    if (!event.target === 'focusout' && !passwordEdited) return;

    // enable state variable
    if (event.target === 'focusout' && !passwordEdited) passwordEdited = true;

    // Initialize password validation parameters if not done yet
    if (Object.getOwnPropertyNames(passwordParams).length === 0) {
      passwordParams.minimumPasswordLength =    $('#passwordLength').val();
      passwordParams.minimumPasswordUppercase = $('#passwordUppercase').val();
      passwordParams.minimumPasswordIntegers =  $('#passwordIntegers').val();
      passwordParams.minimumPasswordSymbols =   $('#passwordSymbols').val();
    }

    // returns false if valid password, or text string with error message if invalid
    const isValid = validationHelper.validatePassword(elementRef.passwordInput.val(), passwordParams);

    if (!isValid) {
      // make password input box look nice since it's valid
      validationUI.setSuccess(elementRef.passwordInput);
      // store valid password
      params.passwordEntered = password;

    } else {
      // password is invalid, show error border on password input box
      validationUI.setFailure(elementRef.passwordInput, getErrorMessageElement(isValid + 'Message'));
    }
  };

  // @TODO: duplicating the getErrorMessageElement() method here and in jobPostings.js

  /**
  * Assemble an HTML string for the error message, for use with the JQuery() constructor
  *
  * @return string  A string containing the HTML of the error message element
  */
  const getErrorMessageElement = function(errorMessage) {
    return $('<span class="validation-error">' + $('#' + errorMessage).val() + '</span>');
  };

  /**
  * Register a user with email and password
  *
  * @return object  A JQuery element of the error message
  */
  const register = function (event) {
    event.preventDefault();

    $.ajax({
      type: 'post',
      url: '/index.php?controller=Registration&task=Register',
      data: elementRef.emailRegisterForm.serialize(),
      success: function(results) {
        // do something on success
      }
    });
  };

  /**
  * Register a user with a social account
  *
  * @return object  A JQuery element of the error message
  */
  const registerWithSocial = function (event) {
    event.preventDefault();

    $.ajax({
      type: 'post',
      // register with social account buttons should have a 'data-network' data attribute with the name of the social network
      url: '/index.php?controller=Registration&task=RegisterWithSocialAccount&network=' . event.target.dataset.network,
      success: function(results) {
        // do something on success
      }
    });
  };

  return {
    init: init,
  };
})(JQuery);
