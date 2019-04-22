<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

  use \Joomla\CMS\Language\Text;

  // no direct access
  defined('_JEXEC') or die;

  if ( !$this->isErrorPage )
  {
    $filename = $this->params->get('footer_logo_filename');
    $height = $this->params->get('footer_logo_height');
    $link = $this->params->get('footer_logo_link');
    $width = $this->params->get('footer_logo_width');
  }
  ?>

<?php if ( !$this->isErrorPage ) : ?>

  <a id="logo-footer" class="logo-footer" href="<?php echo $link; ?>">

    <img
      src="<?php echo $this->templatePath . '/images/mfi/' . $filename; ?>"
      style="width:<?php echo $width; ?>px; height:<?php echo $height; ?>px;"
      class="img-responsive"
      alt="<?php Text::_('TPL_MFI_LOGO_LABEL'); ?>"
    >

  </a>

<?php else: // render static HTML for error pages ?>

  <a id="logo-footer" class="logo-footer" href="index.php">

    <img
      src="<?php echo $this->templatePath . '/images/mfi/MFI_logo_white.svg'; ?>"
      class="img-responsive"
      alt="<?php Text::_('TPL_MFI_LOGO_LABEL'); ?>"
    >

    </a>

<?php endif; ?>
