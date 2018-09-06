<?php
 /**
  * Job Postings Browse View Template
  *
  * @package   Calligraphic Job Board
  * @version   0.1 May 1, 2018
  * @author    Calligraphic, LLC http://www.calligraphic.design
  * @copyright Copyright (C) 2018 Calligraphic, LLC
  * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
  *
  */

  // Framework classes
  use FOF30\Utils\FEFHelper\BrowseView;
  use FOF30\Utils\SelectOptions;
  use JUri;
  use JLog;

  // no direct access
  defined('_JEXEC') or die;

  $items = $this->getItems();
?>

@section('header')
  <h1></h1>
@show

@section('sidebar')
  <p></p>
@show

@section('item')
  <div class="container-fluid">
    @each('site:com_cajobboard/JobPostings/default_item', $items, 'item', 'text|COM_CAJOBBOARD_JOB_POSTINGS_NO_JOB_POSTS_FOUND')
  </div>
@show

@section('footer')
  <p></p>
@show


