<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * The Search module that displays in the header of the site
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

  // no direct access
  defined('_JEXEC') or die;
?>

<?php if ( in_array('search-header', $this->moduleCount) && $this->moduleCount['search-header'] ) : ?>

  <jdoc:include type="modules" name="search-header" style="none" />

<?php else: // render static HTML for error pages ?>

  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>

<?php endif; ?>
