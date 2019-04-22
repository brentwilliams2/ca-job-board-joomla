<?php
  /**
   * Calligraphic Job Board Copyright Module
   *
   * This partial is used to display the component portion of a page for printing
   *
   * @package     Calligraphic Job Board
   *
   * @version     0.1 May 1, 2018
   * @author      Calligraphic, LLC http://www.calligraphic.design
   * @copyright   Copyright (C) 2018 Calligraphic, LLC, (C) 2016 freakout.be All rights reserved.
   * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
   *
   */

   // no direct access
   defined('_JEXEC') or die;

   use \Joomla\CMS\Factory;
   use \Joomla\CMS\Helper\ModuleHelper;
   use \Joomla\CMS\HTML\HTMLHelper;
   use \Joomla\CMS\Language\Text;

  $app = Factory::getApplication();

  $date = Factory::getDate();

  // get current year
  $year = HTMLHelper::_('date', $date, 'Y');

  // get parameters
  $siteName      = $app->get('sitename');
  $startYear     = $params->get('start_year', '');
  $showCopyright = $params->get('show_copyright', '');
  $showSitename  = $params->get('show_sitename', '1');

  // only add startyear if different
  if ($startYear && $startYear != $year)
  {
    $year = $startYear . ' - ' . $year;
  }

  // Create $copyright
  $copyright = "";

  if ($showCopyright == "show_symbol")
  {
    $copyright = Text::_('MOD_MFI_TEMPLATE_COPYRIGHT_SYMBOL') . " ";
  }

  if ($showCopyright == "show_text_symbol")
  {
    $copyright = Text::_('MOD_MFI_TEMPLATE_COPYRIGHT_TEXT') . " " . Text::_('MOD_MFI_TEMPLATE_COPYRIGHT_SYMBOL') . " ";
  }

  require ModuleHelper::getLayoutPath('mod_mfi_template_copyright', $params->get('layout', 'default'));
