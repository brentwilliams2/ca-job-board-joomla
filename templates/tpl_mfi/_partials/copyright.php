<?php
/**
* Bottom copyright information to include in template
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

<p>
  &copy; <?php echo date('Y'); ?> <?php echo $sitename; ?>
</p>


<!-- From Boostrap template -->
<?php  if($this->countModules('copy')) : ?>
  <div id="copy"  class="well">
    <div class="container">
      <div class="row">
      <jdoc:include type="modules" name="copy" style="block" />
      </div>
    </div>
  </div>
<?php  endif; ?>