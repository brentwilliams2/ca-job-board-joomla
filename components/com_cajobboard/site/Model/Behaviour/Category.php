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
namespace Calligraphic\Cajobboard\Site\Model\Behaviour;

use \Calligraphic\Cajobboard\Admin\Helper\Category as CategoryHelper;
use \FOF30\Event\Observer;
use \FOF30\Model\DataModel;
use \Joomla\CMS\Log\Log;

// no direct access
defined( '_JEXEC' ) or die;

class Category extends Observer
{
  /**
	 * Add the category id field to the fieldsSkipChecks list of the model.
	 * it should be empty so that we can fill it in through this behaviour.
	 *
	 * @param   DataModel  $model
	 */
	public function onBeforeCheck(DataModel $model)
	{
    $categoryIdField = $model->getFieldAlias('cat_id');

    if ( $model->hasField($categoryIdField) )
    {
      $model->addSkipCheckField($categoryIdField);
    }
  }


	/**
	 * This event runs before the query used to create a new record is ran.
	 *
	 * @param   DataModel           $model  The model which called this event
	 * @param   JDatabaseQuery      &$data  The query we are manipulating
	 *
	 * @return  void
	 */
  public function onBeforeCreate(DataModel $model, &$data)
  {
    $categoryIdField = $model->getFieldAlias('cat_id');

    if ( !$model->hasField($categoryIdField) )
		{
			return;
    }

    $categoryId = null;
    $default = 0;

    $modelName = trim( implode(" ", preg_split( '/(?=[A-Z])/', $model->getName() )));

    // returns array  of objects ($category->id, $category->title, $category->language, $category->level)
    $categories = CategoryHelper::getCategories();

    foreach ($categories as $category)
    {
      if ( $category->title == $modelName )
      {
        $categoryId = $category->id;
        break;
      }

      if ('Uncategorised' == $category->title)
      {
        $default = $category->id;
      }
    }

    if ($categoryId)
    {
      // onBeforeCreate is called after data is bound to the model, so need to set on both
      $model->setFieldValue($categoryIdField, $categoryId);
    }
    else
    {
      $model->setFieldValue($categoryIdField, $default);
    }

    $data->$categoryIdField = $model->getFieldValue($categoryIdField);

    if ( !$categoryId )
    {
      Log::add('Model behaviour Category, onBeforeCreate() method, couldn\'t find a category for the record. Asset table $modelName searched for: ' . $modelName, Log::DEBUG, 'cajobboard');
    }
  }
}
