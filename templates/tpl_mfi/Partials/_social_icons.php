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

  <a href="#" class="fb" title="Join us on Facebook"><img src="<?php echo $this->templatePath; ?>/images/facebook.png" alt="Facebook" height="24" width="24"></a>
  <a href="#" class="tw" title="Join us on Twitter"><img src="<?php echo $this->templatePath; ?>/images/twitter.png" alt="Twitter" height="24" width="24"></a>
  <a href="#" class="in" title="Join us on Linked In"><img src="<?php echo $this->templatePath; ?>/images/linkedin.png" alt="Linked In" height="24" width="24"></a>
  <a href="#" class="insta" title="Join us on Instagram"><img src="<?php echo $this->templatePath; ?>/images/instagram.png" alt="Instagram" height="24" width="24"></a>

<?php endif; ?>
