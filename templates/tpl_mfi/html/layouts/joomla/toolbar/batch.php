<?php
/**
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

  // no direct access
  defined('_JEXEC') or die;

  $title = $displayData['title'];
?>

<button data-toggle="modal" data-target="#collapseModal" class="btn btn-default btn-sm">
	<i class="fa fa-check-square-o" title="<?php echo $title; ?>"></i>
	<?php echo $title; ?>
</button>
