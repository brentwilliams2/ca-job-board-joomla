<?php
/**
 * FOF model behavior class to add Joomla! ACL assets support
 *
 * Based on FOF30 Assets model behaviour
 *
 * @package   Calligraphic Job Board
 * @version   October 21, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Assets are hierarchical, starting with a root asset:
 *
 *   Level  Asset Name                   Description
 *   -----  ----------                   -----------
 *     0    root.1                       Site root asset
 *     1    com_cajobboard               Component root asset
 *     2    com_cajobboard.category.n    Category assets
 *     3    com_cajobboard.model.n       Item assets
 *
 * Level 2 can have component-specific alternatives to "category":
 *
 *     2    com_content.fieldgroup.n
 *     2    com_modules.module.n
 *     2    com_languages.language.n
 *     2    com_menus.menu.n
 *
 * This accommodates organizing item-level permissions in different taxonomies:
 *
 *     3    com_content.field.n
 */

namespace Calligraphic\Cajobboard\Admin\Model\Behaviour;

// no direct access
defined('_JEXEC') or die;

use \FOF30\Event\Observer;
use \FOF30\Model\DataModel;

/**
 * To override validation behaviour for a particular model, create a directory
 * named named after the model in the 'Behaviour' directory and use the same file
 * name as this behaviour ('Check.php'). The model file cannot go in this directory,
 * it must stay in the root Model folder.
 */
class Assets extends Observer
{
  /**
	 * Add the asset id field to the fieldsSkipChecks list of the model. It
	 * should be empty so that we can fill it in through this behaviour.
	 *
	 * @param   DataModel  $item
	 */
	public function onBeforeCheck(DataModel $item)
	{
    $assetIdField = $item->getFieldAlias('asset_id');

    if ( $item->hasField($assetIdField) )
    {
      $item->addSkipCheckField($assetIdField);
    }
  }


  /**
   * Remove an asset record for the current model item
   *
   * @throws    \Exception  Throws if unable to delete asset record or the asset_id field was blank for the model
   */
  public function onAfterDelete(DataModel $item, $id)
  {
    if ( $item->isAssetAclEnabled() )
    {
      $item->removeAssetRecord();
    }
  }


  /*
   * Bind rules from state to the current model item's $_rules property
   */
  public function onAfterBind(DataModel $item, &$data)
  {
    if ( $item->isAssetAclEnabled() )
    {
      $item->setModelRules($data);
    }
  }

  /*
   * Handle updating ACL record rules if it changed
   */
  public function onAfterUpdate(DataModel $item)
  {
    $assetName = $item->getAssetName();

    $asset = $item->loadAssetByName($assetName);

    // Model's $_rules property should be set at this point by Model's bind() method
    $item->setAssetRules($asset);

    $item->checkAssetRecord($asset);

    $item->saveAssetRecord($asset);
  }


  /*
   * Handle creating ACL record after creating a new record
   */
  public function onAfterCreate(DataModel $item)
  {
    if ( $item->isAssetAclEnabled() )
    {
      $asset = $item->loadAssetTable();

      $item
        ->setAssetLevel($asset)
        ->setAssetName($asset)
        ->setAssetParentId($asset)
        ->setAssetRules($asset)
        ->setAssetTitle($asset);

      $asset->setLocation($asset->parent_id, 'last-child');

      $item->checkAssetRecord($asset);

      $assetId = $item->saveAssetRecord($asset);

      $item->saveItemAssetId($assetId);
    }
  }
}
