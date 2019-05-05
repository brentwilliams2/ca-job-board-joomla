<?php
/**
 * Helper class for formatting user data for display
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 *
 */

namespace Calligraphic\Cajobboard\Site\Helper;

use \Calligraphic\Cajobboard\Site\Helper\Format;
use \Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;

use \Joomla\CMS\Log\Log;

// Identicon avatar generator. Keep below 'defined or die' clause (third-party library)
use \Identicon\Identicon;

/**
 * A helper class for formatting data for display
 */
abstract class User
{
	/**
	 * Return the avatar for a user
	 *
	 * @param   int    $userId   The user's numeric system ID
	 *
	 * @return  string    Formatted HTML for display
	 */
	public static function getAvatar($userId)
	{
    $identicon = new Identicon();

    // create identicon avatar 24X24
    return $identicon->getImageDataUri($userId, 24);
  }


	/**
	 * Return a "Last seen ... ago" string for a user
	 *
	 * @param   int    $userId   The user's numeric system ID
	 *
	 * @return  string    Formatted HTML for display
	 */
	public static function lastSeen($date)
	{
    return Text::_('COM_CAJOBBOARD_ANSWERS_AUTHOR_LAST_SEEN_BUTTON_LABEL') . ' ' . Format::convertToTimeAgoString($date);
  }


  /**
	 * Check if the user has permission to edit the item
	 *
	 * @param   \Joomla\CMS\User\User   $user   The current user object
   * @param   \FOF30\Model\DataModel  $item   The item to use in checking permissions
	 *
	 * @return  bool    True if user has permission to edit this item
	 */
	public static function canEdit($user, $item)
	{
    $assetName = $item->getAssetName();

    //Log::add('User::canEdit(), $assetName: ' . $assetName . ', itemId: ' . , Log::DEBUG, 'cajobboard');

    // Manager and Super Users user groups are allowed to edit on the front-end
    if ( $user->authorise('core.manage', $assetName) || $user->authorise('core.admin', $assetName) )
    {
      return true;
    }

    // Owner can edit their own if they have ACL permission to do so
    if ($user->authorise('core.edit.own', $assetName) && $item->getFieldValue('created_by') == $user->id )
    {
      return true;
    }

    return false;
  }


	/**
	 * Return a link to the user's profile page
	 *
	 * @param   int    $userId   The user's numeric system ID
	 *
	 * @return  string    URI
	 */
	public static function getLinkToUserProfile($userId)
	{
    // @TODO: implement real link to user's profile
    return '#';
  }
}
