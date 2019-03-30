<?php
/**
 * Site Registrations Controller
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
use JLog;

use Calligraphic\Cajobboard\Site\Helper\RegistrationHelper;

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
      'Register',
      'RegisterWithSocialAccount'
    ];
  }

	/**
	 * Runs before executing a task in the controller, overriden to keep from ACL check
   * with no area set. Seems like bug inController triggerEvent() method
	 *
	 * @param   string  $task  The task to execute
	 *
	 * @return  bool
	 */
	public function onBeforeExecute($task)
	{
    // Do any ACL? This runs for *any* task, even public ones
		return true;
  }

	/**
	 * Register user with an email address.
	 *
	 * @param   string  $task  The task to execute
	 *
	 * @return  bool
	 */
	public function Register()
	{
    /* Check captcha validity

      $input = JRequest::get('post');

      JPluginHelper::importPlugin('captcha');

      $dispatcher = JDispatcher::getInstance();

      $result = $dispatcher->trigger('onCheckAnswer',$input['recaptcha_response_field']);

      if(!$result[0]){
          die('Invalid Captcha Code');
      }

    */

    $RegistrationHelper = new RegistrationHelper($this->container);

    $model = $this->getModel();

    try
    {
      $RegistrationHelper->registerUser(
        $model->getState('email'),
        $model->getState('userName'),
        $model->getState('name'),
        $model->getState('language'),
        $model->getState('password')
      );
    }
    catch(\Exception $e)
    {
      $this->setRedirect('index.php?option=com_users&view=registration', $e, 'notice');
    }

    $this->setRedirect(JFactory::getURI()->toString(), JText::_('COM_CAJOBBOARD_REGISTRATION_SUCCESS'), 'notice');

    $this->redirect();
  }

	/**
	 * Register user with a social media account.
	 *
	 * @return  bool
	 */
	public function RegisterWithSocialAccount()
	{
    JLog::add('Registration controller, RegisterWithSocialAccount() method called', JLog::DEBUG, 'cajobboard');

    return true;
  }
}
