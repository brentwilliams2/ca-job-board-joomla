<?php
/**
 * Multi Family Insiders Bootstrap v3 Template
 *
 * Override of default menu module output with Bootstrap v3 stylings
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Menu Types:
 *
 *  -separator:
 *  -component:
 *  -heading: The
 *  -url: link to an external URI
 *
 * Menu item class properties:
 *
 * $item->id
 * $item->type
 * $item->params \JRegistry
 * $item->anchor_title
 * $item->anchor_css
 * $item->title
 * $item->deeper
 * $item->parent
 * $item->shallower
 * $item->level_diff
 * $item->menu_image
 * $item->menu_image_css
 */

  // no direct access
  defined('_JEXEC') or die;

  // You can set an id for the menu in the back-end module manager for the menu, otherwise no id
  $id = '';

  if ($tagId = $params->get('tag_id', ''))
  {
    $id = ' id="' . $tagId . '"';
  }
?>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <ul class="nav menu<?php echo $class_sfx; ?>"<?php echo $id; ?>>

      <?php foreach ($list as $i => &$item)
      {
        // Set the class for the menu item
        $class = 'item-' . $item->id;

        // Add 'default' class if this is the default menu item
        if ($item->id == $default_id)
        {
          $class .= ' default';
        }

        // Add 'current' class for targeting with CSS
        if ($item->id == $active_id || ($item->type === 'alias' && $item->params->get('aliasoptions') == $active_id)) // aliasoptions: "Menu Item to link to."
        {
          $class .= ' current';
        }

        if (in_array($item->id, $path))
        {
          $class .= ' active';
        }
        elseif ($item->type === 'alias')
        {
          $aliasToId = $item->params->get('aliasoptions');

          if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
          {
            $class .= ' active';
          }
          elseif (in_array($aliasToId, $path))
          {
            $class .= ' alias-parent-active';
          }
        }

        if ($item->type === 'separator')
        {
          $class .= ' divider';
        }

        if ($item->deeper)
        {
          $class .= ' dropdown';
        }

        if ($item->parent)
        {
          $class .= ' parent';
        }

        $class .= ' float-right';

        echo '<li class="' . $class . '">';

        switch ($item->type) :
          case 'separator':
          case 'component':
          case 'heading':
          case 'url':
            require JModuleHelper::getLayoutPath('mod_menu', 'default_' . $item->type);
            break;

          default:
            require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
            break;
        endswitch;

        // The next item is deeper.
        if ($item->deeper)
        {
          echo <<<EOT
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
  {$item->title}
  <span class="caret"></span>
</a>
<ul class="dropdown-menu">
EOT;
        }
        // The next item is shallower.
        elseif ($item->shallower)
        {
          echo '</li>';
          echo str_repeat('</ul></li>', $item->level_diff);
        }
        // The next item is on the same level.
        else
        {
          echo '</li>';
        }
      } ?>
    </ul>
  </div>
</nav>
