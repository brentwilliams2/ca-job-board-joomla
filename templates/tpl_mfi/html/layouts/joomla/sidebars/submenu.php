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
?>

<div id="sidebar">
	<div class="sidebar-nav">
		<?php if ($displayData->displayMenu) : ?>
      <ul id="submenu" class="nav nav-list">
        <?php foreach ($displayData->list as $item) :
          if (isset ($item[2]) && $item[2] == 1) : ?>
            <li class="active">
          <?php else : ?>
            <li>
          <?php endif; ?>

          <?php if ($displayData->hide) : ?>
            <a class="nolink"><?php echo $item[0]; ?></a>
          <?php else : ?>
            <?php if (strlen($item[1])) : ?>
              <a href="<?php echo JFilterOutput::ampReplace($item[1]); ?>"><?php echo $item[0]; ?></a>
            <?php else : ?>
              <?php echo $item[0]; ?>
            <?php endif; ?>
          <?php endif; ?>

          </li>
        <?php endforeach; ?>
      </ul>
		<?php endif; ?>

		<?php if ($displayData->displayMenu && $displayData->displayFilters) : ?>
		  <hr />
		<?php endif; ?>

		<?php if ($displayData->displayFilters) : ?>
      <div class="filter-select hidden-xs">
        <h4 class="page-header"><?php echo JText::_('JSEARCH_FILTER_LABEL');?></h4>

        <?php foreach ($displayData->filters as $filter) : ?>
          <label for="<?php echo $filter['name']; ?>" class="element-invisible">
            <?php echo $filter['label']; ?>
          </label>

          <select name="<?php echo $filter['name']; ?>" id="<?php echo $filter['name']; ?>" class="form-control small" onchange="this.form.submit()">
            <?php if (!$filter['noDefault']) : ?>
              <option value=""><?php echo $filter['label']; ?></option>
            <?php endif; ?>

            <?php echo $filter['options']; ?>
          </select>

          <hr class="hr-condensed" />
        <?php endforeach; ?>
      </div>
		<?php endif; ?>
	</div>
</div>
