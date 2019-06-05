<?php
/**
 * Multi Family Insiders Bootstrap v3 Template with Schema.org markup
 *
 * com_privacy request/default.php template override
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

/** @var PrivacyViewRequest $this */

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidator');
HTMLHelper::_('formbehavior.chosen', 'select');
?>

<div class="request-form<?php echo $this->pageclass_sfx; ?>">

	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1>
				<?php echo $this->escape($this->params->get('page_heading')); ?>
			</h1>
		</div>
	<?php endif; ?>

	<?php if ($this->sendMailEnabled) : ?>

		<form action="<?php echo Route::_('index.php?option=com_privacy&task=request.submit'); ?>" method="post" class="form-validate">

			<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>

				<div class="form-group">
					<?php if (!empty($fieldset->label)) : ?>
						<label><?php echo Text::_($fieldset->label); ?></label>
					<?php endif; ?>

					<?php echo $this->form->renderFieldset($fieldset->name); ?>
				</div>

			<?php endforeach; ?>

			<div class="form-group">
        <button type="submit" class="btn btn-default validate">
          <?php echo Text::_('JSUBMIT'); ?>
        </button>
			</div>

			<?php echo HTMLHelper::_('form.token'); ?>

		</form>

	<?php else : ?>

		<div class="alert alert-warning">
			<p><?php echo Text::_('COM_PRIVACY_WARNING_CANNOT_CREATE_REQUEST_WHEN_SENDMAIL_DISABLED'); ?></p>
		</div>

	<?php endif; ?>

</div>
