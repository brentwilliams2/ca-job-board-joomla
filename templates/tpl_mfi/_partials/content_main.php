<?php
/**
* Main content includes in template
*
* @package   Multi Family Insiders Template
* @version   0.1 May 1, 2018
* @author    Calligraphic, LLC http://www.calligraphic.design
* @copyright Copyright (C) 2018 Calligraphic, LLC
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*/
// no direct access
defined( '_JEXEC' ) or die;

// @TODO: Should front-page-show-or-hide apply to all content sections:
// content_top, content_bottom, etc.?

// Front page message module output show or hide
$app = JFactory::getApplication();
$menu = $app->getMenu();

if ($frontpageshow){ ?>

  <!-- show on all pages -->
  <div id="main-box">

    <!-- message -->
    <jdoc:include type="message" />

    <!-- component -->
    <jdoc:include type="component" />

  </div>

<?php } else { 
  if ($menu->getActive() !== $menu->getDefault()) {
?>
    <!-- show on all pages but the default page -->
    <div id="main-box">
      <!-- component -->
      <jdoc:include type="component" />
    </div>

<?php }}
