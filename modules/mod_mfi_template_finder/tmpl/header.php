<?php
 /**
 * Multi Family Insiders Template Search Module
 *
 * Template for search box in header
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC, (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

  use \Joomla\CMS\Factory;
  use \Joomla\CMS\Language\Text;
  use \Joomla\CMS\Router\Route;
  use \Joomla\CMS\HTML\HTMLHelper;

  defined('_JEXEC') or die;

  HTMLHelper::addIncludePath(JPATH_SITE . '/components/com_finder/helpers/html');

  // include Javascript for the search box
  include('script.php');
?>

<div class="finder">

  <span
    class="header-search-toggle-modal hasTooltip"
    type="button"
    title="<?php echo Text::_('MOD_MFI_TEMPLATE_FINDER_LABEL_SEARCH') ?>"
    data-toggle="modal"
    data-target="#header-modal-search"
  >
    <span class="header-search-icon icon-search"></span>
</span>

  <div class="modal fade" id="header-modal-search" tabindex="-1" role="dialog" aria-labelledby="search-box-modal">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <form
          id="mod-finder-searchform<?php echo $module->id; ?>"
          action="<?php echo Route::_($route); ?>"
          method="get"
          class="form-search"
          role="search"
        >

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>

          <div class="modal-body">

            <label id="form-search-input" class="form-search-input input-text-animation" for="mod-finder-searchword<?php echo $module->id; ?>">
              <input
                class="animation-input search-query input-medium"
                id="mod-finder-searchword<?php echo $module->id; ?>"
                name="q"
                placeholder="&nbsp;"
                type="text"
                value="<?php htmlspecialchars( Factory::getApplication()->input->get('q', '', 'string'), ENT_COMPAT, 'UTF-8'); ?>"
              />
              <span class="animation-label"><?php echo Text::_('MOD_MFI_TEMPLATE_FINDER_SEARCH_VALUE'); ?></span>
              <span class="animation-border"></span>
            </label>

            <div>
              <a class="advanced-search" href="<?php echo Route::_($route); ?>">
                <?php echo Text::_('MOD_MFI_TEMPLATE_FINDER_ADVANCED_SEARCH'); ?>
              </a>
            </div>

          </div>

          <div class="header-modal-search-footer modal-footer">

            <div>

              <button
                aria-label="Submit"
                class="btn btn-primary btn-sm submit pull-right"
                type="submit"
              >
                <?php echo Text::_('MOD_MFI_TEMPLATE_FINDER_LABEL_SUBMIT') ?>
              </button>

              <button
                aria-label="Close"
                class="btn btn-default btn-sm pull-right"
                data-dismiss="modal"
                type="button"
              >
                <?php echo Text::_('MOD_MFI_TEMPLATE_FINDER_LABEL_CLOSE'); ?>
              </button>

            </div>

            <?php echo modFinderHelper::getGetFields($route, (int) $params->get('set_itemid', 0)); ?>

          </div>
        </form>

      </div>
    </div>
  </div>

</div>
