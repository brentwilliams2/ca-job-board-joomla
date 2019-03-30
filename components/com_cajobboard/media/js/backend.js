/**
 * Backend Javascript
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

/* Joomla! jQuery is v1.12.4 */

/**
 * Register modules in this file with global onload handler
 */
jQuery(document).ready(function() {
  updateEmptySlug.init();
});

/**
 * Update the "slug" input field on admin forms if user hasn't set it and the title field (`name`) is modified
 *
 * @return  method  init  Initialize the module
 */
const updateEmptySlug = (function($) {
  /**
  * Store references to all DOM elements used in this module
  *
  * @param  object  elementRefs  References to all elements for this module
  */
  const elementRef = {
    nameInput: null,
    slugInput: null
  };

  /**
  * Central entry point to the module
  */
  const init = function() {
    // reference to "Title" input box in Common/edit.blade.php
    elementRef.nameInput = $('#name');

    // reference to "Alias" input box in Common/edit.blade.php
    elementRef.slugInput = $('#slug');

    if (isSlugUserGenerated()) return;

    bindEventListeners();
  };

  /**
  * All event listeners should be bound here
  */
  const bindEventListeners = function() {
    // add event listener to "Title" input box in Common/edit.blade.php
    elementRef.nameInput.click( function() { updateSlug(); } );
    elementRef.nameInput.keyup( function(key) {
      // ignore control characters from keyboard
      if (key.which !== 0 && !key.ctrlKey && !key.metaKey && !key.altKey) updateSlug();
    });

    // add event listener to "Alias" input box in Common/edit.blade.php
    elementRef.slugInput.click( function() { onSlugUpdate(); } );
    elementRef.slugInput.keyup( function(key) {
      // ignore control characters from keyboard
      if (key.which !== 0 && !key.ctrlKey && !key.metaKey && !key.altKey) onSlugUpdate();
    });
  };

  /**
  * Remove event listeners
  */
  const removeEventListeners = function() {
    // remove event listeners from "Title" input box in Common/edit.blade.php
    elementRef.nameInput.off('click keyup');

    // remove event listeners from "Alias" input box in Common/edit.blade.php
    elementRef.slugInput.off('click keyup');
  };

  /*
  * Update the slug/alias input box when text is entered into the name/title input box
  */
  const updateSlug = function() {
    slugValue = generateSlug();
    elementRef.slugInput.val(slugValue);
  };

  /*
  * Check if the user entered their own text into the slug/
  * alias input box, and remove event listeners if so
  */
  const onSlugUpdate = function() {
    if (isSlugUserGenerated()) removeEventListeners();
  };

  /*
  * Check whether the slug/alias data is user supplied or derived from the name/title input data
  *
  * @return  bool  Returns true if the user has modified the slug/alias input box text
  */
  const isSlugUserGenerated = function() {
    lowerCaseName = null;
    slugWithSpaces = null;

    nameValue = elementRef.nameInput.val();
    slugValue = elementRef.slugInput.val();

    // account for the possibility of the user having multiple sequential spaces in the title
    if (typeof nameValue !== 'undefined') lowerCaseName = nameValue.replace(/\s{1,}/g, ' ').toLowerCase();
    if (typeof slugValue !== 'undefined') slugWithSpaces = slugValue.replace(/-/g, ' ');

    if (lowerCaseName === slugWithSpaces) return false;

    return true;
  }

  /*
  * Create a slug with the data from the name/title input box text
  *
  * @return  bool  Returns the hyphenated slug/alias from the name/title input box text
  */
  const generateSlug = function() {
    nameValue = elementRef.nameInput.val();

    slugValue = null;

    if (typeof nameValue !== 'undefined') {
      slugValue = nameValue
        // replace spaces with a hyphen, collapsing multiple spaces
        .replace(/\s+/g, '-')
        // make the slug URI-safe
        .replace(/[^a-zA-Z0-9-]/g,'')
        .toLowerCase();
    }

    return slugValue;
  }

  return {
    init: init,
  };
})(jQuery);
