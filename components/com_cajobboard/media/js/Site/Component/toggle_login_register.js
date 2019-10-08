/**
 * Javascript for Job Postings views
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

/*global $ jQuery validationHelper validationUI*/

/**
 * Register modules in this file with global onload handler
 */
jQuery(document).ready(function() {
  toggleLoginRegister.init();
});

// SINGLETON FORMS / MODALS

/**
 * Toggle between singleton login and registration forms on the "save job" button modal for guest users
 *
 * @return  method  init  Initialize the toggle login-or-register form module
 */
const toggleLoginRegister = (function($) {
  /**
  * Store references to all DOM elements used in this module
  *
  * @param  object  elementRefs  References to all elements for this module
  */
  const elementRef = {
    registerToggle: null,
    loginToggle: null,
    registerForm: null,
    loginForm: null
  };

  /**
  * Central entry point to the module
  */
  const init = function() {
    // reference to "Already have a job board account? sign in" link in JobPostings/default.blade.php
    elementRef.registerToggle = $('#toggle-to-login').find('.login-toggle');

    // reference to "Don't have a job board account? sign up" link in JobPostings/default.blade.php
    elementRef.loginToggle = $('#toggle-to-register hidden').find('.register-toggle');

    // reference to Registrations/register.blade.php include in JobPostings/default.blade.php
    elementRef.registerForm = $('#save-job-registration-form');

    // reference to Persons/login.blade.php include in JobPostings/default.blade.php
    elementRef.loginForm = $('#save-job-login-form');

    bindEventListeners();
  };

  /**
  * All event listeners should be bound here
  */
  const bindEventListeners = function() {
    // add event listener to "Already have a job board account? sign in" on registration screen
    elementRef.registerToggle.click( function() { toggleTo('login'); } );
    elementRef.registerToggle.keyup( function(event) { if (event.keyCode == 13) toggleTo('login'); } );

    // add event listener to "Don't have a job board account? sign up" on login screen
    elementRef.loginToggle.click( function() { toggleTo('register'); } );
    elementRef.loginToggle.keyup( function(event) { if (event.keyCode == 13) toggleTo('register'); } );
  };

  const toggleTo = function(state) {
    switch (state) {
    case 'login':
      elementRef.registerForm.addClass('hidden');
      elementRef.loginForm.removeClass('hidden');
      break;

    case 'registration':
      elementRef.loginForm.addClass('hidden');
      elementRef.registerForm.removeClass('hidden');
      break;

    default:
      throw new Error('Error in toggleTo method of jobPostings/toggleLoginRegister, invalid state parameter passed:' + state);
    }
  };

  return {
    init: init,
  };
})(jQuery);
