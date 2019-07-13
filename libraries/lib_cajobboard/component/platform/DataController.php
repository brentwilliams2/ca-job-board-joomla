<?php
/**
 * Common class to use for Job Board Site and Admin BaseController classes
 *
 * Overrides task methods to rethrow exceptions when in debug mode
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Library\Platform;

// Framework classes
use \FOF30\Container\Container;

// no direct access
defined('_JEXEC') or die;

// @TODO: extend site and admin base controllers from FOF30 DataController, and delete this, when debugging no longer needed

class DataController extends \FOF30\Controller\DataController
{
/**
	 * Single record edit. The ID set in the request is passed to the model,
	 * then the form layout is used to edit the result.
	 *
	 * @return  void
	 */
	public function edit()
	{
		// Load the model
		/** @var DataModel $model */
    $model = $this->getModel()->savestate(false);

		if (!$model->getId())
		{
			$this->getIDsFromRequest($model, true);
    }

    $userId = $this->container->platform->getUser()->id;

		try
		{
			if ($model->isLocked($userId))
			{
				$model->checkIn($userId);
      }

			$model->lock();
		}
		catch (\Exception $e)
		{
      if (JDEBUG)
      {
        throw $e;
      }

			// Redirect on error
			if ($customURL = $this->input->getBase64('returnurl', ''))
			{
				$customURL = base64_decode($customURL);
      }

			$url = !empty($customURL) ? $customURL : 'index.php?option=' . $this->container->componentName.'&view=' . $this->container->inflector->pluralize($this->view) . $this->getItemidURLSuffix();

      $this->setRedirect($url, $e->getMessage(), 'error');

			return;
    }

		// Set the layout to form, if it's not set in the URL
		if ( empty($this->layout) || $this->layout == 'default' )
		{
			$this->layout = 'form';
		}

		// Get temporary data from the session, set if the save failed and we're redirected back here
    $sessionKey = $this->viewName . '.savedata';

    $itemData = $this->container->platform->getSessionVar($sessionKey, null, $this->container->componentName);

    $this->container->platform->setSessionVar($sessionKey, null, $this->container->componentName);

		if (!empty($itemData))
		{
			$model->bind($itemData);
		}

		// Display the view
		$this->display(in_array('edit', $this->cacheableTasks), $this->cacheParams);
	}


	/**
	 * Duplicates selected items
	 *
	 * @return  void
	 */
	public function copy()
	{
		// CSRF prevention
    $this->csrfProtection();

    $model = $this->getModel()->savestate(false);

    $ids = $this->getIDsFromRequest($model, true);

    $error = null;

		try
		{
      $status = true;

			foreach ($ids as $id)
			{
        $model->find($id);

				$model->copy();
			}
		}
		catch (\Exception $e)
		{
      if (JDEBUG)
      {
        throw $e;
      }

      $status = false;

			$error = $e->getMessage();
    }

		// Redirect
		if ($customURL = $this->input->getBase64('returnurl', ''))
		{
			$customURL = base64_decode($customURL);
    }

		$url = !empty($customURL) ? $customURL : 'index.php?option=' . $this->container->componentName . '&view=' . $this->container->inflector->pluralize($this->view) . $this->getItemidURLSuffix();

    if (!$status)
		{
			$this->setRedirect($url, $error, 'error');
		}
		else
		{
      $textKey = strtoupper($this->container->componentName . '_LBL_' . $this->container->inflector->singularize($this->view) . '_COPIED');

			$this->setRedirect($url, \JText::_($textKey));
		}
  }


  /**
   * Save the incoming data as a copy of the given model and then redirect to the copied object edit view
   *
   * @return  bool
   */
  public function save2copy()
  {
    // CSRF prevention
    $this->csrfProtection();

    $model = $this->getModel()->savestate(false);

    $ids = $this->getIDsFromRequest($model, true);

    $data   = $this->input->getData();

    unset($data[$model->getIdFieldName()]);

    $error = null;

    try
    {
      $status = true;

      foreach ($ids as $id)
      {
          $model->find($id);

          $model = $model->copy($data);
      }
    }
    catch (\Exception $e)
    {
      if (JDEBUG)
      {
        throw $e;
      }

      $status = false;

      $error = $e->getMessage();
    }

    // Redirect
    if ($customURL = $this->input->getBase64('returnurl', ''))
    {
      $customURL = base64_decode($customURL);
    }

    $url = !empty($customURL) ? $customURL : $url = 'index.php?option=' . $this->container->componentName . '&view=' . $this->view . '&task=edit&id=' . $model->getId() . $this->getItemidURLSuffix();

    if (!$status)
    {
      $this->setRedirect($url, $error, 'error');
    }
    else
    {
      $textKey = strtoupper($this->container->componentName . '_LBL_' . $this->container->inflector->singularize($this->view) . '_COPIED');

      $this->setRedirect($url, \JText::_($textKey));
    }
  }



}
