<?php
/**
 * Multi Family Insiders Bootstrap v3 Template
 *
 * Override of default menu module output with Bootstrap v3 stylings for Secondary Navitation
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

// no direct access
defined('_JEXEC') or die;

// Reverse the menu item order since 'pull-right' class is applied
$list = array_reverse($list);

foreach ($list as $i => &$item)
{
  // Set the class for the menu item
  $class = 'item-' . $item->id;

  // Add 'default' class if this is the default menu item
  if ($item->id == $default_id)
  {
    $class .= ' default';
  }

  // Add 'current' class for targeting with CSS
  if ($item->id == $active_id)
  {
    $class .= ' current';
  }

  echo '<li class="nav-secondary-container ' . $class . ' pull-right">';

  $attributes = array();

  if ($item->anchor_title)
  {
    $attributes['title'] = $item->anchor_title;
  }

  if ($item->anchor_css)
  {
    $attributes['class'] = $item->anchor_css;
  }

  if ($item->anchor_rel)
  {
    $attributes['rel'] = $item->anchor_rel;
  }

  $linktype = $item->title;

  echo JHtml::_('link', JFilterOutput::ampReplace(htmlspecialchars($item->flink, ENT_COMPAT, 'UTF-8', false)), $linktype, $attributes);

  echo '</li>';
}
