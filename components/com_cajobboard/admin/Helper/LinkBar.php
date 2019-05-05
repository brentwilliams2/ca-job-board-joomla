<?php
/**
 * Helper class to render the administrative screen sidebar of links
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, Copyright (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Helper;

use FOF30\Container\Container;

// no direct access
defined('_JEXEC') or die;

/**
 * Utility class for rendering the administrative screen sidebar of links
 *
 * @since  0.0.1
 */
abstract class LinkBar
{
  /**
	 * Renders the link bar on the left-hand side of the page
	 *
	 * @return  void
	 */
	public static function renderLinkbar(Container $container)
	{
    $platform = $container->platform;

		// Do not render a submenu unless we are in the the admin area and in a web view
		if ($platform->isCli() || !$platform->isBackend())
		{
			return;
    }

    return \JHtmlSidebar::render();
	}
}

