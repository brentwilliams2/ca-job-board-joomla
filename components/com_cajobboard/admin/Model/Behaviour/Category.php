<?php
/**
 * FOF model behavior class to set category in new records.
 * Sets the category to the category created for the model.
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
namespace Calligraphic\Cajobboard\Admin\Model\Behaviour;

use \Calligraphic\Cajobboard\Admin\Helper\Category as CategoryHelper;
use \FOF30\Event\Observer;
use \FOF30\Model\DataModel;
use \Joomla\CMS\Language\Text;

// no direct access
defined( '_JEXEC' ) or die;

class Category extends Observer
{
  /**
	 * Add the category id field to the fieldsSkipChecks list of the model.
	 * it should be empty so that we can fill it in through this behaviour.
	 *
	 * @param   DataModel  $item   The data model associated with this call
	 */
	public function onBeforeCheck(DataModel $item)
	{
    $categoryIdField = $item->getFieldAlias('cat_id');

    if ( $item->hasField($categoryIdField) )
    {
      $item->addSkipCheckField($categoryIdField);
    }
  }


	/**
	 * This event runs before the query used to create a new record is ran, and after $data
   * is bound to the model. The reference $data object is passed to Joomla!'s JDatabase
   * insertObject() method, so changes made to the model with setFieldValue() aren't seen
   * in the database record data.
	 *
	 * @param   DataModel           $item   The model which called this event
	 * @param   \stdClass           $data   A reference to the data object, consisting of model properties as property names
   *                                      and the values already transformed via attribute setters
	 *
	 * @return  void
	 */
  public function onBeforeCreate(DataModel $item, \stdClass &$data)
  {
    $categoryIdFieldAlias = $item->getFieldAlias('cat_id');

    // Sanity check, and return if the category ID field is already set from user input
    if ( !$item->hasField($categoryIdFieldAlias) || $data->$categoryIdFieldAlias )
		{
			return;
    }

    $categoryId = CategoryHelper::getItemRootCategoryId($item);

    $data->$categoryIdFieldAlias = $categoryId;
  }
}
