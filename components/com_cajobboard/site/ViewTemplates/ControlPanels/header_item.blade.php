<?php
 /**
  * Site Control Panel Header Item View Template
  *
  * @package   Calligraphic Job Board
  * @version   October 24, 2019
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2019 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  */

  // no direct access
  defined('_JEXEC') or die;

  $formattedCount = number_format($count);
?>

<div class="col-xs-4 col-md-2 tile-stats-count">
  <span class="count-top">
    {{-- @TODO: <i class="icon-{{ $icon }}"> </i> --}}
    <div>{{{ $title }}}</div>
  </span>

  <div class="count blue">
    @if ($isCurrency)
      $
    @endif
    {{{ $formattedCount }}}
  </div>

  <span class="count-bottom">
    @if ($increaseOrDecrease == 'increase')
      <i class="green">
        <i class="icon-arrow-up-3"></i>
    @elseif ($increaseOrDecrease == 'decrease')
      <i class="red">
        <i class="icon-arrow-down-3"></i>
    @endif
      {{ $percent }}%
    </i>
    @lang('COM_CAJOBBOARD_TITLE_CONTROLPANELS_FROM_LAST_WEEK')
  </span>
</div>
