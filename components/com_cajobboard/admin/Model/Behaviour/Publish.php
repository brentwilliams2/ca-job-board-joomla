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
 * named 'Behaviour' in a directory named after the model and use the same file
 * name as this behaviour ('Publish.php'). The model file cannot go in this
 * directory, it must stay in the root Model folder.
 */
class Publish extends Observer
{
	/**
	 * Add the publish_up field to the fieldsSkipChecks list of the model. It
	 * should be empty so that we can fill them in through this behaviour.
	 *
	 * @param   DataModel  $model
	 */
	public function onBeforeCheck(DataModel $model)
	{
    $publishUpField = $model->getFieldAlias('publish_up');

    if ( $model->hasField($publishUpField) )
    {
      $model->addSkipCheckField($publishUpField);
    }
	}


	/**
	 * @param   DataModel  $model
	 * @param   \stdClass  $data
	 */
	public function onBeforeCreate(DataModel $model, &$data)
	{
    $publishUpField  = $model->getFieldAlias('publish_up');

		if ($model->hasField($publishUpField))
		{
      $nullDate = $model->getDbo()->getNullDate();

      $publishUp = $model->getFieldValue($publishUpField);

			if (empty($publishUp) || ($publishUp == $nullDate))
			{
        // onBeforeCreate is called after data is bound to the model, so need to set on both
        $model->setFieldValue($publishUpField, $model->getContainer()->platform->getDate()->toSql( false, $model->getDbo() ));
				$data->$publishUpField = $model->getFieldValue($publishUpField);
      }
		}
	}
}
