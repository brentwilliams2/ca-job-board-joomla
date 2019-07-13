<?php
/**
 * Site Review Controller
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

class Review extends DataController
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
	 * Pull a list of employers for user to choose from in the "Add Review" form.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function onBeforeAdd()
	{
    // @TODO: code for pulling employer list. Should this be here or in view class?
    // @TODO: check if user is a guest. Better place to do this to always catch it for all views?
    /*
    if ($guest)
    {
      // Joomla! requires the URL the user is redirected to after login to be base64 encoded
      $url = 'index.php?option=com_users&view=login&return=' . urlencode(base64_encode('index.php?option=com_cajobboard'));

      $this->setRedirect($url, $msg = null, 'message')->redirect();
    }
    */

		return true;
  }
}
