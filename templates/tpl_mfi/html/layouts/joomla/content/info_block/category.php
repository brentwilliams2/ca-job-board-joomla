<?php
/**
 * Multi Family Insiders Bootstrap v3 Template with Schema.org markup
 *
 * layouts joomla/content/info_block/category.php template override
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

<dd class="category-name">

  <i class="fa fa-folder-open"></i>

  <?php $title = $this->escape($displayData['item']->category_title); ?>

  <?php if ($displayData['params']->get('link_category') && $displayData['item']->catslug) : ?>

    <?php $url = '<a href="' . Route::_(ContentHelperRoute::getCategoryRoute($displayData['item']->catslug)) . '" itemprop="genre">' . $title . '</a>'; ?>

    <?php echo Text::sprintf('COM_CONTENT_CATEGORY', $url); ?>

  <?php else : ?>

    <?php echo Text::sprintf('COM_CONTENT_CATEGORY', '<span itemprop="genre">' . $title . '</span>'); ?>

  <?php endif; ?>

</dd>
