<?php
/**
 * Multi Family Insiders Bootstrap v3 Template with Schema.org markup
 *
 * layouts joomla/content/intro_image.php template override
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

  $params  = $displayData->params;
  $imgfloat = (empty($images->float_intro)) ? $params->get('float_intro') : $images->float_intro;
  $images = json_decode($displayData->images);
?>

<?php if (isset($images->image_intro) && !empty($images->image_intro)) : ?>

	<div class="pull-<?php echo htmlspecialchars($imgfloat); ?> item-image img-responsive">
    <img
      <?php $caption = ''; if ($images->image_intro_caption): ?>
        <?php	echo $caption = 'caption'. ' title="' . htmlspecialchars($images->image_intro_caption) . '"'; ?>
      <?php endif; ?>

      class="<?php echo $caption?> img-responsive"
      src="<?php echo htmlspecialchars($images->image_intro); ?>"
      alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>"
      itemprop="thumbnailUrl"
    >
  </div>

<?php endif; ?>
