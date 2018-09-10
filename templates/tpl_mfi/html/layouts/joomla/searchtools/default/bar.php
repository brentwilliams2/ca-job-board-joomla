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

  $data = $displayData;

  // Receive overridable options
  $data['options'] = !empty($data['options']) ? $data['options'] : array();

  if (is_array($data['options']))
  {
    $data['options'] = new JRegistry($data['options']);
  }

  // Options
  $filterButton = $data['options']->get('filterButton', true);
  $searchButton = $data['options']->get('searchButton', true);

  $filters = $data['view']->filterForm->getGroup('filter');
?>

<?php if (!empty($filters['filter_search'])) : ?>
	<?php if ($searchButton) : ?>

		<label for="filter_search" class="element-invisible">
			<?php echo JText::_('JSEARCH_FILTER'); ?>
		</label>

		<div class="btn-wrapper input-append">
			<?php echo $filters['filter_search']->input; ?>
			<button type="submit" class="btn btn-default hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_SUBMIT'); ?>">
				<i class="fa fa-search"></i>
			</button>
		</div>

		<?php if ($filterButton) : ?>
			<div class="btn-wrapper hidden-phone">
				<button type="button" class="btn btn-default hasTooltip js-stools-btn-filter" title="<?php echo JHtml::tooltipText('JSEARCH_TOOLS_DESC'); ?>">
					<?php echo JText::_('JSEARCH_TOOLS');?> <i class="fa fa-caret"></i>
				</button>
			</div>
		<?php endif; ?>

		<div class="btn-wrapper">
			<button type="button" class="btn btn-default hasTooltip js-stools-btn-clear" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_CLEAR'); ?>">
				<?php echo JText::_('JSEARCH_FILTER_CLEAR');?>
			</button>
		</div>

	<?php endif; ?>
<?php endif;
