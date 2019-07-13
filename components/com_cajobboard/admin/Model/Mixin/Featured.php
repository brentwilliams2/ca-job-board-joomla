<?php
/**
 * Trait to toggle the 'feature' field value of an item.
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Model\Mixin;

use \Calligraphic\Cajobboard\Admin\Model\Exception\NoPermissions;
use \FOF30\Model\DataModel\Exception\RecordNotLoaded;
use \Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;

trait Featured
{
  /**
	 * If the item is locked by another user you need to have adequate ACL privileges to unlock it, i.e. core.admin
	 * or core.manage component-wide privileges; core.edit.state privileges component-wide or per asset; or be the
	 * creator of the item and have core.edit.own privileges component-wide or per asset.
	 *
	 * @return  $this
	 *
	 * @throws  RecordNotLoaded         If the database record for this ID can't be loaded
   * @throws  NoPermissions  If the user doesn't have permission to edit the record
   * @throws  \Exception               If there are database errors
	 */
	public function setFeaturedState($isFeatured)
	{
    // If there is no loaded record we can't proceed
		if ( !$this->getId() )
		{
			throw new RecordNotLoaded( Text::_('COM_CAJOBBOARD_SET_FEATURED_STATE_EXCEPTION_RECORD_NOT_LOADED') );
    }

    if ( !$this->isEditAuthorised() )
    {
      throw new NoPermissions($e);
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
}
