<?php
/**
 * Multi Family Insiders Bootstrap v3 Template with Schema.org markup
 *
 * mod_breadcrumbs default.php template override
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

	// Get rid of duplicated entries on trail including home page when using multilanguage
	for ($i = 0; $i < $count; $i++)
	{
		if ($i == 1 && !empty($list[$i]->link) && !empty($list[$i - 1]->link) && $list[$i]->link == $list[$i - 1]->link)
		{
			unset($list[$i]);
		}
  }

	// Find last and penultimate items in breadcrumbs list
	end($list);
  $last_item_key = key($list);

	prev($list);
	$penult_item_key = key($list);
?>

<ul class="semantic-breadcrumb-container" vocab="https://schema.org/" typeof="BreadcrumbList">

  <?php
    // Generate the trail
    foreach ($list as $key => $item) :

      // Make a link if not the last item in the breadcrumbs
      $show_last = $params->get('showLast', 1);

      if ($key != $last_item_key)
      {
        // Render all but last item - along with separator
        if (!empty($item->link))
        {
          echo '<li property="itemListElement" typeof="ListItem"><a class="pathway" property="item" typeof="WebPage" href="' . $item->link . '"><span property="name">' . $item->name . '</span></a></li>';
        }
        else
        {
          echo '<li property="itemListElement" typeof="ListItem"><span class="non-link-pathway" property="item" typeof="WebPage"><span property="name">' . $item->name . '</span></span></li>';
        }

        if (($key != $penult_item_key) || $show_last)
        {
          echo ' '.$separator.' ';
        }

      }
      elseif ($show_last)
      {
        // Render last item if reqd.
        echo '<li property="itemListElement" typeof="ListItem"><span class="last-crumb" property="item" typeof="WebPage"><span property="name">' . $item->name . '</span></span></li>';
      }

    endforeach; ?>

</ul>
