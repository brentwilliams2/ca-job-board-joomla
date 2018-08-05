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
?>

@section('edit-view')
  <h1>$item variable in form.blade.php:</h1>
  <?php print_r($item); ?>
@stop
