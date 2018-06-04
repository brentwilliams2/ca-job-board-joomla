<?php
/**
* Top horizontal menu bar includes for template
*
* @package   Multi Family Insiders Template
* @version   0.1 May 1, 2018
* @author    Calligraphic, LLC http://www.calligraphic.design
* @copyright Copyright (C) 2018 Calligraphic, LLC
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/
// no direct access
defined( '_JEXEC' ) or die;
?>
<!-- Begin Horizontal Menu -->
<!-- @TODO: fix menu. Original template used id "horiz-menu", "sub-menu" -->
<nav class="navigation" role="navigation">
  <div class="navbar pull-left">
    <a class="btn btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
      <span class="element-invisible"><?php echo JTEXT::_('TPL_MFI_TOGGLE_MENU'); ?></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>
  </div>
  <div class="nav-collapse">
    <jdoc:include type="modules" name="position-1" style="none" />
  </div>
</nav>
<!-- End Horizontal Menu -->

<!-- @TODO: Merge this with above -->
<!-- Nav from Bootstrap template -->
<div id="navigation">
  <div class="navbar navbar-default">
    <div class="container">

      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>

      <div class="navbar-collapse collapse">
        <?php if ($this->countModules('navigation')) : ?>
          <nav class="navigation">
            <jdoc:include type="modules" name="navigation" style="none" />
          </nav>
        <?php endif; ?>
      </div>

    </div>
  </div>
</div>
