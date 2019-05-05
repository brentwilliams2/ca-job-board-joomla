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
use \FOF30\Model\DataModel;
use \FOF30\Model\DataModel\Exception\RecordNotLoaded;
use \Calligraphic\Cajobboard\Admin\Model\Exception\NoPermissionsException;

use \Joomla\CMS\Log\Log;

/**
 * Model class description
 */
class BaseModel extends DataModel
{
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\AssetHelper;

  /**
   * The Check behaviour is designed to run on the onAfterCheck event. Any
   * other behaviours interested in the Check events should run on onBeforeCheck.
   * The onAfterCheck event is not implemented in FOF30 DataModel as of May 2019.
   *
   * To override a behaviour for a particular model, create a directory
   * named 'Behaviour' in a child directory of a directory named after the model.
   * Move the model file into the directory without renaming it (e.g.
   * 'Model/Answers/Answers.php). Create a behaviour file named after the behaviour
   * it is overriding.
   *
	 * @return  static  Self, for chaining
	 *
	 * @throws \RuntimeException  When the data bound to this record is invalid
	 */
	public function check()
	{
		if (!$this->autoChecks)
		{
			return $this;
    }

    // Run custom events
    $this->triggerEvent('onBeforeCheck');

    // Run the check routine event
    $this->triggerEvent('onAfterCheck');

    return $this;
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
Log::add('In Base Model, getMetadataAttribute() called', Log::DEBUG, 'cajobboard');
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
Log::add('In Base Model, setMetadataAttribute() called. Return value: ' . $value->toString('JSON'), Log::DEBUG, 'cajobboard');
    // Return the data transformed to JSON
    return $value->toString('JSON');
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

    if ( !$this->isEditAuthorised() )
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
        $featured = $this->getFieldAlias('featured');
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
