<?php
/**
* Feature position to include in template
*
* @package   Multi Family Insiders Template
* @version   0.1 May 1, 2018
* @author    Calligraphic, LLC http://www.calligraphic.design
* @copyright Copyright (C) 2018 Calligraphic, LLC
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/
// no direct access
defined( '_JEXEC' ) or die;

if($this->countModules('feature')) : ?>
  <!-- @TODO: rocket had "feature" as class, bootstrap as id -->
  <div id="feature" class="feature">
    <div class="container">
      <div class="row">
        <jdoc:include type="modules" name="feature" style="block" />
      </div>
    </div>
  </div>
<?php endif;
