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
  saveJobsButton.init();
  emailJob.init();
});

// HANDLERS FOR SINGLETON FORMS / MODALS WITH COLLECTIONS OF ELEMENTS ("Save Job", "Email Job",
// and "Report Job" buttons on every job posting in list view / job posting in item view)

// @TODO: Need state mechanism for when guest user chooses "Save Job", "Email Job", or "Report Job" and
// is redirected back to the page after login. The modal they initially chose should open if "Email Job"
// or "Report Job" button was pushed, or the job should be saved if "Save Job" button was pushed and the
// UI updated with "Saved" button on job listing.

/**
 * Handle "Save Jobs" button interaction on Job Postings list and item views for registered users:
 *
 * 1. Save job to back-end via XHR when button pushed
 * 2. Change button to "Saved" state
 *
 * @return  method  init  Initialize the save jobs form module
 */
const saveJobsButton = (function($) {
  /**
  * Store references to all DOM elements used in this module
  *
  * @param  object  elementRefs  References to all elements for this module
  */
  const elementRef = {
    saveJobButtons: null
  };

  /**
  * Central entry point to the module
  */
  const init = function() {
    elementRef.saveJobButtons = $('#job-posting-list').find('.registered-save-job-button');

    // If no save job buttons on page, no reason to continue
    if (elementRef.saveJobButtons.length === 0) return;

    bindEventListeners();
  };

  /**
  * All event listeners should be bound here
  */
  const bindEventListeners = function() {
    elementRef.saveJobButtons.forEach(function(button) {
      // Capture all digits from end of the string to the dash. The ? makes the .+
      // non-greedy, so it will match characters up to when the digits (\d) start to match.
      const buttonID = /.+?(\d{1,})/.exec(button.attr('id'));

      button.click( function() { saveJob(buttonID); } );
      button.keyup( function(event) { if (event.keyCode == 13) saveJob(buttonID); } );
    });
  };

  /**
   * Change the save jobs button status to saved
   */
  const saveJob = function(buttonID) {
    // buttonID is same as job ID
    $.post(
      '/JobPostings/index.php?task=saveJob&id=' + buttonID
    )
      .done(function(responseText) {
        if (responseText.status === 'success') {
          setButtonToSaved(buttonID);
        }
        if (responseText.status === 'error') {
          throw new Error('Error status in saveJob XHR, server response: ' + responseText.message);
        }
      })
      .fail(function(jqXHR, textStatus) {
        throw new Error('Fail handler in saveJob XHR, server response: ' + textStatus);
      });
  };

  /**
   * Change the save jobs button status to saved
   */
  const setButtonToSaved = function(buttonID) {
    // hide "Save Job" button
    $('#registered-save-job-button-' + buttonID).addClass('hidden');

    // show "Saved" button
    $('#job-saved-button-' + buttonID).removeClass('hidden');
  };

  return {
    init: init,
  };
})(jQuery);


/**
 * Bind all "Email Job" buttons to a single modal for registered users,
 * validate email input and handle submitting to server via XHR
 *
 * @return  method  init  Initialize the email-a-job form module
 */
const emailJob = (function($) {
  // state of email input box, allow not validating email address until
  // user tries to leave input box the first time
  let emailEdited = false;

  /**
  * Store references to all DOM elements used in this module
  *
  * @param  object  elementRefs  References to all elements for this module
  */
  const elementRef = {
    emailJobModal: null,
    emailJobForm: null,
    sendEmailInputBox: null,
    emailJobId: null
  };

  /**
  * Central entry point to the module
  */
  const init = function() {
    // reference to email-a-job modal
    elementRef.emailJobModal = $('#email-a-job-modal');
    // reference to form inside email-a-job modal
    elementRef.emailJobForm = $('#email-a-job-form');
    // email input box
    elementRef.sendEmailInputBox = elementRef.emailJobForm.find('#send-email-input-box');
    // reference to hidden input form element holding the job id, set from "Email Job" button on job listing
    elementRef.emailJobId = elementRef.emailJobForm.find('#email-job-id');

    bindEventListeners();
  };

  /**
  * All event listeners should be bound here
  */
  const bindEventListeners = function() {
    // set the form to initiate XHR request on submit
    elementRef.emailJobForm.submit( function(event) { sendJobToEmail(event); } );

    // handler for showing and hiding the email-a-job modal
    elementRef.emailJobModal.on( 'show.bs.modal', function(event) { showEmailJobModal(event); } );
    elementRef.emailJobModal.on( 'hide.bs.modal', function() { hideEmailJobModal(); } );

    // validate email address
    const emailListeners = function(event) { checkEmail(elementRef.emailInput.val(), event); };
    elementRef.sendEmailInputBox.focusout( function(event) { emailListeners(event); } );
    elementRef.sendEmailInputBox.click( function(event) { emailListeners(event); } );
    elementRef.sendEmailInputBox.keyup( function(event) { emailListeners(event); } );
  };

  /**
   * Set focus on email input box when modal is shown, and set the hidden input to the
   * job id of the button that triggered showing the email-a-job modal
   *
   * @param  string  event  The jQuery event trigger this method
   */
  const showEmailJobModal= function (event) {
    // HTML5 autofocus has no effect in Bootstrap modals
    elementRef.sendEmailInputBox.focus();

    // Button that triggered the modal
    var emailJobButton = $(event.relatedTarget);

    // Extract info from button's data-* attributes
    const jobId = emailJobButton.data('jobid');

    // modify hidden input with job id
    elementRef.emailJobId.val(jobId);
  };

  /**
   * Set the email-a-job hidden input for job id back to zero when the modal is hidden
   */
  const hideEmailJobModal= function () {
    // restore hidden input with null job id
    elementRef.emailJobId.val(0);
  };

  // @TODO: duplicating the checkEmail and binding events to email input box here and in registrationForm.js

  /**
   * Check if email is valid, and if not return error message element to add to DOM
   *
   * @param  string  email  The email address to validate
   */
  const checkEmail = function(email, event) {
    // don't validate email until user has left input box for first time
    if (!event.target === 'focusout' && !emailEdited) return;

    emailEdited = true;

    // validateEmail() returns false if valid email, or text string with error message if invalid
    const isValid = validationHelper.validateEmail(email);

    if (!isValid) {
      // make email input box look nice since it's valid
      validationUI.setSuccess(elementRef.emailInput);

    } else {
      // email address is invalid, show error border on email input box
      validationUI.setFailure(elementRef.emailInput, getErrorMessageElement(isValid + 'Message'));
    }
  };

  // @TODO: duplicating the getErrorMessageElement method here and in registrationForm.js

  /**
  * Assemble an HTML string for the error message, for use with the jQuery() constructor
  *
  * @return string  A string containing the HTML of the error message element
  */
  const getErrorMessageElement = function(errorMessage) {
    return $('<span class="validation-error">' + $('#' + errorMessage).val() + '</span>');
  };

  /**
  * Send a job to a user's email address
  *
  * @return object
  */
  const sendJobToEmail = function (event) {
    event.preventDefault();

    $.ajax({
      type: 'post',
      url: '/index.php?controller=JobPosting&task=sendJobToEmail',
      data: elementRef.emailLoginForm.serialize(),
      success: function() {
        // @TODO: do something on success of sending job to email to server
      }
    });
  };

  return {
    init: init,
  };
})(jQuery);
