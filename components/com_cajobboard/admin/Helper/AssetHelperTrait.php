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

namespace Calligraphic\Cajobboard\Admin\Helper;

// no direct access
defined('_JEXEC') or die;

use \Joomla\CMS\Log\Log;
use \Joomla\CMS\Table\Table;
use \Joomla\CMS\Table\Asset;
use \Joomla\Registry\Registry;
use \Joomla\CMS\Access\Rules;

trait AssetHelperTrait
{
  /**
	 * Overridden method to get the rules for the record from the $_rules property
	 *
	 * @return  Rules object
	 */
	public function getRules()
	{
    if (!$this->_rules)
    {
      $this->loadRules();
    }

		return $this->_rules;
  }


	/**
	 * Method to load this item's asset rules from the database and set the $_rules property with them
	 *
	 * @since   0.0.1
	 */
	public function loadRules()
	{
    // Get the \JDatabaseQuery object
    $db = $this->container->db;

    $query = $db->getQuery(true);

    $query->select($db->quoteName('rules'))
      ->from  ($db->quoteName('#__assets'))
      ->where ($db->quoteName('name') . ' = ' . $db->quote($this->getAssetName()));

    $db->setQuery($query);

    try
    {
      $assetRule = $db->loadResult();
    }
    catch (\Exception $e)
    {
      throw new \Exception("Error loading asset rules in loadRules() method of Asset Helper Trait:\n" . $e);
    }

		$this->setRules($assetRule);
  }


  /**
   * Update a JRegistry rules object with new rules
   *
   * @var     mixed      $rule     The rule to update e.g. 'core.edit', or an array of rules as array($rule => $value)
   * @var     string     $value    The value to set the rule to (false = denied, true = allowed, null = inherited)
   * @var     Registry   $asset    The existing rule from the #__assets table record that will be updated, if null an empty rule object is returned
   *
   * @return  Registry
   */
  public function updateRules($rule, $value = null, $asset = null)
  {
    // @TODO: This is for the "permissions" tab to update in admin views
  /*
    // Asset record rule values are Joomla! JRegistry objects
    $rules = new \JRegistry();

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
  }


	/**
	 * Overridden to return the JTableAsset object for this record, or an empty object if new
	 *
	 * @return Asset     Return a JTableAsset object
	 */
	protected function getAsset()
	{
    $assetModel = Table::getInstance('Asset');

    $assetModel->loadByName($this->getAssetName());

    return $assetModel;
  }


  /**
   * Get the primary key (id) value for the category that this item belongs to
   *
   * @returns   int         Returns the primary key (id) value for the category asset record
   *
   * @throws    \Exception  Throws if category doesn't have an asset record created for it
   */
  public function getCategoryAssetID()
  {
    $assetModel = Table::getInstance('Asset');

    // should look like: com_cajobboard.category.n where n is the number of the category
    $category = $this->container->componentName . '.category.' . $this->getFieldValue('cat_id');

    // load the data and bind for the category asset record
    $assetModel->loadByName('com_cajobboard.category.42'); // com_cajobboard.category.42

    $pk = $assetModel->id;

    if (!$pk)
    {
      throw new \Exception('This model\'s category doesn\'t have an asset record in #__assets');
    }

    return $pk;
  }


  /**
   * Create or save a single asset record with passed rules
   *
   * @param   JTableAsset   A model instance for the '#__assets' table
   *
   * @return  int   Returns the primary key value (`id`) for the asset record created
   *                in #__assets to store in item's `asset_id` foreign key field
   */
  public function saveAssetRecord($assetModel)
  {
    // @TODO: This is saving the asset with a parent ID of "0", instead of pointing to the category asset id. Should there be one category per model?
    // @TODO: Level is being set wrong, as "0" instead of "2"
    $assetModel->store();

    return $assetModel->id;
  }


  /**
   * Alias to saveAssetRecord()
   *
   * @param   Asset   A model instance for the '#__assets' table
   *
   * @return  int   Returns the primary key value (`id`) for the asset record created
   *                in #__assets to store in item's `asset_id` foreign key field
   */
  public function createAssetRecord($assetModel)
  {
    return $this->saveAssetRecord($assetModel);
  }


  /**
   * Remove an asset record for a given model
   *
   * @var     string  $modelName  The name of the model with records to remove asset rules for
   */
  public function removeAssetRecord()
  {
    // Get the \JDatabaseQuery object
    $db = $this->container->db;

    // Remove the item-level access control records from the '#__assets' table for this model
    $query = $db->getQuery(true);

    // Build a "LIKE" SQL clause to match asset records for this model
    $condition = array($db->quoteName('id') . ' = ' . $db->quote($this->getFieldValue('asset_id')));

    $query
      ->delete($db->quoteName('#__assets'))
      ->where($condition);

    $db->setQuery($query);

    try
    {
      $result = $db->execute();
    }
    catch (\Exception $e)
    {
      Log::add('Could not remove asset record for ' . $this->getTableName() . 'model, record number ' . $this->getId() . ': ' . $e, Log::DEBUG);
    }
  }
}
