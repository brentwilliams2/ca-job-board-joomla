<?php
/**
 * Helper class for formatting user data for display
 *
 * @package   Calligraphic Job Board
 * @version   October 21, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Site\Helper;

// no direct access
defined('_JEXEC') or die;

use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Uri\Uri;

/*
	Default task map to permissions:

	'*editown' => 'core.edit.own',
	'add' => 'core.create',
	'apply' => '&getACLForApplySave',
	'archive' => 'core.edit.state',
	'cancel' => 'core.edit.state',
	'copy' => '@add',
	'edit' => 'core.edit',
	'loadhistory' => '@edit',
	'orderup' => 'core.edit.state',
	'orderdown' => 'core.edit.state',
	'publish' => 'core.edit.state',
	'remove' => 'core.delete',
	'save' => '&getACLForApplySave',
	'savenew' => 'core.create',
	'saveorder' => 'core.edit.state',
	'trash' => 'core.edit.state',
	'unpublish' => 'core.edit.state',
	'forceRemove' => 'core.delete'
*/

class User
{
  /**
   * A reference to the application container
   *
   * @property Container
   */
  protected $container = null;


  /**
	 * @param   Container   $container    The application container
	 */
	public function __construct ($container)
	{
    $this->container = $container;
	}


  /**
	 * Check if the user has permission to add an item. Note that Platform's authorise()
	 * method automatically detects the current user to check permissions against.
	 *
   * @param   \FOF30\Model\DataModel  $model   The model to use in checking permissions
	 *
	 * @return  bool    True if user has permission to add an item
	 */
	public function canAdd($model)
	{
		// Use the ACL record's parent ACL rules if enabled for this model, or component-level ACL rules otherwise
    if ( $model->isAssetAclEnabled() )
    {
      $assetName = $model->getAssetParentId();
    }
    else
    {
      $assetName = $this->container->componentName;
    }

		$platform = $this->container->platform;

    // Manager and Super Users user groups are allowed to add items on the front-end
    if ( $platform->authorise('core.manage', $assetName) || $platform->authorise('core.admin', $assetName) )
    {
      return true;
    }

    // Registered users can add an item if they have ACL permission to do so
    if ( $platform->authorise('core.create', $assetName) )
    {
      return true;
		}

    return false;
	}


  /**
	 * Check if the user has permission to edit the item. Note that Platform's authorise()
	 * method automatically detects the current user to check permissions against.
	 *
   * @param   \FOF30\Model\DataModel  $item   The item to use in checking permissions
	 *
	 * @return  bool    True if user has permission to edit this item
	 */
	public function canEdit($item)
	{
		// Use the item-level ACL rules if enabled for this model, or component-level ACL rules otherwise
    if ( $item->isAssetAclEnabled() )
    {
			$assetName = $item->getAssetName();
    }
    else
    {
      $assetName = $this->container->componentName;
    }

		$platform = $this->container->platform;

    // Manager and Super Users user groups are allowed to edit on the front-end
    if ( $platform->authorise('core.manage', $assetName) || $platform->authorise('core.admin', $assetName) )
    {
      return true;
    }

    // Registered users can edit if they have ACL permission to do so
    if ( $platform->authorise('core.edit', $assetName) )
    {
      return true;
		}

    // Owner can edit their own if they have ACL permission to do so
    if ( $platform->authorise('core.edit.own', $assetName) && $item->getFieldValue('created_by') == $platform->getUser()->id )
    {
      return true;
    }

    return false;
	}


	/**
	 * Return the avatar for a user
	 *
	 * @param   int    $userId   The user's numeric system ID
	 *
	 * @return  string    Formatted HTML for display
	 */
	public function getAvatar($userId)
	{
    // create identicon avatar 24X24
    return $this->container->Identicon->getImageDataUri($userId, 24);
  }


	/**
	 * Return a link to the user's profile page
	 *
	 * @param   int    $userId   The user's numeric system ID
	 *
	 * @return  string    URI
	 */
	public function getLinkToUserProfile($userId)
	{
    return $this->container->template->route(
      Uri::base() . 'index.php?option=com_cajobboard&view=Persons&task=read&id=' . $userId
    );
	}


	/**
	 * Return a "Last seen ... ago" string for a user
	 *
	 * @param   int    $userId   The user's numeric system ID
	 *
	 * @return  string    Formatted HTML for display
	 */
	public function lastSeen($date)
	{
    return Text::_('COM_CAJOBBOARD_AUTHOR_LAST_SEEN_BUTTON_LABEL') . ' ' . $this->container->Format->convertToTimeAgoString($date);
  }
}
