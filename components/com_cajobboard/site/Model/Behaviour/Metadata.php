<?php
/**
 * FOF model behavior class to set the 'metadata' JSON field on record save
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
namespace Calligraphic\Cajobboard\Site\Model\Behaviour;

use \FOF30\Event\Observer;
use \FOF30\Model\DataModel;
use \Joomla\Registry\Registry;

// no direct access
defined( '_JEXEC' ) or die;

class Metadata extends Observer
{
  /**
	 * Add the metadata field to the fieldsSkipChecks list of the model. It
	 * should be empty so that we can fill it in through this behaviour.
	 *
	 * @param   DataModel  $model
	 */
	public function onBeforeCheck(DataModel $model)
	{
    $metadataField = $model->getFieldAlias('metadata');

    if ( $model->hasField($metadataField) )
    {
      $model->addSkipCheckField($metadataField);
    }
  }


  public function onBeforeSave(DataModel $model, &$data)
  {
    $metadataField = $model->getFieldAlias('metadata');

    if ( !$model->hasField($metadataField) )
		{
			return;
    }

    // Set 'metadata' field to new JRegistry object when save is for a new item (add task)
    if (!is_object($model->metadata) && (!$model->metadata instanceof Registry))
    {
      $model->metadata = new Registry();
    }

    // save() method doesn't save state to session by default, but redirect to edit()
    // after an apply() will call save() for checkIn and lose the transformed data
    // (model repopulates from state by default).

    $author = $model->input->get('metadata_author');

    if ($author)
    {
      $model->metadata->set('author', $author);
      $model->setState('author', $author);
    }

    $robots = $model->input->get('metadata_robots');

    if ($robots)
    {
      $model->metadata->set('robots', $robots);
      $model->setState('robots', $robots);
    }
  }
}
