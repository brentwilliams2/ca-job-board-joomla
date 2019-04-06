<?php
/**
 * Base Admin Model for all Job Board Models
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c) 2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model;

// no direct access
defined('_JEXEC') or die;

use \Joomla\CMS\Log\Log;
use \Joomla\Registry\Registry;
use \Joomla\CMS\Filter\OutputFilter;
use \FOF30\Container\Container;
use \FOF30\Model\DataModel;
use \FOF30\Model\DataModel\Exception\RecordNotLoaded;
use \FOF30\Model\DataModel\Exception\NoTableColumns;
use \Calligraphic\Cajobboard\Admin\Model\Exception\NoPermissionsException;

/**
 * Model class description
 */
class BaseModel extends DataModel
{
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\AssetHelper;

  /**
	 * Public constructor. Overrides the parent constructor.
	 *
	 * @see DataModel::__construct()
	 *
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    // Parent constructor
    parent::__construct($container, $config);
  }


  /**
	 * Perform checks on data for validity
	 *
	 * @return  static  Self, for chaining
	 *
	 * @throws \RuntimeException  When the data bound to this record is invalid
	 */
	public function check()
	{
    // @TODO: Make sure a default category for com_cajobboard ({title, path, alias}=uncategorized)
    // exists in #__categories, and that the default category is set for this item if nothing else is set
    // Most categories are the same as their model name, except for Persons
    // (Connectors, Employers, Job Seekers, and Recruiters)

    // Make sure slug is populated from the title, if it is left empty
    if(!$this->slug)
    {
      $this->makeSlug();
    }

		parent::check();

    return $this;
  }


   /*
   * Handle creating ACL record after creating a new Answer record
   */
  protected function onAfterCreate()
  {
    if($this->isAssetsTracked())
    {
      // Get the JTableAsset object for this item's asset name
      $assetModel = $this->getAsset();

      // Get the ID of the parent asset object for this item
      $assetModel->parent_id = $this->getCategoryAssetID();
      $assetModel->name = $this->getAssetName();
      $assetModel->rules = (string) $this->getRules();

      $assetId = $this->saveAssetRecord($assetModel);

      $this->setFieldValue('asset_id', $assetId);

      $this->save();
    }
  }


  /*
   * Handle deleting the ACL record after an Answer record is deleted
   */
  protected function onAfterDelete()
  {
    $this->removeAssetRecord();
  }


  /*
   * Handle updating ACL record after editing an Answer record
   */
  protected function onAfterUpdate()
  {
    // @TODO: implement to check when the permissions page is changed on an admin edit screen
  }


  /*
   * Handle the 'metadata' JSON field
   */
  protected function onBeforeSave($data)
  {
    Log::add('onBeforeSave in model called', Log::DEBUG, 'cajobboard');
    // @TODO: author and robot fields are not handling JRegistry metadata field correctly.
    // Set 'metadata' field to new JRegistry object when save is for a new item (add task)
    if (!is_object($this->metadata) && (!$this->metadata instanceof Registry))
    {
      $this->metadata = new Registry();
    }

    $this->metadata->set('author', $this->input->get('metadata_author'));
    $this->metadata->set('robots', $this->input->get('metadata_robots'));
  }


  /**
	 * Transform 'metadata' field to a JRegistry object on bind
	 *
	 * @return  static  Self, for chaining
	 *
	 * @throws \RuntimeException  When the data bound to this record is invalid
	 */
  protected function getMetadataAttribute($value)
  {
    Log::add('getMetadataAttribute', Log::DEBUG, 'cajobboard');
    // Make sure it's not a JRegistry already
    if (is_object($value) && ($value instanceof Registry))
    {
        return $value;
    }

    // Return the data transformed to a JRegistry object
    return new Registry($value);
  }


  /**
	 * Transform 'metadata' field's JRegistry object to a JSON string before save
	 *
	 * @return  static  Self, for chaining
	 *
	 * @throws \RuntimeException  When the data bound to this record is invalid
	 */
  protected function setMetadataAttribute($value)
  {
    Log::add('setMetadataAttribute in model called', Log::DEBUG, 'cajobboard');
    // Make sure it a JRegistry object, otherwise return the value
    if (!is_object($value) || !($value instanceof Registry))
    {
      return $value;
    }

    // Return the data transformed to JSON
    return $value->toString('JSON');
  }


  /**
	 * Create a slug from the answer title
	 *
	 * @return  static  Self, for chaining
	 *
	 * @throws \RuntimeException  When the data bound to this record is invalid
	 */
  protected function makeSlug()
  {
    $this->slug = OutputFilter::stringURLSafe($this->name);
  }


	/**
	 * Toggle the 'feature' field value of an item.
   *
	 * If the item is locked by another user you need to have adequate ACL privileges to unlock it, i.e. core.admin
	 * or core.manage component-wide privileges; core.edit.state privileges component-wide or per asset; or be the
	 * creator of the item and have core.edit.own privileges component-wide or per asset.
	 *
	 * @return  $this
	 *
	 * @throws  RecordNotLoaded         If the database record for this ID can't be loaded
   * @throws  NoPermissionsException  If the user doesn't have permission to edit the record
   * @throws  \Exception               If there are database errors
	 */
	public function setFeaturedState($isFeatured)
	{
    // If there is no loaded record we can't proceed
		if (!$this->getId())
		{
			throw new RecordNotLoaded("Can't feature without a loaded DataModel");
    }

    if (!$this->checkRecordACL())
    {
      throw new NoPermissionsException($e);
    }

		// We allow toggling the 'feature' field, even if the record is checked out (locked)
    try
    {
      $event = $isFeatured ? 'Feature' : 'Unfeature';

      $this->triggerEvent('onBefore' . $event, array());

      if ($this->hasField('featured'))
      {
        $featured        = $this->getFieldAlias('featured');
        $this->$featured = $isFeatured;
      }

      $this->save();

      $this->triggerEvent('onAfter' . $event);

      return $this;
    }
    catch (\Exception $e)
    {
      throw new \Exception($e);
    }
  }


  /**
	 * Check ACL for this model item
	 *
	 * @return  bool   True if user has permissions
	 */
	public function checkRecordACL()
	{
		// Get the component privileges
		$platform = $this->container->platform;
    $component = $this->container->componentName;

		$privileges = array
		(
			'editown'	   => $platform->authorise('core.edit.own'  , $component),
			'editstate'	 => $platform->authorise('core.edit.state', $component),
			'admin'	     => $platform->authorise('core.admin'     , $component),
			'manage'	   => $platform->authorise('core.manage'    , $component),
    );

		// If we are tracking assets get the item's privileges
		if ($this->isAssetsTracked())
		{
      $assetKey = $this->getAssetKey();

			$assetPrivileges = array
			(
				'editown'	   => $platform->authorise('core.edit.own'  , $assetKey),
				'editstate'	 => $platform->authorise('core.edit.state', $assetKey),
      );

			foreach ($assetPrivileges as $k => $v)
			{
				$privileges[$k] = $privileges[$k] || $v;
			}
    }

    $owner = 0;

		if ($this->hasField('created_by'))
		{
			$owner = $this->getFieldValue('created_by');
    }

    // Owner of the record and have core.edit.own privilege is allowed
    $ownerCanEditOwn = $privileges['editown'] && ($owner == $this->created_by);

		// Super User, component manager or user allowed to edit the state of records are allowed
    if ( $ownerCanEditOwn || $privileges['admin'] || $privileges['manage'] || $privileges['editstate'])
    {
      return true;
    }

    return false;
  }


	/**
	 * Archive the record, i.e. set enabled to -1.
   * @TODO: Submit PR. DataModel is incorrectly setting this value to 2 so method over-ridden here.
	 *
	 * @return   $this  For chaining
	 */
	public function archive()
	{
		if(!$this->getId())
		{
			throw new RecordNotLoaded("Can't archive a not loaded DataModel");
    }

		if (!$this->hasField('enabled'))
		{
			return $this;
    }

    $this->triggerEvent('onBeforeArchive', array());

    $enabled = $this->getFieldAlias('enabled');

    $this->$enabled = -1;

    $this->save();

    $this->triggerEvent('onAfterArchive');

		return $this;
	}
}
