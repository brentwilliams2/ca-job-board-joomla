<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Helper\AuthenticationHelper;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Helper\ModuleHelper;

defined('_JEXEC') or die;

// Include the login functions only once
\JLoader::register('ModLoginHelper', __DIR__ . '/helper.php');

$params->def('greeting', 1);

$type             = ModLoginHelper::getType();
$return           = ModLoginHelper::getReturnUrl($params, $type);
$twofactormethods = AuthenticationHelper::getTwoFactorMethods();
$user             = Factory::getUser();
$layout           = $params->get('layout', 'default');

// Logged users must load the logout sublayout
if (!$user->guest)
{
	$layout .= '_logout';
}

require ModuleHelper::getLayoutPath('mod_login', $layout);
