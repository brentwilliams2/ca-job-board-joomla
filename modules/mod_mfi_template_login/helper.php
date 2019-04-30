<?php
/**
 * Multi Family Insiders Bootstrap V3 Template Login Module
 *
 * Helper for module
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
  use \Joomla\CMS\Language\Multilanguage;
  use \Joomla\CMS\Log\Log;
  use \Joomla\CMS\Uri\Uri;

  // no direct access
  defined('_JEXEC') or die;

/**
 * Helper for mod_login
 *
 * @since  1.5
 */
class ModLoginHelper
{
	/**
	 * Retrieve the URL where the user should be returned after logging in
	 *
	 * @param   \Joomla\Registry\Registry  $params  module parameters
	 * @param   string                     $type    return type
	 *
	 * @return string
	 */
	public static function getReturnUrl($params, $type)
	{
    $app  = Factory::getApplication();

		$item = $app->getMenu()->getItem($params->get($type));

		// Stay on the same page
		$url = Uri::getInstance()->toString();

    // @TODO: Need logic to check if we are returning to a restricted page, or
    //        if the user is just trying to login on a general page
    /*
		if ($item)
		{
			$lang = '';

			if ($item->language !== '*' && Multilanguage::isEnabled())
			{
				$lang = '&lang=' . $item->language;
			}

			$url = 'index.php?Itemid=' . $item->id . $lang;
		}
    */

		return base64_encode($url);
	}


	/**
	 * Returns the current users type
	 *
	 * @return string
	 */
	public static function getType()
	{
		$user = Factory::getUser();

		return (!$user->get('guest')) ? 'logout' : 'login';
	}
}
