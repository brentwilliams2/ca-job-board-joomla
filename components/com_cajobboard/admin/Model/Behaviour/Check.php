<?php
/**
 * FOF model behavior class for model validation
 *
 * Checks for empty fields that are set to NOT NULL in the database table,
 * and if the field is empty and has a default value, set it.
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
namespace Calligraphic\Cajobboard\Admin\Model\Behaviour;

use \FOF30\Event\Observer;
use \FOF30\Model\DataModel;
use \Calligraphic\Cajobboard\Admin\Model\Exception\EmptyFieldException;

// no direct access
defined( '_JEXEC' ) or die;

/**
 * To override validation behaviour for a particular model, create a directory
 * named 'Behaviour' in a directory named after the model and use the same file
 * name as this behaviour ('Check.php'). Move the model file into the directory
 * without renaming it (e.g. 'Model/Answers/Answers.php)
 */
class Check extends Observer
{
  /**
	 * Add the category id field to the fieldsSkipChecks list of the model.
	 * it should be empty so that we can fill it in through this behaviour.
	 *
	 * @param   DataModel  $model
	 */
	public function onBeforeCheck(DataModel $model)
	{
    $this->checkForEmpty($model);
  }


  /**
	 * Checks for empty fields that are declared as NOT NULL and don't have a default value
	 *
	 * @param   DataModel  $model
	 */
	protected function checkForEmpty(DataModel $model)
	{
		foreach ($model->getKnownFields() as $fieldName => $field)
		{
			// Never check the key if it's empty; an empty key is normal for new records
			if ($fieldName == $model->idFieldName)
			{
				continue;
			}

			$value = $model->getFieldValue($fieldName);

			if (
        // Check if the table SQL is set to NOT NULL
        isset($field->Null) && ($field->Null == 'NO') &&

        // Check if the field is null
        empty($value) && !is_numeric($value) &&

        // Make sure the model's not set to skip checking for this field
        is_array($model->fieldsSkipChecks) && !in_array($fieldName, $model->fieldsSkipChecks)
      )
			{
        // Set a default value if the table SQL has one set
				if (!is_null($field->Default))
				{
					$model->setFieldValue($fieldName, $field->Default);

					continue;
				}

        $modelItemName = $model->getContainer()->inflector->singularize( $model->getName();

				throw new EmptyFieldException( Text::sprintf('COM_CAJOBBOARD_EXCEPTION_NOT_NULL_MODEL_FIELD_EMPTY'), $modelItemName, $fieldName );
			}
		}
  }
}


