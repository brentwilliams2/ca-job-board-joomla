<?php
/**
 * Admin model marker or tagging interface for models that implement a set of
 * social UCM table fields and associated behaviours
 *
 *
 * @package   Calligraphic Job Board
 * @version   October 30, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model\Interfaces;

// no direct access
defined('_JEXEC') or die;

interface Social
{
  /*
  
    marker interface for models that have the following core UCM table fields:

    'metadata'
    'metakey'
    'metadesc'
    'xreference'
  */
}
