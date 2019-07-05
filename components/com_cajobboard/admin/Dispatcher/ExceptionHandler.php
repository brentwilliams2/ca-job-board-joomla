<?php
/**
 * Admin exception handler for component-level exceptions
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Dispatcher;

use FOF30\Container\Container;

// Exception classes to handle
use \Calligraphic\Cajobboard\Admin\Dispatcher\Exception\AccessForbidden;
use \Calligraphic\Cajobboard\Admin\Model\Exception\EmptyField;
use \Calligraphic\Cajobboard\Admin\Model\Exception\InvalidField;
use \Calligraphic\Cajobboard\Admin\Model\Exception\NoPermissions;
use \FOF30\Model\DataModel\Exception\RecordNotLoaded;

class ExceptionHandler
{
/**
	 * The current container
	 *
	 * @var Container
	 */
  protected $container;


	public function __construct (Container $container, array $config = array())
	{
    $this->container = $container;
  }


  /**
   * Handle exceptions caught in the component Dispatcher
   */
  public function handle (\Exception $e)
  {
    if ($this->container->platform->isCli() || JDEBUG)
    {
      throw $e;
    }

          /*
        Redirect logic:

        // set header
        $this->container->platform->setHeader('Pragma', 'public');

        If on edit, redirect to the item view if user is authorized, otherwise to browse view if user is authorized, otherwise to default view
        If on add, redirect to the browse view if user is authorized, otherwise to default view
        If on browse, redirect to the default view

        $url = $this->getName();
        $url = 'index.php?option=com_cajobboard&view='. Message . '&id=' . $this->get . '&task=edit';

        // Set a flash message with the problem and redirect to the last page
        $this->container->platform->redirect($url, '500', $e->getMessage(), 'error');

        // Set just a flash message
        Factory::getApplication()->enqueueMessage( Text::sprintf( 'COM_CAJOBBOARD_TASK_NOT_IN_LIST', $task ), 'error' );

        TaskNotAllowed

      */

      // Authorization and database loading errors
      if (
        $e instanceof AccessForbidden ||
        $e instanceof RecordNotLoaded
      )
      {

      }

      // Validation errors, redirect to edit form
      if (
        $e instanceof InvalidField ||
        $e instanceof EmptyField ||
      )
      {

      }

      // Mailer error, flash message only
      if ($e instanceof \phpmailerException)
      {

      }
  }

}
