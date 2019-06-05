<?php
/**
 * Multi Family Insiders Bootstrap v3 Template with Schema.org markup
 *
 * layouts joomla/content/info_block/parent_category.php template override
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

  use \Joomla\CMS\Language\Text;
  use \Joomla\CMS\Router\Route;

  // no direct access
  defined('_JEXEC') or die;
?>

<dd class="parent-category-name">

  <i class="fa fa-folder-open"></i>

  <?php $title = $this->escape($displayData['item']->parent_title); ?>

  <?php if ($displayData['params']->get('link_parent_category') && !empty($displayData['item']->parent_slug)) : ?>

    <?php $url = '<a href="' . Route::_(ContentHelperRoute::getCategoryRoute($displayData['item']->parent_slug)) . '" itemprop="genre">' . $title . '</a>'; ?>

    <?php echo Text::sprintf('COM_CONTENT_PARENT', $url); ?>

  <?php else : ?>

    <?php echo Text::sprintf('COM_CONTENT_PARENT', '<span itemprop="genre">' . $title . '</span>'); ?>

  <?php endif; ?>
</dd>
