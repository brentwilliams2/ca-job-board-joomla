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

  $doTask  = $displayData['doTask'];
  $class   = $displayData['class'];
  $text    = $displayData['text'];
  $name    = $displayData['name'];
  $onClose = $displayData['onClose'];
?>

<button
  onclick="<?php echo $doTask; ?>"
  class="btn btn-small"
  data-toggle="collapse"
  data-target="#collapse-<?php echo $name; ?>"<?php echo $onClose; ?>
>
	<i class="icon-cog"></i>
	<?php echo $text; ?>
</button>
