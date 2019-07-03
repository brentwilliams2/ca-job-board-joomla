<?php
/**
 * Overridden Platform class
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Platform;

use \FOF30\Platform\Joomla\Platform as JoomlaPlatform;

// no direct access
defined('_JEXEC') or die;

class JobBoardPlatform extends JoomlaPlatform
{
  // @TODO: Move from JText and JLanguage static methods to a Calligraphic library version
  //        of each that uses PHP files (so opcache can cache them) for all template,
  //        job board, and FOF30 language files

  // use \Calligraphic\Library\Platform\Text;
  // use \Calligraphic\Library\Platform\Language;

	/**
	 * Return the \JLanguage instance of the CMS/application
	 *
	 * @return \JLanguage
	 */
	public function getLanguage()
	{
		return JFactory::getLanguage();
	}
}
