<?php
/**
 * Email Messages Admin Controller
 *
 * @package   Calligraphic Job Board
 * @version   September 17, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

 namespace Calligraphic\Cajobboard\Admin\Controller;

// no direct access
defined('_JEXEC') or die;

use \Calligraphic\Cajobboard\Admin\Controller\BaseController;
use \Calligraphic\Cajobboard\Admin\Model\Exception\InvalidField;
use \Calligraphic\Cajobboard\Admin\Model\Exception\EmailNoSendByUser;
use \FOF30\Container\Container;
use \Joomla\CMS\Language\Text;

class EmailMessage extends BaseController
{
	/*
	 * Overridden. Limit the tasks that are allowed to execute.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);

    $this->setModelName('EmailMessages');

		// $this->resetPredefinedTaskList();

    $this->addPredefinedTaskList(array(
      'addByPersonId'
    ));
  }


  /**
	 * Handle sending an email message when we have the user's id to look up their email address with
	 *
	 * @return  void
	 */
  public function addByPersonId()
  {
    $recipientId = $this->input->get('recipient_id', '0');

    if ($recipientId)
    {
      $db = $this->container->db;

      $query = $db->getQuery(true);

      $query
        ->select('name', 'email', 'sendEmail')
        ->from($db->quoteName('#__users'))
        ->where($db->quoteName('id') . " = " . $db->quote($recipientId));

      $db->setQuery($query);

      $userInfo = $db->loadObject();

      if (!$userInfo->sendEmail)
      {
        throw new EmailNoSendByUser();
      }

      if (!$userInfo->name)
      {
        throw new InvalidField(Text::_('COM_CAJOBBOARD_EXCEPTION_CONTROLLER_EMAIL_MESSAGES_NO_NAME_IN_ADD_BY_PERSONS_ID_FIELD_INVALID'));
      }

      if (!$userInfo->email)
      {
        throw new InvalidField(Text::_('COM_CAJOBBOARD_EXCEPTION_CONTROLLER_EMAIL_MESSAGES_NO_EMAIL_IN_ADD_BY_PERSONS_ID_FIELD_INVALID'));
      }

      $model = $this->getModel();
      $model->setState('recipient__given_name', $userInfo->name);
      $model->setState('recipient__email', $userInfo->email);
    }

    $this->add();
  }
}