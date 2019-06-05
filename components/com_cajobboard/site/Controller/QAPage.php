<?php
/**
 * Site Question and Answer Pages Controller
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Controller;

// Framework classes
use FOF30\Container\Container;
use FOF30\Controller\DataController;
use FOF30\View\Exception\AccessForbidden;

// no direct access
defined('_JEXEC') or die;

class QAPage extends DataController
{
	/**
	 * Overridden. Limit the tasks we're allowed to execute.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);

    $this->predefinedTaskList = [
      'default',
      'browse',
      'read',
      'edit',
      'add'
    ];
  }

	/**
	 * Make sure we create a unique slug for the comment before saving it.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function onBeforeApplySave($data)
	{
    // @TODO: Make sure the slug is unique
    $data->slug = JFilterOutput::stringURLSafe($data->name);
    $data->author = $this->container->platform->getUser()->id;


		return true;
  }
}

/*
try
{
    // Capture the output instead of pushing it to the browser
    @ob_start();

    // Render the other component's view
    FOF30\Container\Container::getInstance('com_cajobboard', array(
        'tempInstance' => true,
        'input' => array(
          'savestate'  => 0,
          'option'     => 'com_cajobboard',
          'view'       => 'Answers',
          'layout'     => 'itemized',
          'limit'      => 0,
          'limitstart' => 0,
          'user_id'    => JFactory::getUser()->id,
          'task'       => 'browse'
        )
    ))->dispatcher->dispatch();

    // Get the output...
    $content = ob_get_contents();
    // ...and close the output buffer
    ob_end_clean();
  }
  catch (\Exception $e)
  {
      // Whoops! The component blew up. Close the output buffer...
      ob_end_clean();

      // ...and indicate that we have no content.
      $content = '';

      // do some more error handling here
  }

  // Display the content
  echo $content;
*/
