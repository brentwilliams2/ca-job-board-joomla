<?php
/**
 * Exception handler for Multi Family Insiders Bootstrap V3 Template
 *
 * Removes Joomla!'s default exception handler (set in libraries/cms.php on line 71 as JErrorPage::render)
 * and error handlers (set in ./includes/framework.php on line 23 as JError::customErrorPage, which
 * calls ExceptionHandler::render() ). JErrorPage is aliased to class ExceptionHandler, which has a
 * static render() method.  JError methods are deprecated.
 *
 * @package     Calligraphic Job Board
 *
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC, (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

use \Joomla\CMS\Document\Document;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Log\Log;

// no direct access, make sure includes/defines.php loaded
defined('JPATH_PLATFORM') or die;

/**
 * Displays the Multi Family Insiders template's custom error page when an uncaught exception occurs.
 *
 * @since  1.0
 */
class MfiTemplateExceptionHandler
{
	/**
	 * Render the error page based on an exception.
	 *
	 * @param   \Throwable  $error  A Throwable (PHP 7+) object for which to render the error page.
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public static function render($error)
	{
    // Exception is the base class for all user exceptions in PHP 7
    // Exception and Error both implement the Throwable interface
		if ($error instanceof \Throwable)
		{
			try
			{
				// Try to log the error, but don't let the logging cause a fatal error
				try
				{
					Log::add(
						sprintf( 'Uncaught \Throwable of type %1$s thrown. Stack trace: %2$s', get_class($error), $error->getTraceAsString()	),
						Log::CRITICAL,
						'error'
					);
				}
				catch (\Throwable $e)
				{
					// Logging failed, continue exception handling
				}

        $app = Factory::getApplication();

				// If site is offline and it's a 404 error, just go to index (to see offline message, instead of 404)
				if ($error->getCode() == '404' && $app->get('offline') == 1)
				{
					$app->redirect('index.php');
        }

				$attributes = array(
					'charset'   => 'utf-8',
					'lineend'   => 'unix',
					'tab'       => "\t",
					'language'  => 'en-GB',
					'direction' => 'ltr',
        );

				// If there is a \JLanguage instance in Factory then let's pull the language and direction from its metadata
				if (Factory::$language)
				{
					$attributes['language']  = Factory::getLanguage()->getTag();
					$attributes['direction'] = Factory::getLanguage()->isRtl() ? 'rtl' : 'ltr';
        }

        $document = Document::getInstance('error', $attributes);

				if (!$document)
				{
					// We're probably in an CLI environment
					jexit($error->getMessage());
        }

				// Get the current template from the application
        $template = $app->getTemplate();

				// Push the error object into the document
        $document->setError($error);

				if (ob_get_contents())
				{
					ob_end_clean();
        }

				$data = $document->render(
					false,
					array(
						'template'  => $template,
						'directory' => JPATH_THEMES,
						'debug'     => JDEBUG,
					)
        );

        // If we reach this point, one of the following has happened:
        // (1) something erred in Joomla's rendering sequence; or
        // (2) something caused a return from the templates error.php page
        // Print the message from the Exception

				// Do not allow cache
        $app->allowCache(false);

				if (empty($data))
				{
          $data  = "Renderer failed, proceeding in the exception handler:\n";
					$data .= $error->getMessage();
        }

        $app->setBody($data);

        echo $app->toString();

        $app->close(0);

				// This return is needed to ensure the test suite does not trigger the non-Exception handling below
				return;
			}
			catch (\Throwable $e)
			{
				// Something failed in creating and rendering an error document, so pass the error down
			}
    }

		// This isn't an Exception, we can't handle it.
		if (!headers_sent())
		{
			header('HTTP/1.1 500 Internal Server Error');
    }

    echo  '<h1 class="text-center">Unrecoverable Error in Exception Handler</h1>';

		if ($error instanceof \Throwable)
		{
      // This is reached if unable to create and render an error document

      // Only display sensitive data in non-production environments, but config file
      // (to check $config->debug) may not have loaded when this point is reached
      // so use display_errors setting as a proxy for determining environment
			if (ini_get('display_errors'))
			{
        $html  = '<div class="well">';
        $html .= '<div>Type of error object: ' . get_class ($error) . '</div>';
        $html .= '<div>'. ucfirst ( $error->getMessage() ) . ' in file:</div>';
        $html .= '<div>'. $error->getFile() . ': line number ' . $error->getLine() . '</div>';
        $html .= '</div>';

        $html .= '<link rel="stylesheet" property="stylesheet" href="'. JUri::base() . '/media/jui/css/bootstrap.css">';

        $html .= <<<EOT
<table cellpadding="0" cellspacing="0" class="Table table table-striped table-bordered">
  <tr>
    <td colspan="3" class="TD">
      <strong>Call stack</strong>
    </td>
  </tr>

  <tr>
    <td class="TD">
      <strong>#</strong>
    </td>
    <td class="TD">
      <strong>Function</strong>
    </td>
    <td class="TD">
      <strong>Location</strong>
    </td>
  </tr>
EOT;

        foreach ($error->getTrace() as $k => $line)
        {
          $itemNumber = $k + 1;

          $html .= '<tr>';
          $html .= '<td class="TD">'. $itemNumber . '</td>';

          if ( isset($line['class']) )
          {
            $html .= '<td class="TD">'. $line['class'] . $line['type'] . $line['function'] . '()</td>';
          }
          else
          {
          $html .= '<td class="TD">' . $line['function'] . '()</td>';
          }

          if ( isset($line['file']) )
          {
            $html .= '<td class="TD">' . JHtml::_('debug.xdebuglink', $line['file'], $line['line']) . '</td>';
          }
          else
          {
          $html .= '<td class="TD">&#160;</td>';
          }

          $html .= '</tr>';
        }

        echo $html;
      }
    }

		jexit(1);
	}
}
