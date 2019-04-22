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

use \Joomla\CMS\Helper\ModuleHelper;

// no direct access
defined('_JEXEC') or die;
?>

<div id ="cwn-<?php echo $uniqueId; ?>" class="<?php echo $moduleclass_sfx; ?>">
  <div class="
    <?php echo $uikitPrefix; ?>-grid
    <?php echo $uikitPrefix; ?>-grid-match
    <?php echo $uikitPrefix; ?>-margin-bottom"
    data-<?php echo $uikitPrefix; ?>-grid="{gutter: <?php echo $marginsOuter; ?>}"
  >
    <?php
      $i = 0;

      foreach ($list as $item)
      {
        if ($i < $itemCount)
        {
          echo '<div class="'
          . $uikitPrefix .'-width-large-1-' .$columnsLarge . ' '
          . $uikitPrefix .'-width-medium-1-' .$columnsMedium . ' '
          . $uikitPrefix .'-width-small-1-' .$columnsSmall . '">';

          echo '<div class="' .$uikitPrefix . '-panel ' . $panelStyle . '">'
          . '<div class="' .$uikitPrefix . '-grid ' .$uikitPrefix . '-grid-' . $marginsInner . '" data-' .$uikitPrefix . '-grid-margin="">';

          require ModuleHelper::getLayoutPath('mod_mfi_template_social_share', 'default/_item');

          echo '</div></div></div>';
        }
        $i++;
      }
    ?>
  </div>

  <?php if ($displayLinks && $checkLinks)
    {
      if ($params->get('links_title'))
      {
        echo '<' . $linkHeading . ' class="">' . $linkText . '</' . $linkHeading . '>';
      }

      $f = 1;

      echo '<ul class="' .$uikitPrefix . '-list">';

      foreach ($list as $item)
      {
        if ($f > $params->get('count', 5))
        {
          require ModuleHelper::getLayoutPath('mod_mfi_template_social_share', 'default/_link');
        }

        $f++;
      }

      echo '</ul>';
    }

    if ($moreFrom)
    {
      echo '<p class="' .$uikitPrefix . '-small ' .$uikitPrefix . '-text-muted">' . $morefromText . ':';

      $new_array = array();

      foreach ($list as $cat)
      {
        if (!array_key_exists($cat->catid, $new_array))
        {
          $new_array[$cat->catid] = $cat;

          echo '<i class="' .$uikitPrefix . '-icon-folder-open ' .$uikitPrefix . '-margin-small-left"></i>'
          . ' <a href="' . $cat->catLink . '">' . $cat->category_title . '</a>';
        }
      }
      echo '</p>';
    }
  ?>
</div>
