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

  JHtml::_('behavior.framework');
?>

<fieldset class="<?php echo !empty($displayData->formclass) ? $displayData->formclass : 'form-horizontal'; ?>">
	<legend><?php echo $displayData->name ?></legend>

	<?php if (!empty($displayData->description)): ?>
		<p><?php echo $displayData->description; ?></p>
	<?php endif; ?>

	<?php
	$fieldsnames = explode(',', $displayData->fieldsname);
	foreach($fieldsnames as $fieldname)
	{
		foreach ($displayData->form->getFieldset($fieldname) as $field)
		{
			$classnames = 'control-group';
			$rel = '';
			$showon = $displayData->form->getFieldAttribute($field->fieldname, 'showon');
			if (!empty($showon))
			{
				JHtml::_('jquery.framework');
				JHtml::_('script', 'jui/cms.js', false, true);

				$id = $displayData->form->getFormControl();
				$showon = explode(':', $showon, 2);
				$classnames .= ' showon_' . implode(' showon_', explode(',', $showon[1]));
				$rel = ' rel="showon_' . $id . '['. $showon[0] . ']"';
			}
	?>
		<div class="<?php echo $classnames; ?> form-group"<?php echo $rel; ?>>
			<?php if (!isset($displayData->showlabel) || $displayData->showlabel): ?>
				<?php echo $field->label; ?>
			<?php endif; ?>
			<div class="form-control"><?php echo $field->input; ?></div>
		</div>
	<?php
		}
	}
?>
</fieldset>
