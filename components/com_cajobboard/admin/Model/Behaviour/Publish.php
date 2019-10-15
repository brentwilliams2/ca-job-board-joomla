<?php
/**
 * FOF model behavior class to set the publish_up field on new items.
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
namespace Calligraphic\Cajobboard\Admin\Model\Behaviour;

use \FOF30\Event\Observer;
use \FOF30\Model\DataModel;
use \Joomla\CMS\Application\ApplicationHelper;

// no direct access
defined( '_JEXEC' ) or die;


/**
 * To override validation behaviour for a particular model, create a directory
 * named named after the model in the 'Behaviour' directory and use the same file
 * name as this behaviour ('Check.php'). The model file cannot go in this directory,
 * it must stay in the root Model folder.
 */
class Publish extends Observer
{
	/**
	 * Add the publish_up field to the fieldsSkipChecks list of the model. It
	 * should be empty so that we can fill them in through this behaviour.
	 *
	 * @param   DataModel  $item
	 */
	public function onBeforeCheck(DataModel $item)
	{
    $publishUpField = $item->getFieldAlias('publish_up');

    if ( $item->hasField($publishUpField) )
    {
      $item->addSkipCheckField($publishUpField);
    }
	}


	/**
	 * Set the 'publish_up' field to the current date for 'add' tasks
	 *
	 * This event runs before the query used to create a new record is ran, and after $data
   * is bound to the model. The reference $data object is passed to Joomla!'s JDatabase
   * insertObject() method, so changes made to the model with setFieldValue() aren't seen
   * in the database record data.
	 *
	 * @param   DataModel  $item
	 * @param   \stdClass  $data
	 */
	public function onBeforeCreate(DataModel $item, &$data)
	{
    $publishUpField  = $item->getFieldAlias('publish_up');

		if ($item->hasField($publishUpField))
		{
      $nullDate = $item->getDbo()->getNullDate();

      $publishUp = $item->getFieldValue($publishUpField);

			if (empty($publishUp) || ($publishUp == $nullDate))
			{
        // Set an initial value in $data's 'publish_up' field
				$data->$publishUpField = $item->getContainer()->platform->getDate()->toSql( false, $item->getDbo() );
      }
		}
	}
}
