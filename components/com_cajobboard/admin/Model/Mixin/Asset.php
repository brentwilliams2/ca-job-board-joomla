<?php
/**
 * Helpers for manipulating asset rules and the asset table
 *
 * @package   Calligraphic Job Board
 * @version   October 21, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

/** @var FOF30\Model\DataModel $this */

namespace Calligraphic\Cajobboard\Admin\Model\Mixin;

// no direct access
defined('_JEXEC') or die;

use \Calligraphic\Cajobboard\Admin\Helper\Category;
use \Calligraphic\Cajobboard\Admin\Model\Exception\AssetException;
use \Calligraphic\Library\Platform\Registry;
use \FOF30\Model\DataModel;
use \Joomla\CMS\Access\Rules;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Table\Asset as JAsset;
use \Joomla\CMS\Table\Table;

trait Asset
{
  /**
   * Check if an asset record is valid
   *
   * @param   \Joomla\CMS\Table\Asset   $asset  The asset object for the item
   *
   * @throws  AssetException  Throws if the asset table record is invalid
   */
  public function checkAssetRecord(JAsset $asset)
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
      throw new AssetException( Text::_('COM_CAJOBBOARD_BEHAVIOUR_ASSETS_EXCEPTION_RECORD_INVALID') );
    }
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
   * Over-ridden to get parent asset primary key value based on the item's category.
   * Job board parent asset records are stored in the '#__assets' table in the format
   * com_cajobboard.category.n where 'n' is the integer number of the category in the
   * '#__categories' table. Parent asset records can be found by searching the asset
   * table 'title' field with a humanized model name, e.g. 'JobPostings'
	 *
	 * @param   DataModel   $model  Unused, parent method signature over-ridden here
	 * @param   int         $id     Unused, parent method signature over-ridden here
	 *
	 * @return  int   Returns the primary key id of the asset's parent record
	 */
	public function getAssetParentId($model = null, $id = null)
	{
    $itemCategoryIdValue = $this->getFieldValue( $this->getFieldAlias('cat_id') );

    $assetCategoryId = $itemCategoryIdValue ? $itemCategoryIdValue : Category::getItemRootCategoryId($this);

    // should look like: com_cajobboard.category.n where n is the number of the category
    $categoryAssetName = $this->getContainer()->componentName . '.category.' . $assetCategoryId;

    $categoryAsset = $this->loadAssetByName($categoryAssetName);

    // getPrimaryKey() has unusual API, returns an array of primary key names and values
    return $categoryAsset->getPrimaryKey()['id'];
  }


  /**
   * Check if assets ACL is enabled for this model
   *
   * @return bool   Returns true if the model has assets ACL enabled
   */
  public function isAssetAclEnabled()
  {
    $assetFieldAlias = $this->getFieldAlias('asset_id');

    if ( $this->hasField($assetFieldAlias) && $this->isAssetsTracked() )
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
   * @param   string    $assetName    The full name of the asset, e.g. 'com_cajobboard.model.n'
	 *
   * @throws  AssetException    Throws if the named assets record could not be loaded
   *
	 * @return  \Joomla\CMS\Table\Asset
	 */
  public function loadAssetByName($assetName)
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
      throw new AssetException( Text::sprintf('COM_CAJOBBOARD_BEHAVIOUR_ASSETS_EXCEPTION_RECORD_NOT_LOADED', $assetName) );
    }

    return $assetTable;
  }


  /**
	 * Loads the Joomla! ACL asset table (nested table). Overridden to throw
   * exception on failure and save reference in class property.
	 *
   * @throws  AssetException    Throws if the Joomla! Assets table could not be loaded
   *
	 * @return  \Joomla\CMS\Table\Asset
	 */
  public function loadAssetTable()
	{
    try
    {
      $assetTable = JAsset::getInstance('Asset');
    }
    catch (\Exception $e)
    {
      // ...continue to error handling below
    }

    if (!$assetTable)
		{
      throw new AssetException( Text::_('COM_CAJOBBOARD_BEHAVIOUR_ASSETS_EXCEPTION_MODEL_INSTANCE_NOT_LOADED') );
    }

    return $assetTable;
  }


  /**
   * Remove an asset record for this item
   *
   * @throws  AssetException    Throws if the model doesn't have an asset record ID or there was error deleting the record
   */
  public function removeAssetRecord()
  {
    // Get an instance of JAssetsTable
    $assetTable = $this->loadAssetTable();

    $assetFieldAlias = $this->getFieldAlias('asset_id');

    $assetId = $this->getFieldValue($assetFieldAlias);

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
      throw new AssetException( Text::sprintf( 'COM_CAJOBBOARD_BEHAVIOUR_ASSETS_EXCEPTION_DELETE_EMPTY_FIELD_ERROR', $this->getId() ) );
    }

    if (!$isAssetRemoved)
    {
      throw new AssetException( Text::sprintf( 'COM_CAJOBBOARD_BEHAVIOUR_ASSETS_EXCEPTION_DELETE_ERROR', $this->getId() ) );
    }
  }


  /**
   * Create or save a single asset record with passed rules
   *
   * @param   \Joomla\CMS\Table\Asset   $asset  The asset object for the item
   *
   * @throws    AssetException  Throws if unable to save asset record
   *
   * @return  int   Returns the primary key value (`id`) for the asset record created
   *                in #__assets to store in item's `asset_id` foreign key field
   */
  public function saveAssetRecord(JAsset $asset)
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
      throw new AssetException( Text::_('COM_CAJOBBOARD_BEHAVIOUR_ASSETS_EXCEPTION_SAVE_FAILED') );
    }

    return $asset->getPrimaryKey()['id'];
  }


  /**
   * Save the asset ID in the model's asset_id field, avoid on/afterUpdate methods
   * using model save methods and their associated asset rules handling methods
   *
   * @param   int   $assetId  The primary key value of the asset record
   *
   * @throws  AssetException  Throws if unable to update the asset id on the model item
   */
  public function saveItemAssetId($assetId)
  {
    $assetFieldAlias = $this->getFieldAlias('asset_id');

    // Get the \JDatabaseQuery object
    $db = $this->getContainer()->db;

    $query = $db->getQuery(true);

    $query
      ->update($db->quoteName( $this->getTableName() ))
      ->set   ($db->quoteName( $assetFieldAlias) . ' = ' . (int) $assetId )
      ->where ($db->quoteName( $this->getIdFieldName() ) . ' = ' . $db->quote( $this->getId() ));

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
      throw new AssetException( Text::_('COM_CAJOBBOARD_BEHAVIOUR_ASSETS_EXCEPTION_SAVE_ERROR') );
    }

    // Update our in-memory model representation with the asset_id property value
    $this->setFieldValue($assetFieldAlias, $assetId);
  }


  /**
   * Sets the level property on the current item's asset record
   *
   * @param   \Joomla\CMS\Table\Asset   $asset  The asset object for the item
   *
   * @return  DataModel   Returns $this for chaining
   */
  public function setAssetLevel(JAsset $asset)
  {
    $asset->level = 3;

    return $this;
  }


  /**
   * Sets the name property on the current item's asset record
   *
   * @param   \Joomla\CMS\Table\Asset   $asset  The asset object for the item
   *
   * @return  DataModel   Returns $this for chaining
   */
  public function setAssetName(JAsset $asset)
  {
    $asset->name = $this->getAssetName();

    return $this;
  }


  /**
   * Sets the parent ID for the current item's asset record, based on the category of the item.
   *
   * @param   \Joomla\CMS\Table\Asset   $asset  The asset object for the item
   *
   * @return  DataModel   Returns $this for chaining
   */
  public function setAssetParentId(JAsset $asset)
  {
    $asset->parent_id = $this->getAssetParentId();

    return $this;
  }


  /**
   * Sets rules property on the current item's asset record
   *
   * @param   \Joomla\CMS\Table\Asset   $asset  The asset object for the item
   *
   * @return  DataModel   Returns $this for chaining
   */
  public function setAssetRules(JAsset $asset)
  {
		if ($this->getRules() instanceof \JAccessRules)
		{
      $rules = $this->getRules();
    }
    else
    {
      // set the asset record's rules property to an empty object
      $rules = new Registry();
    }

    // Use Asset's method for setting rules
    $asset->setRules( json_encode($rules) );

    return $this;
  }


  /**
   * Sets the title property on the current model's asset record
   *
   * @param   \Joomla\CMS\Table\Asset   $asset  The asset object for the item
   *
   * @return  DataModel   Returns $this for chaining
   */
  public function setAssetTitle(JAsset $asset)
  {
    $asset->title = $this->getAssetTitle(); // getAssetTitle() is an alias to getAssetName()

    return $this;
  }


  /**
   * Binds rules from state to the current model model's $_rules property
   * 
   * @TODO: The intention in this method is to save the custom access rules in state, for the situation
   *        when a record is created but fails to save (validation, etc.). Custom access rules would
   *        be used by an Employer for example to grant access to a Recruiter. Need to rethink
   *        how this is being done to prevent model from accepting new rules from user input.
   *        Has associated Assets behaviour calling this from onAfterBind event. 
   *
   * Set the ACL rules for Custom Usergroup 123, when manipulating the Asset rules as an array:
   *
   * $rule_array['core.delete'][123] = 0;    // My custom usergroup cannot delete Content
   * $rule_array['core.edit'][123] = 1;      // My custom usergroup can edit Content
   */
  public function setModelRules($data)
  {
   	// Bind the rules.
		if (is_array($data) && isset($data['rules']) && is_array($data['rules']))
		{
      /*
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
      */

      throw new AssetException('Called setModelRules() in Model/Mixin/Asset with "rules" array set in $data, not implemented yet.');
    }
    else
    {
      $this->_rules = new Rules( array() );
    }
  }
}
