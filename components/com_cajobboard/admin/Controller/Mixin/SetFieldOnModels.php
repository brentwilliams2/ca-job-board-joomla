<?php
/**
 * Admin Controller Mixin to handle both XHR single-item and Joomla! 'cid' array of multi-item property updates
 *
 * @package   Calligraphic Job Board
 * @version   October 4, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Controller\Mixin;

// no direct access
defined('_JEXEC') or die;

use \Calligraphic\Cajobboard\Admin\Controller\Exception\SetFieldOnModels as SetFieldOnModelsException;
use \FOF30\Model\DataModel;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;

// NOTE: Depends on Trait \Calligraphic\Cajobboard\Admin\Controller\Mixin\Redirect

trait SetFieldOnModels
{
  /**
	 * Method for controller task methods (e.g. 'upvote') to call to update a model field in one of two scenarios:
   *
   * (1) As an XHR method to update a single item for a single field, e.g. user pushing an "upvote" button and in request as 'id' input parameter
   * (2) with a group of one or more IDs from the admin browse view, using the Joomla! button and the select checkboxes and in request as array in 'cid' input parameter
   *
   * This function will detect which scenario is applicable based on the presence of an 'id' field or not:
   * First scenario:  this function will save the updated value, and return a JSON response to the caller. Request uri must specify the correct Json view and template (Common)
   * Second scenario: this function will use a bulk SQL query-builder call to update the collection, and return a redirect to the updated browse view.
   *
   * @param   mixed       $fieldName    The name of the model field or alias to be updated. Should be the same as the Controller task name, so it can be used as a 'task' name.
   * @param   mixed       $value        The value to update the model collection's field to.
   * @param   bool        $oneTime      Whether the user should only perform this action a single time (like upvotes), or 
   * @param   \Closure    $callback     An anonymous function that is given the current value of the field, and should return the updated value
	 *
	 * @return  void|string   Returns error message on exception
	 */
	public function setFieldOnModels($fieldName, $value, $oneTime = false, \Closure $callback = null)
	{
    /*
     * @TODO: ToggleField Mixin had this text, but can't figure out where it's doing this. From Javascript? Or __call()?
     *
     * Toggle a field value for the selected item(s). Provide a method
     * in the model to toggle the field's state with a name in the format:
     * 
     *   setTasknameState(boolean $state)
     */

    $this->csrfProtection();

    $model = $this->getModel()->savestate(false);

    $alisedFieldName = $model->getFieldAlias($fieldName);

    $translationKey = strtoupper( $this->container->inflector->underscore($fieldName) );
    $humanizedKey = strtolower($this->container->inflector->humanize($fieldName) );

    $status = false;

    // First Scenario: XHR request
    $id = $model->getId();

    // Second Scenario: Records with selected checkboxes, sent from Joomla! button with 'cid' parameter in browse view
    $ids = $this->getIDsFromRequest($model, false);

    if ( $id && !in_array($id, $ids) )
    {
      array_push($ids, $id);
    }

    if (!$ids)
    {
      throw new SetFieldOnModelsException( Text::_('COM_CAJOBBOARD_EXCEPTION_SET_FIELD_ON_MODELS_NO_RECORDS_GIVEN') );
    }

    foreach ($ids as $id)
    {
      try
      {
        // Load the model data and get the old value
        $oldValue = $model
          ->find($id)
          ->getFieldValue($alisedFieldName);

        // Check if action is only allowed one time for the user, e.g. for 'downvote' field
        if ($oneTime)
        {
          $isAllowed = $this->oneTimeActionHandler($model, $fieldName);

          if (!$isAllowed)
          {
            throw new SetFieldOnModelsException( Text::sprintf('COM_CAJOBBOARD_EXCEPTION_SET_FIELD_ON_MODELS_ONE_TIME_ACTION_FAILURE', $humanizedKey) );
          }
        }

        // Run the callback if one is given
        if ($callback)
        {
          $value = $callback($oldValue);
        }

        // Set and save the new field value
        $status = $model
          ->setFieldValue($alisedFieldName, $value)
          ->applySave();
      }
      catch (\Exception $e)
      {
        throw new SetFieldOnModelsException( Text::_('COM_CAJOBBOARD_EXCEPTION_' . $translationKey . '_UPDATE_FAILURE') );
      }
    }

    // First Scenario: XHR request, return a JSON response
    if ($id)
    {
      // return a JSON response, works when the task name is the same as the database table field e.g. 'upvote_count'
      echo json_encode('{"' . $fieldName . '":"' . $value . '}');

      $this->container->platform->closeApplication();
    }
    // Second Scenario: Records with selected checkboxes, sent from Joomla! button with 'cid' parameter in browse view. Set redirect.
    elseif ($ids)
    {
      // e.g. COM_CAJOBBOARD_REDIRECT_MSG_TASK_UNFEATURE is translated for the flash message to show after redirect
      $msg = $this->getRedirectFlashMsg('unfeature');

      $this->setRedirect($this->getRedirectUrl(), $msg, 'message');

      return $status;
    }

    // No Scenario Matched
    return false;
  }


  /**
	 * Check the 'params' model field to see if the user's ID is already under the field's key
   * (e.g. 'downvote_count'). Returns false if already in the key's array. Adds the user's ID
   * to the key's array and returns true if the user's ID is not already in the key's array.
	 *
   * @param   DataModel   $modelInstance    The model instance to check for the user to perform an action on.
   * @param   string      $fieldName        The action to perform, as the model field name (e.g. 'downvote_count')
   *
	 * @return  bool  Returns true if the user has not already performed the task on the item.
	 */
	public function oneTimeActionHandler(DataModel $modelInstance, $fieldName)
	{
    $userId = $this->container->platform->getUser()->id;

    $alisedFieldName = $modelInstance->getFieldAlias($fieldName);

    /** @var \Joomla\Registry\Registry */
    $params = $modelInstance->getFieldValue();

    $idsArray = $params->get($fieldName);

    if (!$idsArray)
    {
      $idsArray = array();
    }

    if (in_array($userId, $idsArray))
    {
      return false;
    }

    array_push($idsArray, $userId);

    $params->set($fieldName, $idsArray);

    return true;
  }
}
