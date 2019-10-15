<?php
/**
 * FOF model behavior class for model validation. Called from Model/Mixin/Validation.php,
 * which adds an over-ridden check() method that provides onBeforeCheck, onCheck, and
 * onAfterCheck events. 
 *
 * @package   Calligraphic Job Board
 * @version   October 9, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Model\Behaviour;

use \Calligraphic\Cajobboard\Admin\Model\Exception\EmptyField;
use \Calligraphic\Cajobboard\Admin\Model\Exception\SearchEngineUnfriendlyTitleField;
use \FOF30\Event\Observer;
use \FOF30\Model\DataModel;
use \Joomla\CMS\Language\Text;

// no direct access
defined( '_JEXEC' ) or die;

/**
 * To override validation behaviour for a particular model, create a directory
 * named named after the model in the 'Behaviour' directory and use the same file
 * name as this behaviour ('Check.php'). The model file cannot go in this directory,
 * it must stay in the root Model folder.
 */
class Check extends Observer
{
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
	 * @param   DataModel  $model  The data model associated with this call, with the input $data already bound to it
	 */
	public function onCheck(DataModel $model)
	{
    $this->checkForEmptyRequiredFields($model);

    $this->checkForSearchEngineFriendlyTitle($model);
  }


  /**
   * Checks for empty fields that are declared as NOT NULL and don't have a default value
   *
   * @param   DataModel  $model  The data model associated with this call, with the input $data already bound to it
	 */
	protected function checkForEmptyRequiredFields(DataModel $model)
	{
		foreach ($model->getKnownFields() as $fieldName => $field)
		{
			if (
        // Never check the if the primary key is empty, an empty key is normal for new records
        $fieldName == $model->getIdFieldName() ||

        $model->hasSkipCheckField($fieldName) ||

        null !== $model->getFieldValue($fieldName)
      )
      {
        continue;
      }

      // Set a default value if the table SQL metadata has one set
      if (!is_null($field->Default))
      {
        $data[$fieldName] = $field->Default;

        continue;
      }

      // Throw an exception if the field is required, null, and doesn't have a default
      if ( isset($field->Null) && ($field->Null == 'NO') )
      {
        $modelItemName = $model->getContainer()->inflector->singularize( $model->getName() );

        $humanFieldName = strtolower( $model->getContainer()->inflector->humanize($fieldName) );

        throw new EmptyField( Text::sprintf('COM_CAJOBBOARD_EXCEPTION_NOT_NULL_MODEL_FIELD_EMPTY', strtolower($modelItemName), $humanFieldName));
      }
		}
  }


  /**
   * Checks that the title field or it's aliased field is search-engine friendly (e.g. length-limited to 60 characters)
   *
   * @param   DataModel  $model  The data model associated with this call, with the input $data already bound to it
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
      throw new SearchEngineUnfriendlyTitleField( Text::sprintf('COM_CAJOBBOARD_EXCEPTION_MODEL_FIELD_TITLE_IS_SEARCH_ENGINE_UNFRIENDLY', $length) );
    }

    $model->setFieldValue($fieldName, $sanitizedValue);
  }
}
