<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * The Search modules that displays in the footer of the site
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

<?php if ( in_array('search-footer', $this->moduleCount) && $this->moduleCount['search-footer'] ) : ?>

  <jdoc:include type="modules" name="search-footer" style="none" />

<?php else: // render static HTML for error pages ?>

  <div class="finder">
    <form id="mod-finder-searchform181" action="<?php echo Route::_('index.php?option=com_finder&view=search'); ?>" method="get" class="form-search" role="search">
      <span class="footer-search-icon icon-search"></span>
      <input class="footer-search-query search-query input-medium" id="mod-finder-searchword181" name="q" placeholder="Search ..." size="25" type="text" value="">
      <input type="hidden" name="option" value="com_finder"><input type="hidden" name="view" value="search"><input type="hidden" name="Itemid" value="">
    </form>
  </div>

<?php endif; ?>



