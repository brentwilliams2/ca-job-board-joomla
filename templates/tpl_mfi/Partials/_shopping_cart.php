<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * Show a shopping cart icon in the top navigation menu row
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

<?php if ( in_array('shopping-cart', $this->moduleCount) && $this->moduleCount['shopping-cart'] ) : ?>

  <jdoc:include type="modules" name="shopping-cart" style="none" />

<?php else: // render static HTML for error pages ?>

  <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>

<?php endif; ?>
