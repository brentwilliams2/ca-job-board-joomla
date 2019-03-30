<?php
/**
 * Answers Admin Controller
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Controller;

// Framework classes
use \FOF30\Container\Container;
use \FOF30\Controller\DataController;
use \FOF30\View\Exception\AccessForbidden;

// no direct access
defined('_JEXEC') or die;

class BaseController extends DataController
{
  // Overrides execute() to provide predefined tasks
  use Mixin\PredefinedTaskList;

  // @TODO: Make sure all tasks have similar error handling

	/*
	 * Overridden. Limit the tasks we're allowed to execute.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);

    $this->setPredefinedTaskList([
      'browse', 'read', 'edit', 'add',
      'apply', 'save', 'cancel',
      'archive', 'trash', 'delete',
      'feature', 'unfeature',
      'publish', 'unpublish'
    ]);
  }


  /**
	 * Unfeature selected item(s)
	 *
	 * @return  void
	 */
	public function feature()
	{
		// CSRF prevention
    $this->csrfProtection();

    try
    {
      $this->toggleFeatured(true);
    }
    catch (\Exception $error)
    {
      $this->setRedirect($this->getRedirectUrl(), $error, 'error');
    }

    $this->setRedirect($this->getRedirectUrl(), getRedirectFlashMsg('feature'), 'message');
  }


  /**
	 * Unfeature selected item(s)
	 *
	 * @return  void
	 */
	public function unfeature()
	{
		// CSRF prevention
    $this->csrfProtection();

    try
    {
      $this->toggleFeatured(false);
    }
    catch (\Exception $error)
    {
      $this->setRedirect($this->getRedirectUrl(), $error, 'error');
    }

    $this->setRedirect($this->getRedirectUrl(), getRedirectFlashMsg('unfeature'), 'message');
  }


  /**
	 * Toggle the 'feature' field value for the selected item(s)
   *
   * @param  bool $isFeatured   Whether this item should be set to featured, or unfeatured
	 *
	 * @return  void|string   Returns error message on exception
	 */
	public function toggleFeatured($isFeatured = false)
	{
    $model = $this->getModel()->savestate(false);
    $ids   = $this->getIDsFromRequest($model, false);

		try
		{
      $status = true;

			foreach ($ids as $id)
			{
				$model->find($id);
				$model->setFeaturedState($isFeatured);
			}
		}
		catch (\Exception $e)
		{
			return $e->getMessage();
    }
  }


  /**
	 * Get a redirect URL for the current view
	 *
	 * @return  string    The URL for use as a redirect
	 */
	public function getRedirectUrl()
	{
    if ($customURL = $this->input->getBase64('returnurl', ''))
    {
      $customURL = base64_decode($customURL);
    }

    $url = !empty($customURL) ? $customURL : 'index.php?option='
      . $this->container->componentName
      . '&view='
      . $this->container->inflector->pluralize($this->view)
      . $this->getItemidURLSuffix();

    return $url;
  }


  /**
	 * Get a message for the flash message box on redirect for this task
   *
   * @param   string    $task   The name of the task to generate a message for
	 *
	 * @return  string    The message to use in the flash message box after redirect
	 */
	public function getRedirectFlashMsg($task)
	{
    $textKey = strtoupper(
      $this->container->componentName
      . 'REDIRECT_MSG_VIEW_'
      . $this->container->inflector->singularize($this->view)
      . '_TASK_'
      . $task
    );

    return \JText::_($textKey);
  }
}
