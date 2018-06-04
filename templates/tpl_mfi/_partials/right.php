<?php
/**
* Right column includes in template
*
* @package   Multi Family Insiders Template
* @version   0.1 May 1, 2018
* @author    Calligraphic, LLC http://www.calligraphic.design
* @copyright Copyright (C) 2018 Calligraphic, LLC
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/
// no direct access
defined( '_JEXEC' ) or die;

// @TODO: See note on adding HTML5 / Bootstrap on Left Column

if (
  ($sidenav and $splitmenu_col=="rightcol")
  or $this->countModules('right')
  or $this->countModules('right2')
  or $this->countModules('right3')
  or $this->countModules('right4')
  or $this->countModules('right5')
) : ?>

  <!-- @TODO: move Rocket classes for id="right-column" to Bootstrap sidebar -->
  <div id="sidebar-2" class="col-sm-<?php  echo $rightcolgrid; ?>">
    <div class="padding">
      <div id="rightmodules" class="spacer<?php echo $rightmods_width; ?>">

    <!-- from Bootstrap template, for each of the positions -->
    <div class="container">
      <div class="row">

        <!-- POSITION: right2 -->
        <?php if ($this->countModules('right2')) : ?>
          <div class="block">
            <jdoc:include type="modules" name="right2" style="rounded" />
          </div>
        <?php endif; ?>

        <!-- POSITION: right3 -->
        <?php if ($this->countModules('right3')) : ?>
          <div class="block">
            <jdoc:include type="modules" name="right3" style="rounded" />
          </div>
        <?php endif; ?>
      </div>

      <!-- POSITION: right -->
      <jdoc:include type="modules" name="right" style="rounded" />

      <div id="rightmodules2" class="spacer<?php echo $rightmods2_width; ?>">

        <!-- POSITION: right4 -->
        <?php if ($this->countModules('right4')) : ?>
          <div class="block">
            <jdoc:include type="modules" name="right4" style="rounded" />
          </div>
        <?php endif; ?>

        <!-- POSITION: right5 -->
        <?php if ($this->countModules('right5')) : ?>
          <div class="block">
            <jdoc:include type="modules" name="right5" style="rounded" />
          </div>
        <?php endif; ?>

      </div>
    </div>

      </div>
    </div>
  </div>
<?php endif;
