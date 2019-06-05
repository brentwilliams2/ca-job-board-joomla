<?php
/**
 * Multi Family Insiders Bootstrap v3 Template with Schema.org markup
 *
 * layouts joomla/content/info_block/publish_date.php template override
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

  // no direct access
  defined('_JEXEC') or die;
?>

<dd class="published">

  <i class="fa fa-calendar"></i>

  <time datetime="<?php echo JHtml::_('date', $displayData['item']->publish_up, 'c'); ?>" itemprop="datePublished">
    <?php echo Text::sprintf('COM_CONTENT_PUBLISHED_DATE_ON', JHtml::_('date', $displayData['item']->publish_up, Text::_('DATE_FORMAT_LC3'))); ?>
  </time>

</dd>
