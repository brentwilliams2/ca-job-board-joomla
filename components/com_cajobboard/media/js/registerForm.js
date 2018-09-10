/**
 * Register Modal Javascript
 *
 * Handle switching between Registrations/register.blade.php and Persons/login_modal.blade.php
 * modal dialogs on user pressing "sign in" (register modal) or "create account" (login modal)
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

jQuery(document).ready(function($) {
  var emailInput    = $('#email-input');
  var passwordInput = $('#registration-password');

  var invalidEmailMessage    = $('<span id="invalidEmail">' . $('#invalidEmailMessage').val() . '</span>');
  var invalidPasswordMessage = $('<span id="invalidEmail">' . $('#invalidEmailMessage').val() . '</span>');

  var emailEntered    = false;
  var passwordEntered = false;

  // Valid email test for presence of '@' symbol, at least one period, and a domain between 2 and 4 characters
  var validEmailRegExp = new RegExp(/^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i);

  emailInput.focusout(function() {
    // set flag to let
    emailEntered = true;

    // show password box, initially hidden
    if (passwordInput.hasClass("hidden"))

    if (validEmailRegExp.test(emailInput.val())) {
      // make email input box look nice since it's valid
      if (!emailInput.hasClass("has-success")) {
        if (emailInput.hasClass("has-error")) emailInput.removeClass("has-error");
        emailInput.addClass("has-success");

        // remove error message if present
        var emailInvalidEmailElement = $("#invalidEmailMessage");

        if (!invalidEmailMssgElement.length) invalidEmailMssgElement.remove();
      }
    } else {
      // email address is invalid, show error border on email input box
      if (emailInput.hasClass("has-success")) emailInput.removeClass("has-success");
      if (!emailInput.hasClass("has-error")) emailInput.addClass("has-error");

      // add error message if not already present
      if (!$("#invalidEmailMessage").length) emailInput.after(invalidEmailMessage);
    }
  });

  emailInput.keyup(function() {
    if (emailEntered && validEmailRegExp.test(emailInput.val())) {
      // make email input box look nice since it's valid
      if (!emailInput.hasClass("has-success")) {
        emailInput.addClass("has-success");

        // remove error message if present
        var emailInvalidEmailElement = $("#invalidEmailMessage");

        if (!invalidEmailMssgElement.length) invalidEmailMssgElement.remove();
      }
    } else {
      // email address is invalid, show error border on email input box
      if (!emailInput.hasClass("has-error")) emailInput.addClass("has-error");

      // add error message if not already present
      if (!$("#invalidEmailMessage").length) emailInput.after(invalidEmailMessage);
    }
  });

  var setElementValidionStatus = function(element, status, errorElement, errorMessage) {
    if (status === 'success')) {
      // remove error border if present
      if (element.hasClass("has-error")) element.removeClass("has-error");

      // set success border on
      element.addClass("has-success");

      if (errorElement.length) errorElement.remove();
    }

    if (status === 'error') {
      // email address is invalid, show error border on email input box
      if (element.hasClass("has-success")) element.removeClass("has-success");
      if (!element.hasClass("has-error")) element.addClass("has-error");

      // add error message if not already present
      if (!$("#invalidEmailMessage").length) element.after(invalidEmailMessage);
    }
  }

  // @TODO validate password
  // @TODO write / find small validation library
});
