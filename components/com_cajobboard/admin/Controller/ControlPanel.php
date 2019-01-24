<?php
/**
 * Administrator Control Panel Controller
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Controller;

// Framework classes
use FOF30\Container\Container;
use FOF30\Controller\Controller;
use FOF30\View\Exception\AccessForbidden;
use JFilterOutput;

// no direct access
defined('_JEXEC') or die;

class ControlPanel extends Controller
{
  public function onBeforeDefault()
  {
    return true;
  }
}
