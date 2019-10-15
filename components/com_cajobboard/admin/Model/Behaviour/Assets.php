<?php
/**
 * FOF model behavior class to add Joomla! ACL assets support
 *
 * Based on FOF30 Assets model behaviour
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
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

use \Calligraphic\Cajobboard\Admin\Helper\Category;
use \Calligraphic\Library\Platform\Registry;
use \FOF30\Event\Observer;
use \FOF30\Model\DataModel;
use \Joomla\CMS\Access\Rules;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Table\Asset;


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
    if ( $this->isAssetAclEnabled($item) )
    {
      $this->removeAssetRecord($item);
    }
  }


  /*
   * Bind rules from state to the current model item's $_rules property
   */
  public function onAfterBind(DataModel $item, &$data)
  {
    // @TODO: Add ACL control for setting ACL rules from user input
    if ( $this->isAssetAclEnabled($item) )
    {
      $this->setModelRules($item, $data);
    }
  }

  /*
   * Handle updating ACL record rules if it changed
   */
  public function onAfterUpdate(DataModel $item)
  {
    $assetName = $item->getAssetName();

    $asset = $this->loadAssetByName($assetName);

    // Model's $_rules property should be set at this point by Model's bind() method
    $this->setAssetRules($item, $asset);

    $this->checkAssetRecord($asset);

    $this->saveAssetRecord($asset);
  }


  /*
   * Handle creating ACL record after creating a new record
   */
  public function onAfterCreate(DataModel $item)
  {
    if ( $this->isAssetAclEnabled($item) )
    {
      $asset = $this->loadAssetTable();

      $this
        ->setAssetLevel($item, $asset)
        ->setAssetName($item, $asset)
        ->setAssetParentId($item, $asset)
        ->setAssetRules($item, $asset)
        ->setAssetTitle($item, $asset);

      $asset->setLocation($asset->parent_id, 'last-child');

      $this->checkAssetRecord($asset);

      $assetId = $this->saveAssetRecord($asset);

      $this->saveItemAssetId($item, $assetId);
    }
  }


  /*
   * Check if assets ACL is enabled for this model
   */
  protected function isAssetAclEnabled(DataModel $item)
  {
    $assetFieldAlias = $item->getFieldAlias('asset_id');

    if ( $item->hasField($assetFieldAlias) && $item->isAssetsTracked() )
    {
      return true;
    }

    return false;
  }


  /**
	 * Loads the Joomla! ACL asset table record for the current model item.
   *
   * Use instead of DataModel's getAsset() method to add custom error handling / logging
   *
   * @params  string    $assetName    The full name of the asset, e.g. 'com_cajobboard.model.n'
	 *
   * @throws  \Exception
   *
	 * @return  Asset
	 */
  protected function loadAssetByName($assetName)
	{
    $assetTable = $this->loadAssetTable();

    try
    {
      $isAssetRecordLoaded = $assetTable->loadByName($assetName);
    }
    catch (\Exception $e)
    {
      // ...continue to error handling below
    }

		if (!$isAssetRecordLoaded)
		{
      throw new \Exception( Text::sprintf('COM_CAJOBBOARD_BEHAVIOUR_ASSETS_EXCEPTION_RECORD_NOT_LOADED', $assetName) );
    }

    return $assetTable;
  }


  /**
	 * Loads the Joomla! ACL asset table (nested table). Overridden to throw
   * exception on failure and save reference in class property.
	 *
   * @throws  \Exception
   *
	 * @return  Asset
	 */
  protected function loadAssetTable()
	{
    try
    {
      $assetTable = Asset::getInstance('Asset');
    }
    catch (\Exception $e)
    {
      // ...continue to error handling below
    }

    if (!$assetTable)
		{
      throw new \Exception( Text::_('COM_CAJOBBOARD_BEHAVIOUR_ASSETS_EXCEPTION_MODEL_INSTANCE_NOT_LOADED') );
    }

    return $assetTable;
  }


  /**
   * Sets the level property on the current item's asset record
   */
  protected function setAssetLevel(DataModel $item, Asset $asset)
  {
    $asset->level = 3;

    // Return $this for chaining
    return $this;
  }


  /**
   * Sets the name property on the current item's asset record
   */
  protected function setAssetName(DataModel $item, Asset $asset)
  {
    $asset->name = $item->getAssetName();

    // Return $this for chaining
    return $this;
  }


  /**
   * Sets the parent ID for the current item's asset record, based on the category of the item.
   *
   * @throws    \Exception  Throws if category doesn't have an asset record created for it
   */
  protected function setAssetParentId(DataModel $item, Asset $asset)
  {
    $itemCategoryId = $item->getFieldValue( $item->getFieldAlias('cat_id') );

    $assetCategoryId = $itemCategoryId ? $itemCategoryId : Category::getItemRootCategoryId($item);

    // should look like: com_cajobboard.category.n where n is the number of the category
    $categoryAssetName = $item->getContainer()->componentName . '.category.' . $assetCategoryId;

    $categoryAsset = $this->loadAssetByName($categoryAssetName);

    // getPrimaryKey() has unusual API, returns an array of primary key names and values
    $asset->parent_id = $categoryAsset->getPrimaryKey()['id'];

    // Return $this for chaining
    return $this;
  }


  /**
   * Sets the title property on the current item's asset record
   */
  protected function setAssetTitle(DataModel $item, Asset $asset)
  {
    $asset->title = $item->getAssetTitle(); // getAssetTitle() is an alias to getAssetName()

    // Return $this for chaining
    return $this;
  }


  /**
   * Sets rules property on the current item's asset record
   *
   * @param  \Calligraphic\Library\Platform\Registry   $rules
   */
  protected function setAssetRules(DataModel $item, Asset $asset)
  {
		if ($item->getRules() instanceof \JAccessRules)
		{
      $rules = $item->getRules();
    }
    else
    {
      // set the asset record's rules property to an empty object
      $rules = new Registry();
    }

    // Use Asset's method for setting rules
    $asset->setRules( json_encode($rules) );

    // Return $this for chaining
    return $this;
  }


  /**
   * Binds rules from state to the current model item's $_rules property
   *
   * @param  \Calligraphic\Library\Platform\Registry   $rules
   *
   * Set the ACL rules for Custom Usergroup 123, when manipulating the Asset rules as an array:
   *
   * $rule_array['core.delete'][123] = 0;    // My custom usergroup cannot delete Content
   * $rule_array['core.edit'][123] = 1;      // My custom usergroup can edit Content
   */
  protected function setModelRules(DataModel $item, $data)
  {
   	// Bind the rules.
		if (is_array($data) && isset($data['rules']) && is_array($data['rules']))
		{
			// We have to manually remove any empty value, since they will be converted to int,
			// and "Inherited" values will become "Denied". Joomla is doing this manually, too.
      $rules = array();

			foreach ($data['rules'] as $action => $ids)
			{
				// Build the rules array.
        $rules[$action] = array();

				foreach ($ids as $id => $p)
				{
					if ($p !== '')
					{
						$rules[$action][$id] = ($p == '1' || $p == 'true') ? true : false;
					}
				}
      }
    }
    else
    {
      $item->setRules( array() );
    }
  }


  /**
   * Check if an asset record is valid
   *
   * @throws    \Exception  Throws if the asset table record is invalid
   */
  protected function checkAssetRecord(Asset $asset)
  {
    try
    {
      $isAssetValid = $asset->check();
    }
    catch (\Exception $e)
    {
      // ... continue to error handling below
    }

		if (!$isAssetValid)
		{
      throw new \Exception( Text::_('COM_CAJOBBOARD_BEHAVIOUR_ASSETS_EXCEPTION_ASSET_RECORD_INVALID') );
    }
  }


  /**
   * Create or save a single asset record with passed rules
   *
   * @throws    \Exception  Throws if unable to save asset record
   *
   * @return  int   Returns the primary key value (`id`) for the asset record created
   *                in #__assets to store in item's `asset_id` foreign key field
   */
  protected function saveAssetRecord(Asset $asset)
  {
    try
    {
      $isAssetSaved = $asset->store();
    }
    catch (\Exception $e)
    {
      // ...continue to error handling below
    }

		if (!$isAssetSaved)
		{
      throw new \Exception( Text::_('COM_CAJOBBOARD_BEHAVIOUR_ASSETS_EXCEPTION_SAVE_FAILED') );
    }

    return $asset->getPrimaryKey()['id'];
  }


  /**
   * Alias to saveAssetRecord()
   *
   * @return  int   Returns the primary key value (`id`) for the asset record created
   *                in #__assets to store in item's `asset_id` foreign key field
   */
  protected function createAssetRecord()
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
  protected function saveItemAssetId(Datamodel $item, $assetId)
  {
    $assetFieldAlias = $item->getFieldAlias('asset_id');

    // Get the \JDatabaseQuery object
    $db = $item->getContainer()->db;

    $query = $db->getQuery(true);

    $query
      ->update($db->quoteName( $item->getTableName() ))
      ->set   ($db->quoteName( $assetFieldAlias) . ' = ' . (int) $assetId )
      ->where ($db->quoteName( $item->getIdFieldName() ) . ' = ' . $db->quote( $item->getId() ));

    $db->setQuery($query);

    $isAssetIdSaved = null;

    try
    {
      $isAssetIdSaved = $db->execute();
    }
    catch (\Exception $e)
    {
      // ...continue to error handling below
    }

    if ( !$isAssetIdSaved )
    {
      throw new \Exception( Text::_('COM_CAJOBBOARD_BEHAVIOUR_ASSETS_EXCEPTION_SAVE_ERROR') );
    }

    // Update our in-memory model representation with the asset_id property value
    $item->setFieldValue($assetFieldAlias, $assetId);
  }


  /**
   * Remove an asset record for this item
   *
   * @throws    \Exception  Throws if unable to delete asset record or the asset_id field was blank for the model
   */
  protected function removeAssetRecord(DataModel $item)
  {
    // Get an instance of JAssetsTable
    $assetTable = $this->loadAssetTable();

    $assetFieldAlias = $item->getFieldAlias('asset_id');

    $assetId = $item->getFieldValue($assetFieldAlias);

    if ($assetId)
    {
      try
      {
        $isAssetRemoved = $assetTable->delete($assetId);
      }
      catch (\Exception $e)
      {
        // ...continue with error handling below
      }
    }
    else
    {
      throw new \Exception( Text::sprintf( 'COM_CAJOBBOARD_BEHAVIOUR_ASSETS_EXCEPTION_DELETE_EMPTY_FIELD_ERROR', $item->getId() ) );
    }

    if (!$isAssetRemoved)
    {
      throw new \Exception( Text::sprintf( 'COM_CAJOBBOARD_BEHAVIOUR_ASSETS_EXCEPTION_DELETE_ERROR', $item->getId() ) );
    }
  }
}
