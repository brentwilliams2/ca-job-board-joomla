<?php
/**
 * Admin Background Checks local variables template. This file is intended to be included into Background
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

$currentActionStatus = $item->getFieldValue('action_status', 'POTENTIAL');
