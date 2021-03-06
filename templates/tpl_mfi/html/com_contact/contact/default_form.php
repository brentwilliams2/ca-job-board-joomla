<?php
/**
 * Multi Family Insiders Bootstrap v3 Template with Schema.org markup
 *
 * com_contact contact/default_form.php template partial override
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
use \Joomla\CMS\Router\Route;
use \Joomla\CMS\HTML\HTMLHelper;

  // no direct access
  defined('_JEXEC') or die;

  HTMLHelper::_('behavior.keepalive');
  HTMLHelper::_('behavior.formvalidation');
?>

<?php if (isset($this->error)) : ?>
	<div class="contact-error">
		<?php echo $this->error; ?>
	</div>
<?php endif; ?>

<div class="contact-form">
	<form id="contact-form" action="<?php echo Route::_('index.php'); ?>" method="post" class="form-validate form-horizontal" role="form">
		<fieldset>

			<legend><?php echo Text::_('COM_CONTACT_FORM_LABEL'); ?></legend>

			<div class="form-group">
				<div class="col-sm-2 control-label">
					<?php echo $this->form->getLabel('contact_name'); ?>
				</div>
				<div class="col-sm-10">
					<?php echo $this->form->getInput('contact_name'); ?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-2 control-label">
					<?php echo $this->form->getLabel('contact_email'); ?>
				</div>
				<div class="col-sm-10">
					<?php echo $this->form->getInput('contact_email'); ?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-2 control-label">
					<?php echo $this->form->getLabel('contact_subject'); ?>
				</div>
				<div class="col-sm-10">
					<?php echo $this->form->getInput('contact_subject'); ?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-2 control-label">
					<?php echo $this->form->getLabel('contact_message'); ?>
				</div>
				<div class="col-sm-10">
					<?php echo $this->form->getInput('contact_message'); ?>
				</div>
			</div>

			<?php if ($this->params->get('show_email_copy')) : ?>
				<div class="form-group">
					<div class="col-sm-2 control-label">
						<?php echo $this->form->getLabel('contact_email_copy'); ?>
					</div>
					<div class="col-sm-10">
						<?php echo $this->form->getInput('contact_email_copy'); ?>
					</div>
				</div>
			<?php endif; ?>

			<?php //Dynamically load any additional fields from plugins. ?>
			<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>

				<?php if ($fieldset->name != 'contact') : ?>

					<?php $fields = $this->form->getFieldset($fieldset->name); ?>

					<?php foreach ($fields as $field) : ?>

						<div class="form-group">

							<?php if ($field->hidden) : ?>

									<?php echo $field->input; ?>

							<?php else: ?>

								<div class="col-sm-2 control-label">
									<?php echo $field->label; ?>

									<?php if (!$field->required && $field->type != "Spacer") : ?>
										<span class="optional"><?php echo Text::_('COM_CONTACT_OPTIONAL'); ?></span>
									<?php endif; ?>

								</div>

								<div class="col-sm-10">
									<?php echo $field->input; ?>
								</div>

							<?php endif; ?>

						</div>

					<?php endforeach; ?>

				<?php endif; ?>

			<?php endforeach; ?>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button class="btn btn-primary validate" type="submit"><?php echo Text::_('COM_CONTACT_CONTACT_SEND'); ?></button>

					<input type="hidden" name="option" value="com_contact" />
					<input type="hidden" name="task" value="contact.submit" />
					<input type="hidden" name="return" value="<?php echo $this->return_page; ?>" />
					<input type="hidden" name="id" value="<?php echo $this->contact->slug; ?>" />

					<?php echo HTMLHelper::_('form.token'); ?>
				</div>
			</div>
		</fieldset>
	</form>
</div>
