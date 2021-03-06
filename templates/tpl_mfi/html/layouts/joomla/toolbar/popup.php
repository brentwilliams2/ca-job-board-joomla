<?php
/**
 * Multi Family Insiders Bootstrap v3 Template with Schema.org markup
 *
 * layouts joomla/toolbar/popup.php template override
 *
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

  $doTask = $displayData['doTask'];
  $class  = $displayData['class'];
  $text   = $displayData['text'];
  $name   = $displayData['name'];
?>

<button
  onclick="<?php echo $doTask; ?>"
  class="btn btn-default btn-sm modal"
  data-toggle="modal"
  data-target="#modal-<?php echo $name; ?>"
>
	<i class="<?php echo $class; ?>"></i>
	<?php echo $text; ?>
</button>
