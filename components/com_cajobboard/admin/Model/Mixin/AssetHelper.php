<?php
/**
 * Helpers for manipulating asset rules and the asset table
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
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

/** @var FOF30\Model\DataModel $this */

namespace Calligraphic\Cajobboard\Admin\Model\Mixin;

// no direct access
defined('_JEXEC') or die;

use \Joomla\CMS\Log\Log;
use \Joomla\CMS\Table\Asset;
use \Joomla\Registry\Registry;
use \Joomla\CMS\Access\Rules;

trait AssetHelper
{
  /**
	 * Reference to a Joomla! Asset table object
	 *
	 * @var   Asset
	 */
  protected $asset = null;


  /**
	 * Check ACL for this model item. Handles FOF record-level access control.
	 *
	 * @return  bool   True if user has permissions
	 */
	public function checkRecordEditACL()
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


  /**
	 * Loads the Joomla! ACL asset table (nested table). Overridden to throw
   * exception on failure and save reference in class property.
	 *
   * @throws  \Exception
	 * @return  Asset
	 */
  protected function getAsset()
	{
    if (!$this->asset)
    {
      $this->asset = Asset::getInstance('Asset');
    }

    if (!$this->asset)
		{
      throw new \Exception('Could not load an empty asset to save with this item.');
    }

    return $this->asset;
  }


  /**
	 * Loads the Joomla! ACL asset table record for the current model item.
	 *
   * @throws  \Exception
	 * @return  Asset
	 */
  protected function getAssetByName()
	{
    if (!$this->asset)
    {
      $this->getAsset();
    }

    $name = $this->getAssetName();

    $isAssetRecordLoaded = $this->asset->loadByName($name);

		if (!$isAssetRecordLoaded)
		{
      throw new \Exception('Could not load the asset record for this item.');
    }

    return $this->asset;
  }


  /**
   * Sets the parent ID for the current item's asset record, based on the category of the item.
   *
   * @throws    \Exception  Throws if category doesn't have an asset record created for it
   */
  public function setAssetParentId()
  {
    if (!$this->asset)
    {
      $this->getAsset();
    }

    $categoryAsset = Asset::getInstance('Asset');

    // should look like: com_cajobboard.category.n where n is the number of the category
    $categoryAssetName = $this->container->componentName . '.category.' . $this->getFieldValue('cat_id');

    $isCategoryAssetRecordLoaded = $categoryAsset->loadByName($categoryAssetName);

		if (!$isCategoryAssetRecordLoaded)
		{
      throw new \Exception('Could not load the asset record for this item\s category.');
    }

    $this->asset->bind( array( 'parent_id' => $categoryAsset->getPrimaryKey()['id'] ) );
  }


  /**
   * Sets the name property on the current item's asset record
   */
  public function setAssetName()
  {
    if (!$this->asset)
    {
      $this->getAsset();
    }

    $this->asset->bind( array( 'name' => $this->getAssetName() ) );
  }


  /**
   * Sets the name property on the current item's asset record
   */
  public function setAssetRules()
  {
    if (!$this->asset)
    {
      $this->getAsset();
    }

    // @TODO: Need to add data transformations to handle sending permissions
    // back from edit form, or use Joomla's javascript AJAX method

  /*
    // Asset record rule values are Joomla! Registry objects
    $rules = new Registry();

    // Load the Current ACL rules into the Registry
    $rules->loadString($asset);

    $rule_array = $rules->toArray();    // Convert to Array for easy manipulation

    // Set the ACL rules for Custom Usergroup 123
    $rule_array['core.delete'][123] = 0;    // My custom usergroup cannot delete Content
    $rule_array['core.edit'][123] = 1;      // My custom usergroup can edit Content

    // Re-load the Rules registry with the modified rules array for saving
    $rules->loadArray($rule_array);

    return $rules;
  */

    $rules = new \stdClass();

    $this->asset->bind( array( 'rules' => json_encode($rules) ) );
  }


  /**
   * Create or save a single asset record with passed rules
   *
   * @throws    \Exception  Throws if unable to save asset record
   *
   * @return  int   Returns the primary key value (`id`) for the asset record created
   *                in #__assets to store in item's `asset_id` foreign key field
   */
  public function saveAssetRecord()
  {
    if (!$this->asset)
    {
      $this->getAsset();
    }

    $isAssetSaved = $this->asset->store();

		if (!$isAssetSaved)
		{
      throw new \Exception('Could not save asset record for this item.');
    }

    return $this->asset->getPrimaryKey()['id'];
  }


  /**
   * Alias to saveAssetRecord()
   *
   * @return  int   Returns the primary key value (`id`) for the asset record created
   *                in #__assets to store in item's `asset_id` foreign key field
   */
  public function createAssetRecord()
  {
    return $this->saveAssetRecord();
  }


  /**
   * Save the asset ID in the model's asset_id field, avoid on/afterUpdate methods
   * using model save methods and their associated asset rules handling methods
   *
   * @param   int   $assetId  The primary key value of the asset record
   *
   * @throws  \Exception
   */
  public function saveItemAssetId($assetId)
  {
    // Get the \JDatabaseQuery object
    $db = $this->container->db;

    $query = $db->getQuery(true);

    $query
      ->update($db->quoteName( $this->getTableName() ))
      ->set   ($db->quoteName('asset_id') . ' = ' . $db->quote($assetId))
      ->where ($db->quoteName( $this->getIdFieldName() ) . ' = ' . $db->quote( $this->getId() ));

    $db->setQuery($query);

    try
    {
      $assetRule = $db->execute();
    }
    catch (\Exception $e)
    {
      throw new \Exception("Error updating asset record ID in this item:\n" . $e);
    }
  }


  /**
   * Remove an asset record for this item
   *
   * @throws    \Exception  Throws if unable to delete asset record or the asset_id field was blank for the model
   */
  public function removeAssetRecord()
  {
    if (!$this->asset)
    {
      $this->getAsset();
    }

    $assetPk = $this->getFieldValue('asset_id');

    if ($assetPk)
    {
      $isAssetRemoved = $this->asset->delete($assetPk);
    }
    else
    {
      throw new \Exception(
          'The asset record field for item number ' . $this->getId()
        . ' was empty, so no asset record was removed (asset tracking is enabled though)'
      );
    }

    if (!$isAssetRemoved)
    {
      throw new \Exception('Could not remove asset record for item number ' . $this->getId() );
    }
  }
}
