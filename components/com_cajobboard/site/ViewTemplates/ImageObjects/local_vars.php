<?php
/**
 * Site Image Objects local variables template. This file is intended to be included into Background
 * Check Blade templates to provide convenient local variables in the template function's scope.
 *
 * @package   Calligraphic Job Board
 * @version   October 24, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

// no direct access
defined('_JEXEC') or die;

$params = $item->getFieldValue( $item->getFieldAlias('params') );

// Padding to add to width of image, for comparing against bootstrap media query setpoints
$imagePadding = $params->get('image-padding-for-setpoints');

// Get configuration option for system width of images
$displaySizes = array(
  'full-size' => $item->width                     + $imagePadding,
  'large'     => $params->get('large-width')      + $imagePadding,
  'medium'    => $params->get('medium-width')     + $imagePadding,
  'small'     => $params->get('small-width')      + $imagePadding,
  'thumbnail' => $params->get('thumbnail-width')  + $imagePadding
);

// Bootstrap media query setpoints
$screen_xs_max  = $params->get('bootstrap-media-query-sm-min') - 1 . 'px';

// Small screen / tablet
$screen_sm_min = $params->get('bootstrap-media-query-sm-min') . 'px';
$screen_sm_max = $params->get('bootstrap-media-query-md-min') - 1 . 'px';

// Medium screen / desktop
$screen_md_min = $params->get('bootstrap-media-query-md-min') . 'px';
$screen_md_max = $params->get('bootstrap-media-query-lg-min') - 1 . 'px';

// Large screen / wide desktop
$screen_lg_min = $params->get('bootstrap-media-query-lrg-min') . 'px';

$resolvedImages = array(
  'screen_xs' => null,
  'screen_sm' => null,
  'screen_md' => null,
  'screen_lg' => null,
  'default' => null
);
