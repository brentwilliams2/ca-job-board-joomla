<?php
/**
 * Trait to provide a single place for core type of methods to use in both BaseDataModel and BaseTreeModel
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

trait Core
{
  // @TODO: File PR to add getKnownFields getter to DataModel.

  /*
   * Getter for known model fields, intended for use in site model behaviors.
   *
   * Core DataModel class has setter for known fields but no getter.
   */
  public function getKnownFields()
	{
    return $this->knownFields;
  }


  /**
	 * Method to check if view counts (hits, read / unread totals, etc.) should be incremented
	 *
	 * @return  bool  Returns true if the item should be incremented to indicate a new view of the item has occurred
	 */
  protected function shouldIncrementViewCounts()
  {
    // @TODO: exclude admin views of this item in shouldIncrementViewCounts() in BaseModel

    // @TODO: exclude views other than item views in shouldIncrementViewCounts() in BaseModel

    // @TODO: exclude bind called from save (maybe use a state property and onBeforeSave()?) in shouldIncrementViewCounts() in BaseModel

    // @TODO: exclude access forbidden or other aborts to an item view in shouldIncrementViewCounts() in BaseModel

    return false;
  }
}
