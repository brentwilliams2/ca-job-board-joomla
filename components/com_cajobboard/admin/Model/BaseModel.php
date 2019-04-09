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
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\RulesHelper;

  /**
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
   * Handle deleting the ACL record after an Answer record is deleted
   */
  protected function onBeforeDelete()
  {
    if ( $this->isAssetsTracked() )
    {
      $this->removeAssetRecord();
    }
  }


  /*
   * Handle updating ACL record after editing an Answer record
   */
  protected function onAfterUpdate()
  {
    if ( $this->isAssetsTracked() )
    {
      $this->setAssetRules();
    }
  }


  /*
   * Handle creating ACL record after creating a new Answer record
   */
  protected function onAfterCreate()
  {
    if ( $this->isAssetsTracked() )
    {
      $this->getAsset();

      $this->setAssetParentId();
      $this->setAssetName();
      $this->setAssetRules();

      $assetId = $this->saveAssetRecord();

      $this->setFieldValue('asset_id', $assetId);

      $this->saveItemAssetId($assetId);
    }
  }


  /*
   * Handle the 'metadata' JSON field
   */
  protected function onBeforeSave($data)
  {
    // Set 'metadata' field to new JRegistry object when save is for a new item (add task)
    if (!is_object($this->metadata) && (!$this->metadata instanceof Registry))
    {
      $this->metadata = new Registry();
    }

    // save() method doesn't save state by default, but redirect to edit() after an
    // apply() will call save() for checkIn and lose the transformed data (model
    // repopulates from state by default).

    $author = $this->input->get('metadata_author');

    if ($author)
    {
      $this->metadata->set('author', $author);
      $this->setState('author', $author);
    }

    $robots = $this->input->get('metadata_robots');

    if ($robots)
    {
      $this->metadata->set('robots', $robots);
      $this->setState('robots', $robots);
    }
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
    // Make sure it a JRegistry object, otherwise return the value
    if ( !($value instanceof Registry) )
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

    if (!$this->checkRecordEditACL())
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
