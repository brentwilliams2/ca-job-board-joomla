<?php
/**
 * Social Shares Module for Multi Family Insiders Bootstrap V3 Template
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC, (c) 2019 Steven Palmer All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

use \Joomla\CMS\Language\Text;
use \Joomla\CMS\HTML\HTMLHelper;

// no direct access
defined('_JEXEC') or die;
?>

<li>
  <?php if ($params->get('link_date')) : ?>
    <time datetime="<?php echo HTMLHelper::_('date', $item->created, 'c'); ?>" itemprop="dateCreated">
      <?php echo HTMLHelper::_('date', $item->created, Text::_('DATE_FORMAT_LC3')); ?>
    </time>
  <?php endif; ?>

  <a href="<?php echo $item->link; ?>">
    <?php echo $item->title; ?>
  </a>
</li>
