<?php
/**
* Bottom horizontal includes in template
*
* @package   Multi Family Insiders Template
* @version   0.1 May 1, 2018
* @author    Calligraphic, LLC http://www.calligraphic.design
* @copyright Copyright (C) 2018 Calligraphic, LLC
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/
// no direct access
defined( '_JEXEC' ) or die;

if (
     $this->countModules('user7')
  or $this->countModules('user8')
  or $this->countModules('user9')

// @TODO: change position name from "userN" to something like "bottom"
// @TODO: Should div id="bottom" container be wrapped in a conditional
//        so it doesn't output if all 3 sub positions are empty?

) : ?>
  <div id="bottom">

    <!-- from Bootstrap template, for each of the positions -->
    <div class="container">
      <div class="row">

    <div id="footermodules" class="spacer<?php echo $footermods_width; ?>">

      <?php if ($this->countModules('user7')) : ?>
        <div class="block">
          <jdoc:include type="modules" name="user7" style="rounded" />
        </div>
      <?php endif; ?>

      <?php if ($this->countModules('user8')) : ?>
        <div class="block">
          <jdoc:include type="modules" name="user8" style="rounded" />
        </div>
      <?php endif; ?>

      <?php if ($this->countModules('user9')) : ?>
        <div class="block">
          <jdoc:include type="modules" name="user9" style="rounded" />
        </div>
      <?php endif; ?>

      </div>
    </div>

    </div>
  </div>
<?php endif;
