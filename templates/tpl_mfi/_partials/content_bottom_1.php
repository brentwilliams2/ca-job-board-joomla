<?php
/**
* Bottom 1 position in main content to include in template
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
     $this->countModules('user4')
  or $this->countModules('user5')
  or $this->countModules('user6')
) : 

// @TODO: change position names from userN to something better
// @TODO: change div class on jdoc includes from "block" to "row"
// @TODO: Shouldn't div class "main-content" have a conditional include so it
//        doesn't output if all 3 sub-blocks are empty?
// @TODO: Bootstrap template has class id="content-bottom" for Rocket id="bottommodules1"
?>
  <div class="main-content block1">
    <div id="bottommodules1" class="spacer<?php echo $bottommods1_width; ?>">
      <?php if ($this->countModules('user4')) : ?>
        <div class="block">
          <jdoc:include type="modules" name="user4" style="rounded" />
        </div>
      <?php endif; ?>

      <?php if ($this->countModules('user5')) : ?>
        <div class="block">
          <jdoc:include type="modules" name="user5" style="rounded" />
        </div>
      <?php endif; ?>

      <?php if ($this->countModules('user6')) : ?>
        <div class="block">
          <jdoc:include type="modules" name="user6" style="rounded" />
        </div>
      <?php endif; ?>

    </div>
  </div>
<?php endif;
