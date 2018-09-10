<?php
/**
 * Registration Helpers
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 *            Copyright (c) 2011-2018 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Helper;

// Framework classes
use FOF30\Container\Container;
use FOF30\Params\Params;
use JApplicationHelper;
use JComponentHelper;
use JDate;
use JEventDispatcher;
use JFactory;
use JRoute;
use JStringPunycode;
use JText;
use JUri;
use JUser;
use JUserHelper;
use RuntimeException;
use UnexpectedValueException;
use JLog;

// no direct access
defined('_JEXEC') or die;

class RegistrationHelper
{
	/** @var Container */
  private $container;

  /**
  * Whether users are allowed to self-register
  *
  * @param boolean $allowUserRegistration
  */
  public $allowUserRegistration;

  /**
  * Default group applied to new users registering from the front-end.
  *
  * @param array $defaultUserGroups
  */
  public $defaultUserGroups;

  /**
  * Minimum length of password
  *
  * @param int $minPasswordLength
  */
  public $minPasswordLength;

  /**
  * Minimum number of integers in password
  *
  * @param int $minNumberOfIntegers
  */
  public $minNumberOfIntegers;

  /**
  * Minimum number of uppercase alpha characters in password
  *
  * @param int $minNumberOfUppercase
  */
  public $minNumberOfUppercase;

  /**
  * If yes the user's first password will be sent to the user as part of the registration email
  *
  * @param boolean $sendPasswordInEmail
  */
  public $sendPasswordInEmail;

  /**
  * 0/none, user registered immediately; 1/Self, user sent email; 2/Administrator, user has to be approved by admin
  *
  * @param int $userActivation
  */
  public $userActivation;

  /**
  * Whether notification email is sent to admins
  *
  * @param boolean $mailToAdmin
  */
  public $sendEmailToAdmin;

  /**
  * Captcha plugin used in the registration, password, and username reminder forms
  *
  * @param string $captcha
  */
  public $captcha;

  /**
  * Whether users can select front-end language preference when registering
  *
  * @param boolean $chooseLanguage
  */
  public $chooseLanguage;

  /**
  * Text added in front of each mail Subject field
  *
  * @param string $mailSubjectPrefix
  */
  public $mailSubjectPrefix;

  /**
  * Text added after the mail Body text
  *
  * @param string $mailBodySuffix
  */
  public $mailBodySuffix;


	 /**
	 * Public constructor
	 *
	 * @var   bool
	 *
	 * @since 0.0.1
	 */
	public function __construct(Container $container)
	{
    $this->container = $container;

    $usersConfig = Container::getInstance('com_users')->params;

    $allowUserRegistration  = $usersConfig->get('allowUserRegistration');
    $defaultUserGroup       = $usersConfig->get('new_usertype');
    $minPasswordLength      = $usersConfig->get('minimum_length');
    $minNumberOfIntegers    = $usersConfig->get('minimum_integers');
    $minNumberOfUppercase   = $usersConfig->get('minimum_uppercase');
    $sendPasswordInEmail    = $usersConfig->get('sendpassword');
    $userActivation         = $usersConfig->get('useractivation');
    $sendEmailToAdmin       = $usersConfig->get('mail_to_admin');
    $captcha                = $usersConfig->get('captcha');
    $chooseLanguage         = $usersConfig->get('site_language');
    $mailSubjectPrefix      = $usersConfig->get('mailSubjectPrefix');
    $mailBodySuffix         = $usersConfig->get('mailBodySuffix');
	}


	/**
	 * Create a new user account.
   *
	 * If the user name is invalid, method throws an UnexpectedValueException. Any other error from the
   * model should result in a RuntimeException.
	 *
	 * @param   string $email           The email address of the user to create
	 * @param   string $userName        Screen name to use for the user
   * @param   string $name            The full name of the user
   * @param   string $language        The language to set for the user
   * @param   string $password        The user's password
	 *
	 * @return  array  ($activation, $userID) where $activation 'useractivate', 'adminactivate' if activation is
	 *                 required, null otherwise; $userID is the generated user ID
	 *
	 * @throws  UnexpectedValueException  If the email or username already exists
	 * @throws  RuntimeException          User registration is disabled and $forceActivate is false
	 */
	public function registerUser($email, $userName, $name, $language, $password)
	{
		// Check if front-end registration is allowed
  	if ($this->allowUserRegistration == 0)
		{
			throw new RuntimeException(JText::_('COM_CAJOBBOARD_REGISTRATION_USER_NAME_EXISTS'));
		}

    // Make sure email is present and not already in use
    // @TODO Validate email address
		if (empty($email) || $this->checkForExistingEmail($email))
		{
			throw new UnexpectedValueException();
		}

		// Load com_users language files
		$lang = $this->container->platform->getLanguage();
		$lang->load('com_users', JPATH_BASE . '/components/com_users', 'en-GB', false, false);
		$lang->load('com_users', JPATH_BASE, 'en-GB', false, false);
		$lang->load('com_users', JPATH_BASE . '/components/com_users', null, false, false);
		$lang->load('com_users', JPATH_BASE, null, false, false);

		$data = array(
			'name'     => $name,
			'username' => $this->validateUserName($userName),
			'password' => $password,
			'email'    => '',
      'groups'   => $this->defaultUserGroup,
      'language' => $language
		);

		// Initialise the table with JUser.
		$user = new JUser;

		// If no password was specified create a random one
		if (!isset($data['password']) || empty($data['password']))
		{
			$data['password'] = JUserHelper::genRandomPassword(8);
		}

		// Convert the email to punycode if necessary
		$data['email'] = JStringPunycode::emailToPunycode($email);

		/**
		 * Get the dispatcher and load the users plugins.
		 *
		 * IMPORTANT: We cannot go through the JApplicationCms object directly since user plugins will set the error
		 * message on the dispatcher instead of throwing an exception. See the plugins/user/profile/profile.php plugin
		 * file's onContentPrepareData method to understand this questionable approach. Until Joomla! stops supporting
		 * legacy error handling we cannot switch to the FOF Platform's runPlugins and a regular exceptions handler around it
		 */
    $dispatcher = JEventDispatcher::getInstance();

		$this->container->platform->importPlugin('user');

		// Trigger the data preparation event.
		try
		{
			$results = $dispatcher->trigger('onContentPrepareData', array('com_users.registration', $data));
		}
		catch (\Exception $e)
		{
			throw new RuntimeException($e->getMessage());
		}

		// Check for errors encountered while preparing the data.
		if (count($results) && in_array(false, $results, true))
		{
			throw new RuntimeException($dispatcher->getError());
		}

		// Check if the user needs to activate their account.
		if (($this->userActivation == 1) || ($this->userActivation == 2))
		{
			$data['activation'] = JApplicationHelper::getHash(JUserHelper::genRandomPassword());
			$data['block']      = 1;
		}

		// Set the user parameters
		$data['params'] = array();

		// Bind the data.
		if (!$user->bind($data))
		{
			throw new RuntimeException(JText::sprintf('COM_USERS_REGISTRATION_BIND_FAILED', $user->getError()));
		}

		// Store the data.
		if (!$user->save())
		{
			throw new RuntimeException(JText::sprintf('COM_USERS_REGISTRATION_SAVE_FAILED', $user->getError()));
		}

    $app = JFactory::getApplication();

		// Compile the notification mail values.
		$data             = $user->getProperties();
		$data['fromname'] = $app->get('fromname');
		$data['mailfrom'] = $app->get('mailfrom');
		$data['sitename'] = $app->get('sitename');
    $data['siteurl']  = JUri::base();

    // Get the base URI
		$liveSite = trim($app->get('live_site', ''));

		// If the live_site is not set in Global Configuration get it from the component's configuration options
		if (empty($liveSite))
		{
			$liveSite = $this->container->params->get('siteurl');
		} // @TODO What if siteurl is empty here?

		$uri  = JUri::getInstance($liveSite);
		$base = $uri->toString(array('scheme', 'user', 'pass', 'host', 'port'));

		$db     = $this->container->db;
		$query  = $db->getQuery(true);

		// Handle account activation/confirmation emails.
		$isAdmin = $this->container->platform->isBackend();

		switch ($this->userActivation)
		{
			// Self-activation of user account
			default:
			case 2:
				// Set the link to confirm the user email.
				$data['activate'] = $base . JRoute::_('index.php?option=com_users&task=registration.activate&token=' . $data['activation'], false);

				// Remove administrator/ from activate url in case this method is called from admin
				if ($isAdmin)
				{
					$adminPos         = strrpos($data['activate'], 'administrator/');
					$data['activate'] = substr_replace($data['activate'], '', $adminPos, 14);
				}

				$emailSubject = JText::sprintf(
					'COM_USERS_EMAIL_ACCOUNT_DETAILS',
					$data['name'],
					$data['sitename']
				);

				$emailBody = JText::sprintf(
					'COM_USERS_EMAIL_REGISTERED_WITH_ADMIN_ACTIVATION_BODY_NOPW',
					$data['name'],
					$data['sitename'],
					$data['activate'],
					$data['siteurl'],
					$data['username']
				);

				if ($this->sendPasswordInEmail)
				{
					$emailBody = JText::sprintf(
						'COM_USERS_EMAIL_REGISTERED_WITH_ADMIN_ACTIVATION_BODY',
						$data['name'],
						$data['sitename'],
						$data['activate'],
						$data['siteurl'],
						$data['username'],
						$data['password_clear']
					);
				}
				break;

			// Administrator activation of user account
			case 1:
				// Set the link to activate the user account.
				$data['activate'] = $base . JRoute::_('index.php?option=com_users&task=registration.activate&token=' . $data['activation'], false);

				// Remove administrator/ from activate url in case this method is called from admin
				if ($isAdmin)
				{
					$adminPos         = strrpos($data['activate'], 'administrator/');
					$data['activate'] = substr_replace($data['activate'], '', $adminPos, 14);
				}

				$emailSubject = JText::sprintf(
					'COM_USERS_EMAIL_ACCOUNT_DETAILS',
					$data['name'],
					$data['sitename']
				);

				$emailBody = JText::sprintf(
					'COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY_NOPW',
					$data['name'],
					$data['sitename'],
					$data['activate'],
					$data['siteurl'],
					$data['username']
				);

				if ($this->sendPasswordInEmail)
				{
					$emailBody = JText::sprintf(
						'COM_USERS_EMAIL_REGISTERED_WITH_ACTIVATION_BODY',
						$data['name'],
						$data['sitename'],
						$data['activate'],
						$data['siteurl'],
						$data['username'],
						$data['password_clear']
					);
				}

				break;

			// No activation required
			case 0:
				$emailSubject = JText::sprintf(
					'COM_USERS_EMAIL_ACCOUNT_DETAILS',
					$data['name'],
					$data['sitename']
				);

				$emailBody = JText::sprintf(
					'COM_USERS_EMAIL_REGISTERED_BODY_NOPW',
					$data['name'],
					$data['sitename'],
					$data['siteurl']
				);

				if ($this->sendPasswordInEmail)
				{
					$emailBody = JText::sprintf(
						'COM_USERS_EMAIL_REGISTERED_BODY',
						$data['name'],
						$data['sitename'],
						$data['siteurl'],
						$data['username'],
						$data['password_clear']
					);
				}

				break;
		}

		// Send the registration email.
		$return = JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $data['email'], $emailSubject, $emailBody);

		// Send Notification mail to administrators
		if (($this->userActivation < 2) && ($this->sendEmailToAdmin == 1))
		{
			$emailSubject = JText::sprintf(
				'COM_USERS_EMAIL_ACCOUNT_DETAILS',
				$data['name'],
				$data['sitename']
			);

			$emailBodyAdmin = JText::sprintf(
				'COM_USERS_EMAIL_REGISTERED_NOTIFICATION_TO_ADMIN_BODY',
				$data['name'],
				$data['username'],
				$data['siteurl']
			);

			// Get all admin users
      $query
        ->clear()
        ->select($db->quoteName(array('name', 'email', 'sendEmail')))
        ->from($db->quoteName('#__users'))
        ->where($db->quoteName('sendEmail') . ' = 1')
        ->where($db->quoteName('block') . ' = 0');

			$db->setQuery($query);

			try
			{
				$rows = $db->loadObjectList();
			}
			catch (RuntimeException $e)
			{
				throw new RuntimeException(JText::sprintf('COM_USERS_DATABASE_ERROR', $e->getMessage()), 500);
			}

			// Send mail to all Super Users
			foreach ($rows as $row)
			{
				$return = JFactory::getMailer()->sendMail($data['mailfrom'], $data['fromname'], $row->email, $emailSubject, $emailBodyAdmin);

				// Check for an error.
				if ($return !== true)
				{
					throw new RuntimeException(JText::_('COM_USERS_REGISTRATION_ACTIVATION_NOTIFY_SEND_MAIL_FAILED'));
				}
			}
		}

		// Check for an error.
		if ($return !== true)
		{
			// Send a system message to administrators receiving system mails
			$db = JFactory::getDbo();
      $query
        ->clear()
        ->select($db->qn('id'))
        ->from($db->qn('#__users'))
        ->where($db->qn('block') . ' = ' . (int) 0)
        ->where($db->qn('sendEmail') . ' = ' . (int) 1);

			$db->setQuery($query);

			try
			{
				$userids = $db->loadColumn();
			}
			catch (RuntimeException $e)
			{
				throw new RuntimeException(JText::sprintf('COM_USERS_DATABASE_ERROR', $e->getMessage()), 500);
			}

			if (count($userids) > 0)
			{
				$jdate = new JDate;

				// Build the query to add the messages
				foreach ($userids as $userid)
				{
					$values = array(
						$db->quote($userid),
						$db->quote($userid),
						$db->quote($jdate->toSql()),
						$db->quote(JText::_('COM_USERS_MAIL_SEND_FAILURE_SUBJECT')),
						$db->quote(JText::sprintf('COM_USERS_MAIL_SEND_FAILURE_BODY', $return, $data['username'])),
					);
					$query->clear()
					      ->insert($db->quoteName('#__messages'))
					      ->columns($db->quoteName(array(
						      'user_id_from',
						      'user_id_to',
						      'date_time',
						      'subject',
						      'message',
					      )))
                ->values(implode(',', $values));

					$db->setQuery($query);

					try
					{
						$db->execute();
					}
					catch (RuntimeException $e)
					{
						throw new RuntimeException(JText::sprintf('COM_USERS_DATABASE_ERROR', $e->getMessage()), 500);
					}
				}
			}

			throw new RuntimeException(JText::_('COM_USERS_REGISTRATION_SEND_MAIL_FAILED'));
		}

		if ($this->userActivation == 1)
		{
			return array('useractivate', $user->id);
		}
		elseif ($this->userActivation == 2)
		{
			return array('adminactivate', $user->id);
		}
		else
		{
			return array(null, $user->id);
		}
  }

	/**
	 * Returns the user ID, if a user exists, given an email address.
	 *
	 * @param   string $email The email to search on.
	 *
	 * @return  integer  The user id or 0 if not found.
	 */
	public function checkForExistingEmail($email)
	{
    $db = $this->container->db;

    $query = $db
      ->getQuery(true)
      ->select($db->qn('id'))
      ->from($db->qn('#__users'))
      ->where($db->qn('email') . ' = ' . $db->q($email));

    $db->setQuery($query, 0, 1);

    try
    {
      $result = $db->loadResult();
    }
    catch (RuntimeException $e)
    {
      throw new RuntimeException(JText::sprintf('COM_USERS_DATABASE_ERROR', $e->getMessage()), 500);
    }

		return $result;
  }

  /**
	 * Validates a user name and checks if the user name is already taken.
   *
   * User names have a maximum length of 150 characters and none of: <>\"'%;()&
   *
   * If the user name is invalid, method throws an UnexpectedValueException.
	 *
	 * @param   string $username  The user name to validate.
	 *
	 * @return  integer  User name if it's valid.
	 */
	public function validateUserName($userName)
	{
    $db = $this->container->db;

    $query = $db
      ->getQuery(true)
      ->select($db->qn('id'))
      ->from($db->qn('#__users'))
      ->where($db->qn('username') . ' = ' . $db->q($userName));

    $db->setQuery($query, 0, 1);

    // Check if user name is already being used
    if ($db->loadResult())
    {
      throw new UnexpectedValueException(JText::sprintf('COM_CAJOBBOARD_REGISTRATION_USER_NAME_EXISTS', $userName));
    }

    // Check if user name is long enough
    if (strlen($userName) < $this->minPasswordLength)
    {
      throw new UnexpectedValueException(JText::sprintf('COM_CAJOBBOARD_REGISTRATION_USER_NAME_EXISTS', $this->minPasswordLength));
    }

    // Check if user name has minimum number of integers
    if (preg_match_all('/[0-9]/', $userName) < $this->minNumberOfIntegers)
    {
      throw new UnexpectedValueException(JText::sprintf('COM_CAJOBBOARD_REGISTRATION_USER_NAME_EXISTS', $this->minNumberOfIntegers));
    }

    // Check if user name has minimum number of uppercase alphabetic characters
    if (preg_match_all('/[A-Z]/', $userName) < $this->minNumberOfUppercase)
    {
      throw new UnexpectedValueException(JText::sprintf('COM_CAJOBBOARD_REGISTRATION_USER_NAME_EXISTS', $this->minminNumberOfOfUppercase));
    }

    return $userName;
  }
}
