<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * The footer navigation with links to "Jobs", "Community", "Events",
 * "Blogs", "About Us", "Files and Tools", and "Contact"
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

<?php if ( in_array('nav-footer', $this->moduleCount) && $this->moduleCount['nav-footer'] ) : ?>

  <jdoc:include type="modules" name="nav-footer" style="none" />

<?php else: // render static HTML for error pages ?>

  <li class="nav-footer-container"><a href="<?php echo Route::_('index.php?option=com_cajobboard&view=JobPostings'); ?>">Jobs</a></li>
  <li class="nav-footer-container"><a href="<?php echo Route::_('index.php?option=com_community&view=groups'); ?>">Community</a></li>
  <li class="nav-footer-container"><a href="<?php echo Route::_('index.php?option=com_community&view=events'); ?>">Events</a></li>
  <li class="nav-footer-container"><a href="<?php echo Route::_('index.php?option=com_publisher&view=publisher'); ?>">Blogs</a></li>
  <li class="nav-footer-container"><a href="<?php echo Route::_('index.php?option=com_content&view=article&id=4'); ?>">About Us</a></li>
  <li class="nav-footer-container"><a href="<?php echo Route::_('index.php?option=com_phocadownload&view=categories'); ?>">Files & Tools</a></li>
  <li class="nav-footer-container"><a href="<?php echo Route::_('index.php?option=com_content&view=article&id=8'); ?>">Contact</a></li>

<?php endif; ?>
