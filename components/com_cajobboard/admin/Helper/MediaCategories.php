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

use JHtmlSidebar;
use \Joomla\CMS\Helper\ContentHelper;
use \Joomla\CMS\Language\Text;

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// @TODO: Is this file being used?
die('In MediaCategories Helper, testing whether this is ever used...');

/**
 * Admin Media Categories component helper.
 *
 * @param   string  $submenu  The name of the active view.
 *
 * @return  void
 *
 * @since   1.6
 */
class MediaCategories extends ContentHelper
{
  /**
	 * Configure the Linkbar.
	 *
	 * @return Bool
	 */

	public static function addSubmenu($submenu)
	{
    JHtmlSidebar::addEntry(
			Text::_('COM_CAJOBBOARD_SUBMENU_OPTION'),
			'index.php?option=com_cajobboard',
			$submenu == 'media'
    );

		JHtmlSidebar::addEntry(
			Text::_('COM_CAJOBBOARD_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&view=categories&extension=com_cajobboard',
			$submenu == 'categories'
		);

		if ($submenu == 'categories')
		{
			$document->setTitle(Text::_('COM_CAJOBBOARD_ADMINISTRATION_CATEGORIES'));
		}
	}
}
