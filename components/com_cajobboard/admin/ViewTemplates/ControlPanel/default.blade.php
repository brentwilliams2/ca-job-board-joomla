<?php
 /**
  * Admin Control Panel View Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // no direct access
  defined('_JEXEC') or die;
?>

<div class="row">
  <div class="span12">
    @include('admin:com_cajobboard/ControlPanel/header')
  </div>
</div>

<div class="row">
  <div class="span2">
    @include('admin:com_cajobboard/ControlPanel/sidebar')
  </div>

  <div class="span10">
    @include('admin:com_cajobboard/ControlPanel/mainPanel')
  </div>
</div>
