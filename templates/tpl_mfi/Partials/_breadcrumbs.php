<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * Breadcrumbs
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

<?php if ( in_array('breadcrumbs', $this->moduleCount) && $this->moduleCount['breadcrumbs'] ) : ?>

  <jdoc:include type="modules" name="breadcrumbs" style="none" />

<?php else: // render static HTML for error pages ?>

  <span>&#62; <?php echo $this->getTitle(); ?></span>

<?php endif; ?>
