<?php
/**
 * Site Person Controller (for login)
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Controller;

use \FOF30\Container\Container;
use \FOF30\Controller\DataController;
use \FOF30\View\Exception\AccessForbidden;

// no direct access
defined('_JEXEC') or die;

class Registration extends Controller
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
      'Login',
      'LoginWithSocialAccount'
    ];
  }


	/**
	 * Login user
	 *
	 * @return  bool
	 */
	public function Login()
	{
    // @TODO: implement login in Person controller

    return true;
  }

	/**
	 * Login user with a social media account.
	 *
	 * @return  bool
	 */
	public function LoginWithSocialAccount()
	{
    // @TODO: implement login with social account in Person controller

    return true;
  }
}
