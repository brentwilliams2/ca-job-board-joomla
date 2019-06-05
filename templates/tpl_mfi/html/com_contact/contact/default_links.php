<?php
/**
 * Multi Family Insiders Bootstrap v3 Template with Schema.org markup
 *
 * com_contact contact/default_links.php template partial override
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

  use \Joomla\CMS\Language\Text;
  use \Joomla\CMS\HTML\HTMLHelper;

  // no direct access
  defined('_JEXEC') or die;
?>

<?php if ($this->params->get('presentation_style') == 'sliders') : ?>
	<?php echo HTMLHelper::_('bootstrap.addSlide', 'slide-contact', Text::_('COM_CONTACT_LINKS'), 'display-links'); ?>
<?php endif; ?>

<?php if ($this->params->get('presentation_style') == 'tabs') : ?>
	<?php echo HTMLHelper::_('bootstrap.addTab', 'myTab', 'display-links', Text::_('COM_CONTACT_LINKS', true)); ?>
<?php endif; ?>

<?php if ($this->params->get('presentation_style') == 'plain'):?>
	<?php echo '<h3>' . Text::_('COM_CONTACT_LINKS') . '</h3>';  ?>
<?php endif; ?>

<div class="contact-links">
	<ul class="nav nav-tabs nav-stacked">
		<?php
		// Letters 'a' to 'e'
    foreach (range('a', 'e') as $char) :

			$link = $this->contact->params->get('link' . $char);
			$label = $this->contact->params->get('link' . $char . '_name');

			if (!$link) :
				continue;
			endif;

			// Add 'http://' if not present
			$link = (0 === strpos($link, 'http')) ? $link : 'http://' . $link;

			// If no label is present, take the link
			$label = ($label) ? $label : $link;
			?>

			<li>
				<a href="<?php echo $link; ?>" itemprop="url">
					<?php echo $label; ?>
				</a>
			</li>

		<?php endforeach; ?>
	</ul>
</div>

<?php if ($this->params->get('presentation_style') == 'sliders') : ?>
	<?php echo HTMLHelper::_('bootstrap.endSlide'); ?>
<?php endif; ?>

<?php if ($this->params->get('presentation_style') == 'tabs') : ?>
	<?php echo HTMLHelper::_('bootstrap.endTab'); ?>
<?php endif; ?>
