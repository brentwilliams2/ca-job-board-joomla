<?php
/**
 * Site Job Posting local variables template. This file is intended to be included into Job Posting
 * Blade templates to provide convenient local variables in the template function's scope.
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

// no direct access
defined('_JEXEC') or die;

use \Joomla\CMS\Language\Text;

$category = $item->getFieldValue('category');
$categoryPlaceholder = Text::sprintf('COM_CAJOBBOARD_CATEGORY_EDIT_PLACEHOLDER', $humanViewNameSingular);

$url = $item->getFieldValue('url');
$urlPlaceholder = Text::sprintf('COM_CAJOBBOARD_URL_EDIT_PLACEHOLDER', $humanViewNameSingular);