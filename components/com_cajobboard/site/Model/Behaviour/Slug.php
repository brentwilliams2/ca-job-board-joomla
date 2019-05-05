<?php
/**
 * Model behaviour to sort featured items at top of list
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
namespace Calligraphic\Cajobboard\Site\Model\Behaviour;

use \FOF30\Event\Observer;
use \FOF30\Model\DataModel;
use \Joomla\CMS\Application\ApplicationHelper;

// no direct access
defined( '_JEXEC' ) or die;

/**
 * FOF model behavior class to backfill the slug field with the
 * 'title' property or its fieldAlias if the slug field is empty.
 *
 * @TODO: Submit a PR, there is code for this in DataModel's check()
 *        method but it isn't handling field aliases correctly. See
 *        how $model->$slugfield is set below for solution.
 */
class Slug extends Observer
{
	/**
	 * Add the slug field to the fieldsSkipChecks list of the model. It
	 * should be empty so that we can fill them in through this behaviour.
	 *
	 * @param   DataModel  $model
	 */
	public function onBeforeCheck(DataModel $model)
	{
    $slugField = $model->getFieldAlias('slug');

    if ( $model->hasField($slugField) )
    {
      $model->addSkipCheckField($slugField);
    }
	}

	/**
	 * @param   DataModel  $model
	 * @param   \stdClass  $data
	 */
	public function onBeforeCreate(DataModel $model, &$data)
	{
		// Create a slug if there is a title and an empty slug
    $slugField  = $model->getFieldAlias('slug');
    $titleField = $model->getFieldAlias('title');

    if ($model->hasField($slugField) && $model->hasField($titleField) && !$model->$slugField)
    {
      // onBeforeCreate is called after data is bound to the model, so need to set on both
      $model->setFieldValue($slugField, ApplicationHelper::stringURLSafe( $model->getFieldValue($titleField) ));
      $data->$slugField = $model->getFieldValue($slugField);
    }
	}
}
