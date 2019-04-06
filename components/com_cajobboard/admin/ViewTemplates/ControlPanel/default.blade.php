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

  use \Calligraphic\Cajobboard\Admin\Helper\LinkBarHelper;
?>

@section('sidebar')
  <p></p>
@overwrite


@section('item')
  <h2>Answers</h2>
  <a href="http://joomla.test/administrator/index.php?option=com_cajobboard&view=Answers">
    Answers
  </a>
@overwrite


@section('footer')
  <p></p>
@overwrite

{{-- @TODO: Problem with toolbar being collapsed (not used for control panel), and overlapping menu --}}

<div class="clearfix"></div>

<div>
  <div class="row control-panel-body">
    <div class="span12">
      @yield('item')
    </div>
  </div>

  <div class="row">
    <div class="span12">
      @yield('footer')
    </div>
  </div>
</div>

