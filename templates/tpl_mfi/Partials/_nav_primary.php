<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * The main navigation menu at the top of the page, with "Jobs",
 * "Community", "Events", "Blogs", and "Discuss"
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

<?php if ( in_array('nav-primary', $this->moduleCount) && $this->moduleCount['nav-primary'] ) : ?>

  <jdoc:include type="modules" name="nav-primary" style="none" />

<?php else: // render static HTML for error pages ?>

  <li class="nav-secondary-container pull-right"><a href="<?php echo Route::_('index.php?option=com_content&view=article&id=8'); ?>">Contact</a></li>
  <li class="nav-secondary-container pull-right"><a href="<?php echo Route::_('index.php?option=com_phocadownload'); ?>">Files &amp; Tools</a></li>
  <li class="nav-secondary-container pull-right"><a href="<?php echo Route::_('index.php?option=com_content&view=article&id=4'); ?>">About Us</a></li>

<?php endif; ?>
