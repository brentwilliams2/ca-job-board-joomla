<?php
/**
 * Trait to patch the base archive method until PR merged.
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Model\Mixin;

use \FOF30\Model\DataModel\Exception\RecordNotLoaded;
use \Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;

trait Patches
{
  /**
	 * Adds a behaviour by its name. Over-ridden to escape forward slashes in the behaviour name.
	 *
	 * @param   string  $behaviour    The behaviour's name
	 *
	 * @return  $this  Self, for chaining
	 */
	public function addBehaviour($behaviour)
	{
    return parent::addBehaviour( str_replace( '/', '\\', $behaviour) );
	}


	/**
	 * Over-ridden method to archive the record, i.e. set enabled to -1.
	 *
	 * @return   $this  For chaining
	 *
	 * @TODO: Submit PR. DataModel is incorrectly setting the enabled property to 2 so archive method over-ridden here.
	 */
	public function archive()
	{
		if(!$this->getId())
		{
			throw new RecordNotLoaded( Text::_('COM_CAJOBBOARD_ARCHIVE_EXCEPTION_RECORD_NOT_LOADED') );
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


	/**
	 * Over-ridden method to compute the default name of the asset item (in table #__assets).
	 *
	 * @throws  NoAssetKey
	 *
	 * @return  string
	 *
	 * @TODO: Overridden to fix logic error. Submit PR. See BaseListModel and BaseTreeModel.
	 */
	public function getAssetName()
	{
		// If there is no assetKey defined, stop here, or we'll get a wrong name
		if (!$this->_assetKey)
		{
			throw new NoAssetKey;
		}

		// e.g. com_cajobboard.answer.2
		return $this->_assetKey . '.' . $this->getId();
  }
}
