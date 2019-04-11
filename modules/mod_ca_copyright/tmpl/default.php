<?php
  /**
   * Calligraphic Job Board Copyright Module
   *
   * This partial is used to display the component portion of a page for printing
   *
   * @package     Calligraphic Job Board
   *
   * @version     0.1 May 1, 2018
   * @author      Calligraphic, LLC http://www.calligraphic.design
   * @copyright   Copyright (C) 2018 Calligraphic, LLC, (C) 2016 freakout.be All rights reserved.
   * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
   *
   */

   // no direct access
   defined('_JEXEC') or die;
?>

<div class="<?php echo $moduleclass_sfx ?>">
  <?php echo $copyright; ?>
  <?php echo $year; ?>

  <?php if ($showSitename == 1):?>
    &nbsp;<?php echo $csiteName; ?>
  <?php endif;?>

  <?php if ($params -> get('freeform_text')):?>
    &nbsp;<?php echo $params -> get('freeform_text'); ?>
  <?php endif;?>
</div>

