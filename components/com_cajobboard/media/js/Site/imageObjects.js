/**
 * Javascript for ImageObjects views
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
  starRating.init();
});

// @TODO: Using rater initializer in two places already (Reviews and JobPostings), refactor out

/**
 * Initialize rater.js star-rating module
 *
 * @return  method  init  Initialize the rating module
 */
const starRating = (function($) {
  /**
  * Store references to all DOM elements used in this module
  *
  * @param  object  elementRefs  References to all elements for this module
  */
  const elementRef = {
    ratingElements: null
  };

  /**
  * Options for star ratings
  */
  const options = {
    max_value: 5,
    step_size: 0.5
  };

  /**
  * Central entry point to the module
  */
  const init = function() {
    // reference to all elements that should have star rating applied
    elementRef.ratingElements = $('.rating');

    applyStarRatings();
  };

  /**
   * Set focus on report job text box when modal is shown, and set the hidden input to the
   * job id of the button that triggered showing the email-a-job modal
   *
   * @param  string  event  The jQuery event trigger this method
   */
  const applyStarRatings = function () {
    // HTML5 autofocus has no effect in Bootstrap modals
    elementRef.ratingElements.rate(options);
  };

  return {
    init: init,
  };
})(jQuery);
