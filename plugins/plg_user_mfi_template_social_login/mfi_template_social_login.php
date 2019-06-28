<?php
/**
 * @package     Calligraphic Job Board
 * @subpackage  User Plugin User.cajobboard
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// Based on Akeeba Social Logins plugin. Has associated Modules.

// no direct access
defined('_JEXEC') or die;

use \Joomla\CMS\Plugin\CMSPlugin;

/**
 * Social Logins for the Multi Family Insiders template
 */
class plgUserMfi_template_social_login extends CMSPlugin
{
	/**
   * Listener for the `onAfterInitialise` system event
	 *
	 * @return  boolean
	 *
	 * @since   1.0
	 */
  public function onAfterInitialise()
	{
    // @TODO: Implement
    return true;
  }
}
