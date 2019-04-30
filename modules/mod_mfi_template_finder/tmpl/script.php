<?php
 /**
 * Multi Family Insiders Template Search Module
 *
 * Inline Javascript for Search box
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC, (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

  use \Joomla\CMS\Factory;
  use \Joomla\CMS\HTML\HTMLHelper;
  use \Joomla\CMS\Language\Text;
  use \Joomla\CMS\Router\Route;

  $script = "
  jQuery(document).ready(function() {
    var value, searchword = jQuery('#mod-finder-searchword" . $module->id . "');

      // Get the current value.
      value = searchword.val();

      // If the current value equals the default value, clear it.
      searchword.on('focus', function ()
      {
        var el = jQuery(this);

        if (el.val() === '" . Text::_('MOD_MFI_TEMPLATE_FINDER_SEARCH_VALUE', true) . "')
        {
          el.val('');
        }
      });

      // If the current value is empty, set the previous value.
      searchword.on('blur', function ()
      {
        var el = jQuery(this);

        if (!el.val())
        {
          el.val(value);
        }
      });

      jQuery('#mod-finder-searchform" . $module->id . "').on('submit', function (e)
      {
        e.stopPropagation();
        var advanced = jQuery('#mod-finder-advanced" . $module->id . "');

        // Disable select boxes with no value selected.
        if (advanced.length)
        {
          advanced.find('select').each(function (index, el)
          {
            var el = jQuery(el);

            if (!el.val())
            {
              el.attr('disabled', 'disabled');
            }
          });
        }
      });";

  /*
  * This segment of code sets up the autocompleter.
  */
  if ($params->get('show_autosuggest', 1))
  {
    HTMLHelper::_('script', 'jui/jquery.autocomplete.min.js', array('version' => 'auto', 'relative' => true));

    $script .= "
    var suggest = jQuery('#mod-finder-searchword" . $module->id . "').autocomplete({
      serviceUrl: '" . Route::_('index.php?option=com_finder&task=suggestions.suggest&format=json&tmpl=component') . "',
      paramName: 'q',
      minChars: 1,
      maxHeight: 400,
      width: 300,
      zIndex: 9999,
      deferRequestBy: 500
    });";
  }

  $script .= '});';

  Factory::getDocument()->addScriptDeclaration($script);
