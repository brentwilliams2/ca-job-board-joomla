<?php
/**
 * Admin Ordering Controller Mixin
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Controller\Mixin;

use \FOF30\Container\Container;
use \FOF30\Model\DataModel;

use \Joomla\CMS\Log\Log;

// no direct access
defined('_JEXEC') or die;

trait Permissions
{
  // Overridden, access checking in FOF30 DataController triggerEvent() method seems broken
  protected function checkACL($area)
  {
    /*
     * $taskPrivileges is an associative array for required ACL privileges per task.
     * Callbacks should return a taskArea. Default
     *
     *    $taskPrivileges = array(
     *     	// 'taskArea' => 'permission'
     *     	'*editown' => 'core.edit.own',
     *     	'add' => 'core.create',
     *     	'apply' => '&getACLForApplySave',
     *     	'archive' => 'core.edit.state',
     *     	'cancel' => 'core.edit.state',
     *     	'copy' => '@add',
     *     	'edit' => 'core.edit',
     *     	'loadhistory' => '@edit',
     *     	'orderup' => 'core.edit.state',
     *     	'orderdown' => 'core.edit.state',
     *     	'publish' => 'core.edit.state',
     *     	'remove' => 'core.delete',
     *     	'forceRemove' => 'core.delete',
     *     	'save' => '&getACLForApplySave',
     *     	'savenew' => 'core.create',
     *     	'saveorder' => 'core.edit.state',
     *     	'trash' => 'core.edit.state',
     *     	'unpublish' => 'core.edit.state',
     *   );
     *
     * '@task' means 'apply the same privileges as "task"'. Creating a circular reference
     * with @task notation will always return true when that task is requested:
     *
     *   'mytask' => array('@mytask')
     *
     * Controller constructor $config['taskPrivileges'] are merged with the above
    */

    // Resolves @task and &callback notations for ACL privileges set on the
    // $taskPrivileges array to a normalized privilege name e.g. core.edit
    $area = $this->getACLRuleFor($area);

    // $area is true here if (1) no callback method found with &callback notation,
    // (2) the referenced task has no ACL map in $taskPrivileges (like @Execute),
    // or (3) a circular reference in $taskPrivileges array. The last is the default
    // way to always return true, e.g. 'mytask' => array('@mytask')
    if (is_bool($area))
    {
      return $area;
    }

    // Models which use item-level asset tracking don't work with read tasks
    if ( 'read' == $this->getTask() )
    {
      return true;
    }

		// Check if we're dealing with ids
    $ids = $this->getRequestIds();

		// No item-level permissions (IDs) tracked, return result of checking general rules and component authorisation
		if (empty($ids))
		{
			return $this->filterAndCheckAuth($area);
    }

    $assetNamePrefix = $this->container->componentName . '.' . strtolower( $this->container->inflector->singularize($this->view) );

		foreach ($ids as $id)
		{
      $assetName = $assetNamePrefix . '.' . $id;

      // Check the area against the item-level permission
			if ($this->container->platform->authorise($area, $assetName) )
			{
				return true;
      }

      // Allow any action if user is the owner of the item and has edit.own permissions
      if ( $this->hasEditOwnPermission($area, $assetName) && $this->isOwner($id) )
      {
        return true;
      }
		}

		// No result found? Not authorised.
		return false;
  }


  protected function hasEditOwnPermission($area, $assetName)
  {
    if (( $area != 'core.edit.state' ) && ( $this->container->platform->authorise( $this->getACLRuleFor('@*editown'), $assetName )))
    {
      return true;
    }

    return false;
  }


  protected function isOwner($id)
  {
    /** @var DataModel $model */
    $model = $this->getModel();

    $model->load($id);

    if (!$model->hasField('created_by'))
    {
      return false;
    }

    $owner_id = (int) $model->getFieldValue('created_by', null);

    // test owner against current user
    if ($owner_id == $this->container->platform->getUser()->id)
    {
      return true;
    }

    return false;
  }


  protected function filterAndCheckAuth($area)
  {
    if (in_array(strtolower($area), array('false','0','no','403')))
    {
      return false;
    }

    if (in_array(strtolower($area), array('true','1','yes')))
    {
      return true;
    }

    // ACL is approved if area is 'guest', and the current user is a guest user
    if (in_array(strtolower($area), array('guest')))
    {
      return $this->container->platform->getUser()->guest;
    }

    // ACL is approved if area is 'user', and the current user is a registered (logged-in) user
    if (in_array(strtolower($area), array('user')))
    {
      return !$this->container->platform->getUser()->guest;
    }

    if (empty($area))
    {
      return true;
    }

    return $this->container->platform->authorise($area, $this->container->componentName);
  }


  /*
   * Get an array of record IDs from the request
   *
   * @return  array|null   Returns array of record IDs, or null if there is none
   */
  protected function getRequestIds()
  {
		/** @var DataModel $model */
    $model = $this->getModel();

		if ( is_object($model) && ($model instanceof DataModel) && $model->isAssetsTracked() )
		{
			return $this->getIDsFromRequest($model, false);
    }
  }
}
