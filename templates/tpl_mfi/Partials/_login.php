<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * Toggles between Login / Register and the username / avatar for logged in users
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

<?php if ( in_array('login', $this->moduleCount) && $this->moduleCount['login'] ) : ?>

  <jdoc:include type="modules" name="login" style="none" />

<?php else: // render static HTML for error pages ?>

  <span><a href="#" class="navbar-link">LOGIN</a> / <a href="#" class="navbar-link"">REGISTER</a></span>

<?php endif; ?>
