<?php
/**
 * Helper for Administrator Media Categories
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Helper;

use JHelperContent;
use JHtmlSidebar;
use JText;

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Admin Media Categories component helper.
 *
 * @param   string  $submenu  The name of the active view.
 *
 * @return  void
 *
 * @since   1.6
 */
class MediaCategoriesHelper extends JHelperContent
{
  // @TODO: Is this being used?

	/**
	 * Configure the Linkbar.
	 *
	 * @return Bool
	 */

	public static function addSubmenu($submenu)
	{
    JHtmlSidebar::addEntry(
			JText::_('COM_CAJOBBOARD_SUBMENU_OPTION'),
			'index.php?option=com_cajobboard',
			$submenu == 'media'
    );

		JHtmlSidebar::addEntry(
			JText::_('COM_CAJOBBOARD_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&view=categories&extension=com_cajobboard',
			$submenu == 'categories'
		);

		if ($submenu == 'categories')
		{
			$document->setTitle(JText::_('COM_CAJOBBOARD_ADMINISTRATION_CATEGORIES'));
		}
	}
}
