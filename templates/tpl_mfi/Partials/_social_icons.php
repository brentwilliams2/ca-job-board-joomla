<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * Social Icons
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

<?php if ( in_array('social-icons', $this->moduleCount) && $this->moduleCount['social-icons'] ) : ?>

  <jdoc:include type="modules" name="social-icons" style="none" />

<?php else: // render static HTML for social-icons pages ?>

  <p>paste static html in social-icons > <?php echo $this->getTitle(); ?></p>

<?php endif; ?>
