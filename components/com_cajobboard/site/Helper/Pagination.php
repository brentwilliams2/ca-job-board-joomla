<?php
/**
 * Extended Pagination object for use in site views
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Helper;

use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Pagination\Pagination as JoomlaPagination;

// no direct access
defined('_JEXEC') or die;

/**
 * Pagination Class. Provides a common interface for content pagination for the Joomla! CMS.
 *
 * @since  1.5
 */
class Pagination extends JoomlaPagination
{
	/**
	 * Creates a dropdown box for selecting how many records to show per page.
	 *
	 * @return  string  The HTML for the limit # input box.
	 */
	public function getLimitBox()
	{
    $limits = array();

		// Make the option list. $limits looks like: 5, 10, 15, 20, 25, 30, 50, 100, All
		for ($i = 5; $i <= 30; $i += 5)
		{
			$limits[] = HTMLHelper::_('select.option', "$i");
    }

		$limits[] = HTMLHelper::_('select.option', '50', Text::_('J50'));
		$limits[] = HTMLHelper::_('select.option', '100', Text::_('J100'));
    $limits[] = HTMLHelper::_('select.option', '0', Text::_('JALL'));

    $selected = $this->viewall ? 0 : $this->limit;

		// Build the select list.
    $html = HTMLHelper::_(
      'select.genericlist',
      $limits,
      'pagination-limit',
      'class="pagination-limit" size="1" onchange="paginationLimitSubmit()"',
      'value',
      'text',
      $selected
    );

		return $html;
	}
}
