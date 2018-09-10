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

/**
 * Layout variables
 * ---------------------
 * 	$options         : (array)  Optional parameters
 * 	$label           : (string) The html code for the label (not required if $options['hiddenLabel'] is true)
 * 	$input           : (string) The input field html code
 */

  if (!empty($displayData['options']['showonEnabled']))
  {
    JHtml::_('jquery.framework');
    JHtml::_('script', 'jui/cms.js', false, true);
  }
?>

<div class="control-group <?php echo $displayData['options']['class']; ?>" <?php echo $displayData['options']['rel']; ?>>
	<?php if (empty($displayData['options']['hiddenLabel'])) : ?>
		<div class="control-label"><?php echo $displayData['label']; ?></div>
	<?php endif; ?>

	<div class="controls"><?php echo $displayData['input']; ?></div>
</div>
