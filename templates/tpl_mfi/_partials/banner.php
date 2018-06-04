<?php
/**
* Top banner position includes in template
*
* @package   Multi Family Insiders Template
* @version   0.1 May 1, 2018
* @author    Calligraphic, LLC http://www.calligraphic.design
* @copyright Copyright (C) 2018 Calligraphic, LLC
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/
// no direct access
defined( '_JEXEC' ) or die;

if ($this->countModules('banner')) : ?>
  <div id="top-banner">
    <jdoc:include type="modules" name="banner" style="xhtml" />
  </div>
<?php endif;
