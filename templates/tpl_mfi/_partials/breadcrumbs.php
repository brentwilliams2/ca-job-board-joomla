<?php
/**
* Breadcrumb position to include in template
*
* @package   Multi Family Insiders Template
* @version   0.1 May 1, 2018
* @author    Calligraphic, LLC http://www.calligraphic.design
* @copyright Copyright (C) 2018 Calligraphic, LLC
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/
// no direct access
defined( '_JEXEC' ) or die;

// @TODO: was id="pathway"
if($show_breadcrumbs == "true" && $this->countModules('breadcrumbs')) : ?>
  <div id="breadcrumbs">
    <div class="container">
      <div class="row">
        <jdoc:include type="modules" name="breadcrumbs" style="block" />
      </div>
    </div>
  </div>
<?php endif;
