<?php
/**
* Footer includes in template
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

<!-- from Bootstrap template, for each of the positions -->
<div class="container">
  <div class="row">

<footer class="footer" role="contentinfo" id="footer">
  <div class="footer-left">
    <div class="footer-right">

      <a href="#top" id="back-top">
        <?php echo JText::_('TPL_MFI_BACKTOTOP'); ?>
      </a>

      <!-- Bootstrap template version of back-to-top -->
      <a href="#" class="back-to-top">Back to Top</a>

      <div class="footer-mod">
        <jdoc:include type="modules" name="footer" style="xhtml" />
      </div>
    </div>
  </div>

  </div>
</div>
  
</footer>
