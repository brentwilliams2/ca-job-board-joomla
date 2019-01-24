<?php
/**
 * Site ImageObject (Photos) Controller
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
use JFilterOutput;

// no direct access
defined('_JEXEC') or die;

class ImageObject extends DataController
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
