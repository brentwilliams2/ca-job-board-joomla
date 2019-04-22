<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * The footer navigation with links to "Jobs", "Community", "Events",
 * "Blogs", "About Us", "Files and Tools", and "Contact"
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

<?php if ( in_array('nav-footer', $this->moduleCount) && $this->moduleCount['nav-footer'] ) : ?>

  <jdoc:include type="modules" name="nav-footer" style="none" />

<?php else: // render static HTML for error pages ?>

  <p>paste static html in nav-footer</p>

<?php endif; ?>
