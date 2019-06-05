<?php
/**
 * Multi Family Insiders Bootstrap v3 Template with Schema.org markup
 *
 * layouts joomla/editors/buttons/button.php template override
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

  use \Joomla\CMS\Uri\Uri;

  // no direct access
  defined('_JEXEC') or die;

  $button = $displayData;

  if ($button->get('name')) :
		$class    = ($button->get('class')) ? $button->get('class') : null;
		$class	 .= ($button->get('modal')) ? ' modal-button' : null;
		$href     = ($button->get('link')) ? ' href="' . Uri::base() . $button->get('link') . '"' : null;
		$onclick  = ($button->get('onclick')) ? ' onclick="' . $button->get('onclick') . '"' : ' onclick="IeCursorFix(); return false;"';
		$title    = ($button->get('title')) ? $button->get('title') : $button->get('text');
	?>

	<a class="<?php echo $class; ?>" title="<?php echo $title; ?>" <?php echo $href . $onclick; ?> rel="<?php echo $button->get('options'); ?>">
		<i class="fa fa-<?php echo $button->get('name'); ?>"></i>

    <?php echo $button->get('text'); ?>
	</a>

<?php endif;
