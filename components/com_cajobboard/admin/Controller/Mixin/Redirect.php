<?php
/**
 * Admin Redirect Controller Mixin
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Controller\Mixin;

use \FOF30\Container\Container;
use \Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;

trait Redirect
{
  /**
	 * Get a redirect URL for the current view
	 *
	 * @return  string    The URL for use as a redirect
	 */
	protected function getRedirectUrl()
	{
    if ($customURL = $this->input->getBase64('returnurl', ''))
    {
      $customURL = base64_decode($customURL);
    }

    $url = !empty($customURL) ? $customURL : 'index.php?option='
      . $this->container->componentName
      . '&view='
      . $this->container->inflector->pluralize($this->view)
      . $this->getItemidURLSuffix(); // e.g. '&Itemid=123' or an empty string if no Itemid

    return $url;
  }


  /**
	 * Get a message for the flash message box on redirect for this task
   *
   * @param   string    $task   The name of the task to generate a message for
	 *
	 * @return  string    The message to use in the flash message box after redirect
	 */
	protected function getRedirectFlashMsg($task)
	{
    $singularViewName = $this->container->inflector->singularize($this->view);
    $humanViewName = $this->container->inflector->humanize($singularViewName);

    // e.g. COM_CAJOBBOARD_REDIRECT_MSG_TASK_UNPUBLISH, in administrator en-GB.com_cajobboard_common.ini
    return Text::sprintf(strtoupper(
      $this->container->componentName
      . '_REDIRECT_MSG_TASK_'
      . $task
    ), $humanViewName);
  }
}
