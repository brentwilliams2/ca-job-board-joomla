<?php
/**
 * Helper class for formatting data for display
 *
 * @package   Calligraphic Job Board
 * @version   September 17, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   GNU General Public License version 3, or later
 *
 */

namespace Calligraphic\Cajobboard\Admin\Helper;

use \Calligraphic\Cajobboard\Admin\Model\Persons;
use \FOF30\Container\Container;
use \FOF30\Model\DataModel\Exception\RecordNotLoaded;
use \Joomla\CMS\Language\Text;
use \Joomla\Registry\Registry;

// no direct access
defined('_JEXEC') or die;

/**
 * A helper class for getting and updating aggregate total and unread Messages counts
 */
class JsonResumeToHtmlParser
{

}