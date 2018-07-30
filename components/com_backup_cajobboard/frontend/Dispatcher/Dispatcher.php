<?php
/**
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Dispatcher;

class Dispatcher extends \FOF30\Dispatcher\Dispatcher
{
	/** @var   string  The name of the default view, in case none is specified */
  public $defaultView = 'HomePage';

	public function onBeforeDispatch()
	{
    // @TODO: Add authentication code

    // Load common Javascript
    $this->container->template->addJS('media://com_cajobboard/css/frontend.js', true, false, $this->container->mediaVersion);

		// Load common CSS
    $this->container->template->addCSS('media://com_cajobboard/css/frontend.css', $this->container->mediaVersion);
  }
}
