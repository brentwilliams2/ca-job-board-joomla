<?php
/**
* Bottom Menu to include in template
*
* @package   Multi Family Insiders Template
* @version   0.1 May 1, 2018
* @author    Calligraphic, LLC http://www.calligraphic.design
* @copyright Copyright (C) 2018 Calligraphic, LLC
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/
// no direct access
defined( '_JEXEC' ) or die;

if ($this->countModules('bottom')) : ?>
  <div id="bottom-menu">
    <jdoc:include type="modules" name="bottom" style="xhtml" />
  </div>
<?php endif;

// Bootstrap template version:
?>
<!-- menu slide -->
<?php  if($this->countModules('panelnav')): ?>
  <div id="panelnav">
    <jdoc:include type="modules" name="panelnav" style="none" />
  </div><!-- end panelnav -->
<?php  endif;// end panelnav  ?>
