<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * Show the copyright notice
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

<?php if ( in_array('copyright', $this->moduleCount) && $this->moduleCount['copyright'] ) : ?>

  <jdoc:include type="modules" name="copyright" style="none" />

<?php else: // render static HTML for error pages ?>

  <p>paste static html in copyright</p>

<?php endif; ?>
