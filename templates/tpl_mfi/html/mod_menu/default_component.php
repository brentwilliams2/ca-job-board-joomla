<?php
/**
 * Multi Family Insiders Bootstrap v3 Template
 *
 * Override of default menu module output for component link with Bootstrap v3 stylings
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

  use \Joomla\CMS\HTML\HTMLHelper;
  use \Joomla\CMS\Filter\OutputFilter;

  // no direct access
  defined('_JEXEC') or die;

  $attributes = array();

  if ($item->anchor_title)
  {
    $attributes['title'] = $item->anchor_title;
  }

  if ($item->anchor_css)
  {
    $attributes['class'] = 'navbar-link ' . $item->anchor_css;
  }
  else
  {
    $attributes['class'] = 'navbar-link';
  }

  if ($item->anchor_rel)
  {
    $attributes['rel'] = $item->anchor_rel;
  }

  $linktype = $item->title;

  if ($item->menu_image)
  {
    if ($item->menu_image_css)
    {
      $image_attributes['class'] = $item->menu_image_css;
      $linktype = HTMLHelper::_('image', $item->menu_image, $item->title, $image_attributes);
    }
    else
    {
      $linktype = HTMLHelper::_('image', $item->menu_image, $item->title);
    }

    if ($item->params->get('menu_text', 1))
    {
      $linktype .= '<span class="image-title">' . $item->title . '</span>';
    }
  }

  if ($item->browserNav == 1)
  {
    $attributes['target'] = '_blank';
  }
  elseif ($item->browserNav == 2)
  {
    $options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes';

    $attributes['onclick'] = "window.open(this.href, 'targetWindow', '" . $options . "'); return false;";
  }

  echo HTMLHelper::_('link', OutputFilter::ampReplace(htmlspecialchars($item->flink, ENT_COMPAT, 'UTF-8', false)), $linktype, $attributes);
