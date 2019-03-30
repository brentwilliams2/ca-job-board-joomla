<?php
/**
 * Custom admin toolbar helper
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Toolbar;

// no direct access
defined('_JEXEC') or die;

use \Joomla\CMS\Toolbar\Toolbar as JToolBar;

/**
 * Utility class for the button bar.
 *
 * @since  1.5
 */
abstract class ToolbarHelper
{
	/**
	 * Writes a common 'featured' button for a list of records.
	 *
	 * @param   string   $task   Task associated with the button.
	 * @param   string   $alt    An override for the alt text.
	 *
	 * @return  void
	 *
	 * @since   1.5
	 */
	public static function featureList($task = 'feature', $alt = 'JFEATURE')
	{
    $bar = JToolbar::getInstance('toolbar');

		// Add a featured button.
		$bar->appendButton('Standard', 'featured', $alt, $task, true);
  }


	/**
	 * Writes a common 'unfeatured' button for a list of records.
	 *
	 * @param   string  $task  An override for the task.
	 * @param   string  $alt   An override for the alt text.
	 *
	 * @return  void
	 *
	 * @since   1.5
	 */
	public static function unfeatureList($task = 'unfeature', $alt = 'JUNFEATURE')
	{
    $bar = JToolbar::getInstance('toolbar');

		// Add an unfeature button
		$bar->appendButton('Standard', 'unfeatured', $alt, $task, true);
  }
}
