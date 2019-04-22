<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * The Search modules that displays in the footer of the site
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

<?php if ( in_array('search-footer', $this->moduleCount) && $this->moduleCount['search-footer'] ) : ?>

  <jdoc:include type="modules" name="search-footer" style="none" />

<?php else: // render static HTML for error pages ?>

    <p>paste static html in search-footer</p>

<?php endif; ?>
