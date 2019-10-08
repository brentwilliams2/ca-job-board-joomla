<?php
/**
 * Answers Site Base Class for Controllers
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Controller;

// Framework classes
use \FOF30\Container\Container;
use \FOF30\Controller\DataController;

// no direct access
defined('_JEXEC') or die;

class BaseController extends DataController
{
  use \Calligraphic\Cajobboard\Admin\Controller\Mixin\Permissions;					// Overridden checkACL() method and utility methods
  use \Calligraphic\Cajobboard\Admin\Controller\Mixin\Redirect;							// Utilities for handling redirects in controller classes
  use \Calligraphic\Cajobboard\Admin\Controller\Mixin\PredefinedTaskList;   // Overrides execute() to provide predefined tasks
  use \Calligraphic\Cajobboard\Admin\Controller\Mixin\SetFieldOnModels;     // Method to handle XHR or Joomla! admin button bulk updates to a model property, e.g. 'upvote_count'

	/*
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);

    $this->addPredefinedTaskList( array(
      'add',
      'apply',
      'archive',
      'browse',
      'cancel',
      'edit',
      'publish',
      'read',
      'remove',
      'save',
      'savenew',
      'trash',
      'unpublish'
		));
  }


  /**
	 * Avoid default access permission check in Controller's triggerEvent method by implementing function
	 */
	protected function onBeforeEdit()
	{
		// Do ACL checks for user permission here, throw error if not authorized instead of dying quietly
		$result = $this->checkACL('core.edit') || $this->checkACL('core.edit.own');

		if (!$result)
		{
			throw new NoPermissions( Text::_('COM_CAJOBBOARD_EXCEPTION_NO_PERMISSION') );
		}

    return true;
  }


  /**
	 * Save the incoming data and then return to the Edit task
   *
   * @TODO: Over-ridden to prevent needing a translation key per view, and use sprintf instead. Submit PR to widen API with a callback $textKey param.
	 *
	 * @return  void
	 */
	public function apply()
	{
		// CSRF prevention
    $this->csrfProtection();

		// Redirect to the edit task
		if (!$this->applySave())
		{
			return;
    }

    $id = $this->input->get('id', 0, 'int');

    $humanViewNameSingular = $this->container->inflector->humanize( $this->container->inflector->singularize($this->view) );

    $textKey = strtoupper($this->container->componentName . '_LBL_SAVED');

		if ($customURL = $this->input->getBase64('returnurl', ''))
		{
			$customURL = base64_decode($customURL);
    }

    $url = !empty($customURL) ? $customURL : 'index.php?option=' . $this->container->componentName . '&view=' . $this->view . '&task=edit&id=' . $id . $this->getItemidURLSuffix();

		$this->setRedirect($url, \JText::sprintf($textKey, $humanViewNameSingular));
  }


	/**
	 * Duplicates selected items
   *
   * @TODO: Over-ridden to prevent needing a translation key per view, and use sprintf instead. Submit PR to widen API with a callback $textKey param.
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
      $humanViewNameSingular = $this->container->inflector->humanize( $this->container->inflector->singularize($this->view) );

      $textKey = strtoupper($this->container->componentName . '_LBL_COPIED');

			$this->setRedirect($url, \JText::sprintf($textKey, $humanViewNameSingular));
		}
  }


  /**
   * Delete or trash an item.
   *
   * @TODO: Over-ridden to prevent needing a translation key per view, and use sprintf instead. Submit PR to widen API with a callback $textKey param.
   *
   * @param boolean $forceDelete
   *
   * @return void
   */
  protected function deleteOrTrash($forceDelete = false)
	{
		// CSRF prevention
    $this->csrfProtection();

    $model = $this->getModel()->savestate(false);

    $ids = $this->getIDsFromRequest($model, false);

    $error = null;

		try
		{
      $status = true;

			foreach ($ids as $id)
			{
        $model->find($id);

        $userId = $this->container->platform->getUser()->id;

				if ($model->isLocked($userId))
				{
					$model->checkIn($userId);
        }

				if ($forceDelete)
				{
					$model->forceDelete();
				}
				else
				{
					$model->delete();
				}
			}
		}
		catch (\Exception $e)
		{
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
      $humanViewNameSingular = $this->container->inflector->humanize( $this->container->inflector->singularize($this->view) );

      $textKey = strtoupper($this->container->componentName . '_LBL_' . $this->container->inflector->singularize($this->view) . '_DELETED');

			$this->setRedirect($url, \JText::sprintf($textKey, $humanViewNameSingular));
		}
  }


	/**
	 * Save the incoming data and then return to the Browse task
   *
   * @TODO: Over-ridden to prevent needing a translation key per view, and use sprintf instead. Submit PR to widen API with a callback $textKey param.
	 *
	 * @return  void
	 */
	public function save()
	{
		// CSRF prevention
		$this->csrfProtection();

		if (!$this->applySave())
		{
			return;
    }

    $humanViewNameSingular = $this->container->inflector->humanize( $this->container->inflector->singularize($this->view) );

		$textKey = strtoupper($this->container->componentName . '_LBL_SAVED');

		if ($customURL = $this->input->getBase64('returnurl', ''))
		{
			$customURL = base64_decode($customURL);
		}

		$url = !empty($customURL) ? $customURL : 'index.php?option=' . $this->container->componentName . '&view=' . $this->container->inflector->pluralize($this->view) . $this->getItemidURLSuffix();

    $this->setRedirect($url, \JText::sprintf($textKey, $humanViewNameSingular));
	}
}
