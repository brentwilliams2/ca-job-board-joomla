<?php
/**
 * Multi Family Insiders Bootstrap v3 Template with Schema.org markup
 *
 * com_users reset/complete.php template override
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

  use \Joomla\CMS\HTML\HTMLHelper;
  use \Joomla\CMS\Language\Text;
  use \Joomla\CMS\Router\Route;

  // no direct access
  defined('_JEXEC') or die;

  HTMLHelper::_('behavior.keepalive');
  HTMLHelper::_('behavior.formvalidation');
?>

<div class="reset-complete<?php echo $this->pageclass_sfx?> well-lg bg-white">

	<?php if ($this->params->get('show_page_heading')) : ?>
    <h1>
      <?php echo $this->escape($this->params->get('page_heading')); ?>
    </h1>
	<?php endif; ?>

	<form action="<?php echo Route::_('index.php?option=com_users&task=reset.complete'); ?>" method="post" class="form-validate form-horizontal">

		<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>

			<fieldset>
				<p class="alert alert-info">
					<span class="fa fa-info-circle"></span>
					<?php echo Text::_($fieldset->label); ?>
				</p>

				<?php foreach ($this->form->getFieldset($fieldset->name) as $name => $field) : ?>

					<div class="form-group">

						<div class="control-label col-sm-2">
							<?php echo $field->label; ?>
						</div>

						<div class="col-sm-10">
              <?php $required ='' ; if ($field->required){ $required =  'required'; } ?>
              <?php $field->__set('class', $field->getAttribute('class')." form-control $required"); ?>
              <?php echo $field->input;?>
						</div>

					</div>

				<?php endforeach; ?>

			</fieldset>

		<?php endforeach; ?>

		<div class="col-sm-offset-2">

			<button type="submit" class="validate btn btn-primary"><?php echo Text::_('JSUBMIT'); ?></button>

			<?php echo HTMLHelper::_('form.token'); ?>

		</div>
	</form>
</div>
