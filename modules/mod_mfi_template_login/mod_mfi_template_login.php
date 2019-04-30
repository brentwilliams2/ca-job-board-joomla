<?php
/**
 * Multi Family Insiders Bootstrap V3 Template Login Module
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

  use Joomla\CMS\Helper\AuthenticationHelper;
  use \Joomla\CMS\Factory;
  use \Joomla\CMS\Helper\ModuleHelper;

    // no direct access
    defined('_JEXEC') or die;

  // Include the login functions only once
  \JLoader::register('ModLoginHelper', __DIR__ . '/helper.php');

  $params->def('greeting', 1);

  // user type is 'logout' or 'login'
  $type             = ModLoginHelper::getType();

  // the URL where the user should be returned after logging in
  $return           = ModLoginHelper::getReturnUrl($params, $type);

  $twofactormethods = AuthenticationHelper::getTwoFactorMethods();

  $user             = Factory::getUser();

  $layout           = $params->get('layout', 'default');

  // Logged-in users must load the logout sublayout
  if (!$user->guest)
  {
    $layout .= '_logout';
  }

  require ModuleHelper::getLayoutPath('mod_mfi_template_login', $layout);
