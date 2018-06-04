<?php
/**
* Top content includes in template
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

<div class="main-content block">
  <!-- Begin Center Column -->
  <!-- @TODO: Merge Rocket main element with Bootstrap content-top element -->
  <!-- @TODO: Shouldn't <main> contain all content (content_main, content_bottom_n, etc.)? -->
  <main id="content" role="main" class="<?php echo $span; ?>"> <!-- Original had id="center-column" -->
    <div class="padding">

  <!-- Bootstrap template -->
  <div id="content-top">
    <div class="row">

      <!-- newsflash -->
      <?php if ($this->countModules('newsflash')) : ?>
        <div id="rokmininews">
          <jdoc:include type="modules" name="newsflash" style="xhtml" />
        </div>
      <?php endif; ?>

    </div>
  </div>

    </div>
  </main>
</div>
