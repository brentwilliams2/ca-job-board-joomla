<?php
/**
 * Admin Controller Mixin for over-ridden CRUD methods to prevent
 * needing a translation key per view, and use sprintf instead.
 * Submit PR to widen API with a callback $textKey param.
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Controller\Mixin;

// no direct access
defined('_JEXEC') or die;

use \Calligraphic\Cajobboard\Admin\Controller\Exception\FeatureToggleFailure;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;

trait Sprintf
{
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

    if ($customURL = $this->input->getBase64('returnurl', ''))
    {
      $customURL = base64_decode($customURL);
    }

    $url = !empty($customURL) ? $customURL : 'index.php?option=' . $this->container->componentName . '&view=' . $this->view . '&task=edit&id=' . $id . $this->getItemidURLSuffix();

    $this->setRedirect($url, Text::sprintf('COM_CAJOBBOARD_LBL_SAVED', $humanViewNameSingular));
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

      $this->setRedirect($url, Text::sprintf('COM_CAJOBBOARD_LBL_COPIED', $humanViewNameSingular));
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

      $this->setRedirect($url, Text::sprintf('COM_CAJOBBOARD_LBL_DELETED', $humanViewNameSingular));
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

    if ($customURL = $this->input->getBase64('returnurl', ''))
    {
      $customURL = base64_decode($customURL);
    }

    $url = !empty($customURL) ? $customURL : 'index.php?option=' . $this->container->componentName . '&view=' . $this->container->inflector->pluralize($this->view) . $this->getItemidURLSuffix();

    $this->setRedirect($url, \JText::sprintf('COM_CAJOBBOARD_LBL_SAVED', $humanViewNameSingular));
  }
}