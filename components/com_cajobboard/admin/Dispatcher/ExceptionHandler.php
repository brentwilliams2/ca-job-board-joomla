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

use \Calligraphic\Cajobboard\Admin\Dispatcher\Exception\PageNotFound;
use \FOF30\Container\Container;
use \FOF30\Controller\Exception\TaskNotFound;
use \FOF30\Download\Exception\DownloadError;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Log\Log;
use \Joomla\CMS\Router\Route;

// Exception classes to handle


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
    // Give the full stack trace when in debug mode
    if (JDEBUG)
    {
      throw $e;
    }

    // CLI scripts log the exception and die with an error code
    if ( $this->container->platform->isCli() )
    {
      Log::add('Exception occurred in a CLI script and caught in dispatcher exception handler: ' . $e->getMessage(), Log::ERROR);

      exit(1);
    }

    // controller methods correspond to tasks (e.g. 'edit'). They should provide their own exception
    // handling by catching view (and thus model) exceptions, setting a flash message, and redirecting.

    // log all exceptions for administrator review
    Log::add('Exception caught in dispatcher exception handler, file: ' . $e->getFile() . ' line: ' . $e->getLine() . ' message: ' . $e->getMessage() . ' stack trace: ' . $e->getTraceAsString(), Log::ERROR);

    // Mailer error, flash message only
    if ($e instanceof \phpmailerException)
    {
      $message = Text::_('COM_CAJOBBOARD_EXCEPTION_MAILER_GENERIC');
    }

    // Mailer error, flash message only
    elseif ($e instanceof DownloadError)
    {
      $message = Text::_('COM_CAJOBBOARD_EXCEPTION_CURL_GENERIC');
    }

    else
    {
      $message = Text::_('COM_CAJOBBOARD_EXCEPTION_GENERIC');
    }

    // use Joomla! flash messaging and redirect methods in case no
    // controller object available in job board dispatcher to set redirect
    $app = $this->container->platform->getApplication();

    $app->enqueueMessage($message, 'error');

    // Let Joomla! handle 'page not found' error on 404 code checked exceptions
    // and if the controller's execute() method throws TaskNotFound
    if ( $e->getCode() == '404' || $e instanceof TaskNotFound )
    {
      throw new PageNotFound();
    }

    // redirect to URL encoded in 'returnurl' query parameter if it is present
    elseif ( $customURL = $this->input->getBase64('returnurl', '') )
    {
      $url = Route::_( base64_decode($customURL) );
    }

    // redirect to job board default page if no other option, including unhandled 403 Access Forbidden errors
    else
    {
      $url = Route::_('index.php?option=com_cajobboard&view=default');
    }

    $app->redirect($url);
  }
}

/*
 * All controller task methods except 'edit' handle the 'returnurl' query parameter when it is passed in
 * the request.  The 'edit' task method handles it when checkIn() fails. Example creating the parameter:
 *
 *   $returnurl = urlencode(base64_encode(\JUri::getInstance()->toString()));
 *
 *   $ufl .= '&returnurl=' . $returnurl;
 */
