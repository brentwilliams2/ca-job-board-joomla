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
  saveJobsButton.init();
  emailJob.init();
  reportJob.init();
  starRating.init();
});

// @TODO: Upvotes / Downvotes

/**
 * Bind all "Report Job" buttons to a single modal for registered users
 * and handle submitting to server via XHR
 *
 * @return  method  init  Initialize the report-a-job form module
 */
const reportJob = (function($) {
  /**
  * Store references to all DOM elements used in this module
  *
  * @param  object  elementRefs  References to all elements for this module
  */
  const elementRef = {
    reportJobModal: null,
    reportJobForm: null,
    reportJobTextBox: null,
    reportJobId: null
  };

  /**
  * Central entry point to the module
  */
  const init = function() {
    // reference to report-a-job modal
    elementRef.reportJobModal = $('#report-job-modal');
    // reference to form inside report-a-job modal
    elementRef.reportJobForm = $('#report-a-job-form');
    // reference to text box for job report
    elementRef.reportJobTextBox = elementRef.reportJobForm.find('#report-job-text-box');
    // reference to hidden input form element holding the job id, set from "Report Job" button on job listing
    elementRef.reportJobId = elementRef.reportJobForm.find('#report-job-id');

    bindEventListeners();
  };

  /**
  * All event listeners should be bound here
  */
  const bindEventListeners = function() {
    // set the form to initiate XHR request on submit
    elementRef.reportJobForm.submit( function(event) { reportJob(event); } );

    // handler for showing and hiding the report-a-job modal
    elementRef.reportJobModal.on( 'show.bs.modal', function(event) { showReportJobModal(event); } );
    elementRef.reportJobModal.on( 'hide.bs.modal', function() { hideReportJobModal(); } );
  };

  /**
   * Set focus on report job text box when modal is shown, and set the hidden input to the
   * job id of the button that triggered showing the email-a-job modal
   *
   * @param  string  event  The jQuery event trigger this method
   */
  const showReportJobModal= function (event) {
    // HTML5 autofocus has no effect in Bootstrap modals
    elementRef.reportJobTextBox.focus();

    // Button that triggered the modal
    var reportJobButton = $(event.relatedTarget);

    // Extract info from button's data-* attributes
    const jobId = reportJobButton.data('jobid');

    // modify hidden input with job id
    elementRef.reportJobId.val(jobId);
  };

  /**
   * Set the email-a-job hidden input for job id back to zero when the modal is hidden
   */
  const hideReportJobModal= function () {
    // restore hidden input with null job id
    elementRef.reportJobId.val(0);
  };
