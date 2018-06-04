<?php
/**
* Header position includes for template
*
* @package   Multi Family Insiders Template
* @version   0.1 May 1, 2018
* @author    Calligraphic, LLC http://www.calligraphic.design
* @copyright Copyright (C) 2018 Calligraphic, LLC
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/
// no direct access
defined( '_JEXEC' ) or die;

// Should change logo source to use template parameter instead of hard-coded:
// echo $this->params->get('logo_file')
?>

<!-- Begin Header -->
<!-- classes for header from Bootstrap template:  "header header--fixed hide-from-print" -->
<header class="header" role="banner" id="header">

  <!--Logo -->
  <div id="brand">
    <a href="<?php echo $this->params->get('logo_link') ?>" class="nounder">
      <img style="
          width: <?php echo $this->params->get('logo_width') ?>px;
          height: <?php echo $this->params->get('logo_height') ?>px;"
        src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/blue/logo.png"
        alt="<?php echo $sitename ?>"
      />
    </a>
  </div>

  <!--Search Module -->
  <?php if ($this->countModules('search')) : ?>
    <div id="searchmod">
      <jdoc:include type="modules" name="search" style="xhtml" />
    </div>
  <?php endif; ?>

</header>
<!-- End Header -->
