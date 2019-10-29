<?php
/**
 * Front-end entry file for FOF component
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// no direct access
defined( '_JEXEC' ) or die;

use \FOF30\Container\Container;
use \Joomla\CMS\Component\ComponentHelper;
use \Joomla\CMS\Log\Log;

// Load FOF
if (!defined('FOF30_INCLUDED') && !@include_once(JPATH_LIBRARIES . '/fof30/include.php'))
{
	throw new RuntimeException('FOF 3.0 is not installed', 500);
}

// Make sure Akeeba Subscriptions is installed. ComponentHelper
// returns an \Joomla\CMS\Component\ComponentRecord object.
if ( !ComponentHelper::getComponent('com_akeebasubs', true)->enabled )
{
	throw new RuntimeException('Akeeba Subscriptions is not installed', 500);
}

if(JDEBUG) {
  Log::addLogger(
    array('text_file' => 'cajobboard.debug.php'),
    Log::DEBUG,
    array('cajobboard')
  );
}

// Load custom class paths
include_once JPATH_COMPONENT_ADMINISTRATOR . '/Helper/Autoloader.php';

$container = Container::getInstance('com_cajobboard')->dispatcher->dispatch();

// HMVC variant for controllers
// FOFDispatcher::getTmpInstance('com_cajobboard')->dispatch();
