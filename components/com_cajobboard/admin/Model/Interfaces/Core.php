<?php
/**
 * Admin model marker or tagging interface for models that implement a set of
 * core UCM table fields and associated behaviours
 *
 * @package   Calligraphic Job Board
 * @version   October 30, 2019
 * @author    Calligraphic, LLC http:www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http:www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model\Interfaces;

defined('_JEXEC') or die;

interface Core
{
  /*
    marker interface for models that have the following core UCM table fields:

    'access'
    'asset_id'
    'cat_id'
    'created_by'
    'created_on'
    'enabled'
    'locked_by'
    'locked_on'
    'modified_by'
    'modified_on'
    'note'
    'params'
    'publish_down'
    'publish_up'
    'slug'
  */
}
