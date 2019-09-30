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
use \Calligraphic\Cajobboard\Admin\Model\Exception\EmptyField;
use \Calligraphic\Cajobboard\Admin\Model\Exception\SearchEngineUnfriendlyTitleField;

// no direct access
defined( '_JEXEC' ) or die;

/**
 * To override validation behaviour for a particular model, create a directory
 * named 'Behaviour' in a directory named after the model and use the same file
 * name as this behaviour ('Check.php'). The model file cannot go in this directory,
 * it must stay in the root Model folder.
 */
class Check extends Observer
{
  use \Calligraphic\Cajobboard\Admin\Model\Mixin\Assertions;

  /**
   * Models that should require search-engine friendly page titles, e.g. sixty characters or less
   */
  public $sefFriendlyModels = array(
    'JobPostings',
    'Organizations'
  );


  /**
	 * Add the category id field to the fieldsSkipChecks list of the model.
	 * it should be empty so that we can fill it in through this behaviour.
	 *
	 * @param   DataModel  $model
	 */
	public function onCheck(DataModel $model)
	{
    $this->checkForEmpty($model);

    $this->checkForSearchEngineFriendlyTitle($model);
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

      // Get the value of the field, accounting for field aliases
      $value = $model->getFieldValue( $model->getFieldAlias($fieldName) );



			if (
        // Check if the table SQL is set to NOT NULL
        isset($field->Null) && ($field->Null == 'NO') &&

        // Check if the field is null
        empty($value) && !is_numeric($value) &&

        // Make sure the model's not set to skip checking for this field. Assumes real field
        // names (and not aliases) are used in the skip_checks configuration parameter.
        is_array($model->fieldsSkipChecks) && !in_array($fieldName, $model->fieldsSkipChecks)
      )
			{
        // Set a default value if the table SQL has one set
				if (!is_null($field->Default))
				{
					$model->setFieldValue($fieldName, $field->Default);

					continue;
				}

        $modelItemName = $model->getContainer()->inflector->singularize( $model->getName() );

				throw new EmptyField( Text::sprintf('COM_CAJOBBOARD_EXCEPTION_NOT_NULL_MODEL_FIELD_EMPTY'), $modelItemName, $fieldName );
			}
		}
  }


  /**
   * Checks that the title field or it's aliased field is search-engine friendly (e.g. length-limited to 60 characters)
   *
   * @param   DataModel  $model
	 */
	protected function checkForSearchEngineFriendlyTitle(DataModel $model)
	{
    // only check title field length on models that will be
    // shown in search results or shared on social networks
    if ( !in_array( $model->getName(), $this->sefFriendlyModels ) )
    {
      return;
    }

    $fieldName = $model->getFieldAlias('title');

    $fieldValue = $model->getFieldValue($fieldName);

    // Strip HTML from the title field
    $sanitizedValue = $model->getContainer()->input->getCmd($fieldValue, '');

    $length = strlen($sanitizedValue);

    if ( $length > 60 )
    {
      throw new SearchEngineUnfriendlyTitleField( Text::sprintf('COM_CAJOBBOARD_EXCEPTION_MODEL_FIELD_TITLE_IS_SEARCH_ENGINE_UNFRIENDLY'), $length );
    }

    $model->setFieldValue($fieldName, $sanitizedValue);
  }
}


