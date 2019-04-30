<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * The Search module that displays in the header of the site
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

  use \Joomla\CMS\Router\Route;

  // no direct access
  defined('_JEXEC') or die;
?>

<?php if ( in_array('search-header', $this->moduleCount) && $this->moduleCount['search-header'] ) : ?>

  <jdoc:include type="modules" name="search-header" style="none" />

<?php else: // render static HTML for error pages ?>

  <li id="search-header-container" class="search-header-container pull-right">
    <div class="finder">
      <a href="<?php echo Route::_('index.php?option=com_finder'); ?>">
        <span class="header-search-toggle-modal">
          <span class="header-search-icon icon-search"></span>
        </span>
      </a>
    </div>
  </li>

<?php endif; ?>



