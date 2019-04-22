<?php
/**
 * Social Links Module for Multi Family Insiders Template
 *
 * Get count of all module positions to avoid calling methods on null objects
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC, (C) joomla-monster.com 2017
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

use \Joomla\CMS\Factory;
use \Joomla\CMS\Helper\ModuleHelper;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Version;

// no direct access
defined('_JEXEC') or die;

$count = 0;
?>

<div id="<?php echo $id; ?>" class="mfi-social <?php echo $theme_class . ' ' . $mod_class_suffix; ?>">
	<div class="mfi-social-in view-<?php echo $view; ?>">
				<?php

				if( $intro ) {
					echo '<div class="mfi-intro">' . $intro . '</div>';
				}

				echo '<ul class="mfi-list items-' . $elements . '">';
					foreach($output_data as $item) {

						$count++;

						$url = ( !empty($item->url) ) ? $item->url : false;
						$image = ( !empty($item->image_file) ) ? $item->image_file : false;
						$font = ( !empty($item->icon) ) ? $item->icon : false;
						$name = ( !empty($item->name) ) ? $item->name : false;
						$alt = ( !empty($item->name) ) ? $item->name : '';
						$title = ( !empty($alt) ) ? 'aria-label="' . $alt . '" title="' . $alt . '"' : '';

						$class = ( !empty($name) ) ? preg_replace('/\W+/','',strtolower(strip_tags($name))) : '';

						if( $url && ( $image || $font || $name ) ) {

							if( $image ) {
								$icon = '<span class="mfi-img"><img src="' . $image . '" alt="' . $alt . '"></span>';
							} elseif( $font ) {
								$icon = '<span class="mfi-ico ' . $font . '" aria-hidden="true"></span>';
							} else {
								$icon = '';
							}

							if( $name && $view == 2 ) { //icon + text
								$link = $icon . '<span class="mfi-name">' . $name . '</span>';
							} elseif( $name && $view == 3 ) { //text
								$link = '<span class="mfi-name">' . $name . '</span>';
							} else { //icons
								$link = $icon;
							}

							echo '<li class="mfi-item item-' . $count . ' ' . $class . '"><a class="mfi-link" href="' . $url . '" target="' . $target . '" ' . $title . '>' . $link . '</a></li>';

						}

					}
				echo '</ul>';

				?>
	</div>
</div>
