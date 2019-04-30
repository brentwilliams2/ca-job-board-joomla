<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * The smaller navigation menu at the top of the page, with "About Us",
 * "Files and Tools", and "Contact", and login/register and shopping cart modules
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

<?php if ( in_array('nav-secondary', $this->moduleCount) && $this->moduleCount['nav-secondary'] ) : ?>

  <jdoc:include type="modules" name="nav-secondary" style="none" />

<?php else: // render static HTML for error pages ?>

  <li class="nav-primary-container pull-right"><a href="<?php echo Route::_('index.php?option=com_kunena&view=home'); ?>">Discuss</a></li>
  <li class="nav-primary-container pull-right"><a href="<?php echo Route::_('index.php?option=com_publisher&view=publications'); ?>">Blogs</a></li>
  <li class="nav-primary-container pull-right"><a href="<?php echo Route::_('index.php?option=com_community&view=events'); ?>">Events</a></li>
  <li class="nav-primary-container pull-right"><a href="<?php echo Route::_('index.php?option=com_community&view=frontpage'); ?>">Community</a></li>
  <li class="nav-primary-container pull-right"><a href="<?php echo Route::_('index.php?option=com_cajobboard&view=JobPostings'); ?>">Jobs</a></li>

<?php endif; ?>
