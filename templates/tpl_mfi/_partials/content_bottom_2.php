<?php
/**
* Bottom 2 position in main content to include in template
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
     $this->countModules('advert1')
  or $this->countModules('advert2')
  or $this->countModules('advert3')

// See Notes in content_bottom_1
// @TODO: change position names from userN to something better
// @TODO: change div class on jdoc includes from "block" to "row"
// @TODO: Shouldn't div class "main-content" have a conditional include so it
//        doesn't output if all 3 sub-blocks are empty?
// @TODO: Bootstrap template has class id="content-bottom" for Rocket id="bottommodules2"

) : ?>
  <div class="main-content block2">
    <div class="block-surround">
      <div class="block-surround2">
        <div class="block-surround3">
          <div class="block-surround4">
            <div id="bottommodules2" class="spacer<?php echo $bottommods2_width; ?>">
              <?php if ($this->countModules('advert1')) : ?>
                <div class="block">
                  <jdoc:include type="modules" name="advert1" style="rounded" />
                </div>
              <?php endif; ?>

              <?php if ($this->countModules('advert2')) : ?>
                <div class="block">
                  <jdoc:include type="modules" name="advert2" style="rounded" />
                </div>
              <?php endif; ?>

              <?php if ($this->countModules('advert3')) : ?>
                <div class="block">
                  <jdoc:include type="modules" name="advert3" style="rounded" />
                </div>
              <?php endif; ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif;
