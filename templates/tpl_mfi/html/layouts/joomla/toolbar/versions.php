<?php
/**
 * Multi Family Insiders Bootstrap v3 Template with Schema.org markup
 *
 * layouts joomla/toolbar/versions.php template override
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
?>

<a rel="{handler: 'iframe', size: {x: <?php echo $displayData['height']; ?>, y: <?php echo $displayData['width']; ?>}}"
	href="index.php?option=com_contenthistory&amp;view=history&amp;layout=modal&amp;tmpl=component&amp;item_id=<?php echo (int) $displayData['itemId']; ?>&amp;type_id=<?php echo $displayData['typeId']; ?>&amp;type_alias=<?php echo $displayData['typeAlias']; ?>&amp;<?php echo JSession::getFormToken(); ?>=1"
	title="<?php echo $displayData['title']; ?>"
  class="btn btn-default btn-sm modal_jform_contenthistory"
>
	<i class="fa fa-archive"></i>
  <?php echo $displayData['title']; ?>
</a>
