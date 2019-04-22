<?php
/**
 * Multi Family Insiders Bootstrap V3 Template
 *
 * Site offline partial to show when site is in maintenance mode
 *
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

  /** @var \Joomla\CMS\Document\Document $this */

  include 'Includes/params.php';
  include 'Includes/moduleHelper.php';
?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>">
  <?php include 'Partials/_head.php'; ?>
  <?php include 'Partials/_offline.php'; ?>
</html>
