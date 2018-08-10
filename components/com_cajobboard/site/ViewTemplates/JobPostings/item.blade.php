<?php
 /**
  * Job Postings Edit View Template
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

  $item = $this->getItem();

  // @TODO: Need Database field for employer's requisition / job number and EEO statement
?>

@section('header')
    <h1>This is the item view header</h1>
@show

@section('sidebar')
  <p>This is the item view sidebar</p>
@show

@section('item')
  <h1></h1><?php echo $item->title ?></h1>
@show

@section('footer')
  <p>This is the item view footer</p>
@show
