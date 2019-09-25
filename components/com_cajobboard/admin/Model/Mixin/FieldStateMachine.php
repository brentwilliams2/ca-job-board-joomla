<?php
/**
 * Trait to toggle a boolean field's value for an item.
 *
 * @package   Calligraphic Job Board
 * @version   July 5, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Model\Mixin;

use \Calligraphic\Cajobboard\Admin\Model\Exception\NoPermissions;
use \Calligraphic\Cajobboard\Admin\Model\Exception\FieldStateSetFailure;
use \FOF30\Model\DataModel\Exception\RecordNotLoaded;
use \Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;

trait FieldStateMachine
{
  /**
   * Toggle a boolean state field on the model (e.g. 'featured' between 'true' and 'false')
   *
	 * If the item is locked by another user you need to have adequate ACL privileges to unlock it, i.e. core.admin
	 * or core.manage component-wide privileges; core.edit.state privileges component-wide or per asset; or be the
	 * creator of the item and have core.edit.own privileges component-wide or per asset.
	 *
	 * @param   string    $fieldName    The name of the model field to toggle
   * @param   bool      $state        Whether this item should be set to true or false
	 *
	 * @throws  RecordNotLoaded         If the database record for this ID can't be loaded
   * @throws  NoPermissions           If the user doesn't have permission to edit the record
   * @throws  FieldStateSetFailure    If there are database errors
   *
   * @return  \FOF30\Model\DataModel  $this   for chaining
	 */
	public function setFieldState(string $fieldName, bool $state = false)
	{
    // If there is no loaded record we can't proceed
		if ( !$this->getId() )
		{
			throw new RecordNotLoaded( Text::_('COM_CAJOBBOARD_EXCEPTION_SET_STATE_RECORD_NOT_LOADED') );
    }

    if ( !$this->isEditAuthorised() )
    {
      throw new NoPermissions();
    }

		// We allow toggling the boolean field, even if the record is checked out (locked)
    try
    {
      $eventName = $state ? ucfirst($fieldName) : 'Un' . $fieldName;

      // Model or behaviour event handlers should be named like 'onBeforeFeatured'
      $this->triggerEvent('onBefore' . $eventName, array());

      if ($this->hasField($fieldName))
      {
        $field = $this->getFieldAlias($fieldName);

        // will use magic __set() method to set the property on the DataModel
        $this->$field = $state;

        $this->save();
      }

      // Model or behaviour event handlers should be named like 'onAfterFeatured'
      $this->triggerEvent('onAfter' . $eventName);

      return $this;
    }
    catch (\Exception $e)
    {
      throw new FieldStateSetFailure( Text::_('COM_CAJOBBOARD_EXCEPTION_SET_STATE_DATABASE_ERROR') );
    }
  }
}
