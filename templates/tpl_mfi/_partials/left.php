<?php
/**
* Left column includes in template
*
* @package   Multi Family Insiders Template
* @version   0.1 May 1, 2018
* @author    Calligraphic, LLC http://www.calligraphic.design
* @copyright Copyright (C) 2018 Calligraphic, LLC
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/
// no direct access
defined( '_JEXEC' ) or die;
  
// @TODO: Use HTML5 / Bootstrap columns like sidebar, sidebar-nav, row, id="aside"

if (
      ($sidenav and $splitmenu_col=="leftcol") 
    or $this->countModules('left')
    or $this->countModules('left2')
    or $this->countModules('left3')
    or $this->countModules('left4')
    or $this->countModules('left5')
) : ?>

  <!-- @TODO: move Rocket classes for id="left-column" to Bootstrap sidebar -->
  <div id="sidebar" class="col-sm-<?php echo $leftcolgrid; ?>">
    <div class="padding">

      <div id="leftmodules" class="spacer<?php echo $leftmods_width; ?>">

        <!-- POSITION: left2 -->
        <?php if ($this->countModules('left2')) : ?>
          <div class="block">
            <jdoc:include type="modules" name="left2" style="rounded" />
          </div>
        <?php endif; ?>

        <!-- POSITION: left3 -->
        <?php if ($this->countModules('left3')) : ?>
          <div class="block">
            <jdoc:include type="modules" name="left3" style="rounded" />
          </div>
        <?php endif; ?>
      </div>

      <!-- POSITION: left2 -->
      <jdoc:include type="modules" name="left" style="rounded" />

      <div id="leftmodules2" class="spacer<?php echo $leftmods2_width; ?>">

        <!-- POSITION: left2 -->
        <?php if ($this->countModules('left4')) : ?>
          <div class="block">
            <jdoc:include type="modules" name="left4" style="rounded" />
          </div>
        <?php endif; ?>

        <!-- POSITION: left2 -->
        <?php if ($this->countModules('left5')) : ?>
          <div class="block">
            <jdoc:include type="modules" name="left5" style="rounded" />
          </div>
        <?php endif; ?>
      </div>

    </div>
  </div>
<?php endif;
