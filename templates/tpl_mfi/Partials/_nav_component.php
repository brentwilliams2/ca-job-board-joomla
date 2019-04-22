<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * The View-specific navigation that shows menu items specific to a component, and
 * is assigned on menus only to views in that component (e.g. menu module displayed varies)
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

<?php if ( in_array('nav-component', $this->moduleCount) && $this->moduleCount['nav-component'] ) : ?>

  <jdoc:include type="modules" name="nav-component" style="none" />

<?php endif; ?>
