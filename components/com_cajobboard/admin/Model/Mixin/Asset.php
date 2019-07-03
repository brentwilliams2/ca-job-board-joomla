<?php
/**
 * Helpers for manipulating asset rules and the asset table
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

/** @var FOF30\Model\DataModel $this */

namespace Calligraphic\Cajobboard\Admin\Model\Mixin;

// no direct access
defined('_JEXEC') or die;

trait Asset
{
  /**
	 * Check ACL for this model item. Handles FOF record-level access control.
	 *
	 * @return  bool   True if user has permissions
	 */
	public function isEditAuthorised()
	{
    $platform = $this->container->platform;

    if ( $this->isAssetsTracked() )
    {
      $assetname = $this->getAssetName();
    }
    else
    {
      $assetname = $this->container->componentName;
    }

		$privileges = array
		(
      // authorise($action, $assetname)
			'editown'	   => $platform->authorise('core.edit.own'  , $assetname),
			'editstate'	 => $platform->authorise('core.edit.state', $assetname),
			'admin'	     => $platform->authorise('core.admin'     , $assetname),
			'manage'	   => $platform->authorise('core.manage'    , $assetname),
    );

    if ( $privileges['editown'] || $privileges['admin'] || $privileges['manage'] || $privileges['editstate'])
    {
      return true;
    }

    return false;
  }
}
