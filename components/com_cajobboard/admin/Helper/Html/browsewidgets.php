<?php
/**
 * Custom Joomla! HTMLHelper class for admin browse view controls
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Usage in Blade templates:
 *     @jhtml('helper.browseWidgets.methodName', parameter1, ...)
 *
 * These are based on the Akeeba FEF (front-end framework) helperrs included in FOF with revised HTML output
 */

// Can't namespace since this class is used through Joomla's autoloader and JHtml system

use FOF30\Utils\ArrayHelper;

abstract class HelperBrowseWidgets
{
	/**
	 * Method to create a clickable icon to change the state of an item
	 *
	 * @param   mixed    $value         Either the scalar value or an object (for backward compatibility, deprecated)
	 * @param   integer  $i             The index
	 * @param   string   $prefix        An optional prefix for the task
	 *
	 * @return  string
	 *
	 * @since   1.0
	 */
	public static function published($value, $i, $prefix = '')
	{
		if (is_object($value))
		{
			$value = $value->published;
		}

    $task = $value ? 'unpublish' : 'publish';

    $alt = $value ? JText::_('JPUBLISHED') : JText::_('JUNPUBLISHED');

    $icon = $value ? 'icon-publish' : 'icon-unpublish';

    $action = $value ? JText::_('JLIB_HTML_UNPUBLISH_ITEM') : JText::_('JLIB_HTML_PUBLISH_ITEM');

    // @TODO: Event handler for this isn't returning and updating the published status, maybe not including correct library like Chozen?
    $html = <<<EOT
<a
  class="btn btn-micro hasTooltip"
  href="javascript:void(0);"
  onclick="return listItemTask('cb', 'tags.publish')"
  title=""
  data-original-title="$action"
>
  <span class="$icon" aria-hidden="true"></span>
</a>
EOT;

		return $html;
	}
}
