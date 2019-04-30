<?php
 /**
  * Answers Site List View Template
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

@section('header')
  <h4>Answers</h4>
@show

@section('sidebar')
  <p></p>
@show

@section('item')
  <div class="container-fluid answers-list">
    @each('site:com_cajobboard/Answers/default_item', $this->items, 'item', 'text|COM_CAJOBBOARD_ANSWERS_NO_ANSWERS_FOUND')
  </div>
@show

@section('footer')
  <p></p>
@show
