<?php
/**
 * Multi Family Insiders Bootstrap v3 Template with Schema.org markup
 *
 * layouts joomla/toolbar/help.php template override
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
  $text   = $displayData['text'];
?>

<button onclick="<?php echo $doTask; ?>" rel="help" class="btn btn-default btn-sm">
	<span class="fa fa-question-circle"></span>
	<?php echo $text; ?>
</button>
