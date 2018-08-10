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

  // no direct access
  defined('_JEXEC') or die;

  $items = $this->getItems();
?>

@section('header')
    <h1>This is the browse view header</h1>
@show

@section('sidebar')
  <p>This is the browse view sidebar</p>
@show

@section('item')
  @foreach ($items as $item)
    @include('site:com_cajobboard/JobPostings/default_item', array('item' => $item))
  @endforeach
@show

@section('footer')
  <p>This is the browse view footer</p>
@show


