<?php
 /**
  * Site Control Panel View Template
  *
  * @package   Calligraphic Job Board
  * @version   October 24, 2019
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2019 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // no direct access
  defined('_JEXEC') or die;
?>

<div class="row">
  @include('site:com_cajobboard/ControlPanel/header')
</div>

<div class="row">
  @include('site:com_cajobboard/ControlPanel/mainPanel')
</div>
