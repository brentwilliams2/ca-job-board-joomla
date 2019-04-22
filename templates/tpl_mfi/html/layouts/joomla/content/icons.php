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

  use \Joomla\CMS\HTML\HTMLHelper;

  // no direct access
  defined('_JEXEC') or die;

  $canEdit = $displayData['params']->get('access-edit');
?>

<div class="icons">
	<?php if (empty($displayData['print'])) : ?>

    <?php if ($canEdit || $displayData['params']->get('show_print_icon') || $displayData['params']->get('show_email_icon')) : ?>

			<div class="btn-group pull-right">

				<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#">
          <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
        </a>

				<ul class="dropdown-menu">

          <?php if ($displayData['params']->get('show_print_icon')) : ?>

            <li class="print-icon"> <?php echo HTMLHelper::_('icon.print_popup', $displayData['item'], $displayData['params']); ?> </li>

					<?php endif; ?>

          <?php if ($displayData['params']->get('show_email_icon')) : ?>

            <li class="email-icon"> <?php echo HTMLHelper::_('icon.email', $displayData['item'], $displayData['params']); ?> </li>

					<?php endif; ?>

          <?php if ($canEdit) : ?>

            <li class="edit-icon"> <?php echo HTMLHelper::_('icon.edit', $displayData['item'], $displayData['params']); ?> </li>

          <?php endif; ?>

				</ul>

      </div>

		<?php endif; ?>

  <?php else : ?>

		<div class="pull-right">
			<?php echo HTMLHelper::_('icon.print_screen', $displayData['item'], $displayData['params']); ?>
    </div>

	<?php endif; ?>
</div>
