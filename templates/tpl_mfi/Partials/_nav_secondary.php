<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * The smaller navigation menu at the top of the page, with "About Us",
 * "Files and Tools", and "Contact", and login/register and shopping cart modules
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

<?php if ( in_array('nav-secondary', $this->moduleCount) && $this->moduleCount['nav-secondary'] ) : ?>

  <jdoc:include type="modules" name="nav-secondary" style="none" />

<?php else: // render static HTML for error pages ?>

  <p>paste static html in nav-secondary</p>

<?php endif; ?>
