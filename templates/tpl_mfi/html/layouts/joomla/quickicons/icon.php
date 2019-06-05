<?php
/**
 * Multi Family Insiders Bootstrap v3 Template with Schema.org markup
 *
 * layouts joomla/quickicons/icon.php template override
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

  $id      = empty($displayData['id']) ? '' : (' id="' . $displayData['id'] . '"');
  $target  = empty($displayData['target']) ? '' : (' target="' . $displayData['target'] . '"');
  $onclick = empty($displayData['onclick']) ? '' : (' onclick="' . $displayData['onclick'] . '"');
  $title   = empty($displayData['title']) ? '' : (' title="' . $this->escape($displayData['title']) . '"');
  $text    = empty($displayData['text']) ? '' : ('<span>' . $displayData['text'] . '</span>')

?>

<div class="row"<?php echo $id; ?>>

	<div class="col-md-12">

		<a href="<?php echo $displayData['link']; ?>"<?php echo $target . $onclick . $title; ?>>

			<i class="icon-<?php echo $displayData['image']; ?>"></i>

      <?php echo $text; ?>

		</a>

	</div>

</div>
