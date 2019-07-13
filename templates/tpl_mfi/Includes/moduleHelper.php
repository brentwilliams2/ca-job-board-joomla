<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * Get count of all module positions to avoid calling methods on null objects
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

// no direct access
defined('_JEXEC') or die;

/*
 * These module positions will be required unconditionally on both HtmlDocument and
 * ErrorDocument pages, and so must check for whether the current page is an html or
 * error page and provide appropriate handling to always show something
 */
$this->requiredPositions = array(
  'breadcrumbs',
  'copyright',
  'login',
  'nav-component',
  'nav-footer',
  'nav-primary',
  'nav-secondary',
  'search-footer',
  'search-header',
  'shopping-cart',
  'social-icons',
  // system positions that don't have corresponding module positions defined
  'content-component-output',
  'content-message',
  'error-trace',
  'logo-footer',
  'logo-header'
);

/*
 * An associative array with template module positions and a module count for each position
 *
 * @var  array
 */
$this->moduleCount = array(
  'banner-bottom' => null,
  'banner-top' => null,
  'breadcrumbs' => null,
  'content-editor' => null,
  'content-info' => null,
  'content-left-sidebar' => null,
  'content-reactions' => null,
  'content-references' => null,
  'content-related' => null,
  'content-right-sidebar' => null,
  'content-share-reactions' => null,
  'content-social-share' => null,
  'content-sponsored' => null,
  'copyright' => null,
  'debug' => null,
  'feature' => null,
  'login' => null,
  'nav-component' => null,
  'nav-component-action' => null,
  'nav-footer' => null,
  'nav-primary' => null,
  'nav-secondary' => null,
  'search-footer' => null,
  'search-header' => null,
  'shopping-cart' => null,
  'showcase' => null,
  'social-icons' => null
);

/**
 * This helper method is to allow using the template to display error pages.
 *
 * The countModules() method isn't available on ErrorDocument objects. These
 * variables need to be used like so to avoid undefined variable errors:
 *
 * if (!$isErrorPage && !$isOfflinePage && $moduleCount['position-name'])
 */

if (!$this->isErrorPage)
{
  foreach ($this->moduleCount as $position => $count)
  {
    $this->moduleCount[$position] = $this->countModules($position);
  }
}
