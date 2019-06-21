<?php

/*
  This is the code to add a PDF button for Phoca PDF to com_content articles

  templates/your_template/html/layouts/com_content/icons.php

  Uses a plugin to actually generate the PDF

  Still need report views for the plugin to generate from
*/

use \Calligraphic\Cajobboard\Admin\Helper\Graph;

defined('JPATH_BASE') or die;

$canEdit = $displayData['params']->get('access-edit');

$phocaPDF = false;

if (JPluginHelper::isEnabled('phocapdf', 'content')) {
  include_once(JPATH_ADMINISTRATOR.'/components/com_phocapdf/helpers/phocapdf.php');

	$phocaPDF = PhocaPDFHelper::getPhocaPDFContentIcon($displayData['item'], $displayData['params']);
}

// Graph::getPieGraph();
?>

<div class="icons">

	<?php if (empty($displayData['print'])) : ?>

    <?php if ($canEdit || $displayData['params']->get('show_print_icon') || $displayData['params']->get('show_email_icon') || $phocaPDF) : ?>

			<div class="btn-group pull-right">

				<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" href="#">
          <span class="glyphicon glyphicon-cog"></span>
          <span class="caret"></span>
        </a>

				<ul class="dropdown-menu">

					<?php if ($displayData['params']->get('show_print_icon')) : ?>
						<li class="print-icon"> <?php echo JHtml::_('icon.print_popup', $displayData['item'], $displayData['params']); ?> </li>
          <?php endif; ?>

					<?php if ($displayData['params']->get('show_email_icon')) : ?>
						<li class="email-icon"> <?php echo JHtml::_('icon.email', $displayData['item'], $displayData['params']); ?> </li>
          <?php endif; ?>

					<?php if ($canEdit) : ?>
						<li class="edit-icon"> <?php echo JHtml::_('icon.edit', $displayData['item'], $displayData['params']); ?> </li>
          <?php endif; ?>

          <?php echo $phocaPDF; ?>

        </ul>

      </div>

		<?php endif; ?>

	<?php else : ?>

		<div class="pull-right">
			<?php echo JHtml::_('icon.print_screen', $displayData['item'], $displayData['params']); ?>
		</div>

	<?php endif; ?>
</div>
