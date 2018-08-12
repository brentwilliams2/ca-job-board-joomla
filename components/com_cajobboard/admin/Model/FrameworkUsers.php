<?php
/**
 * Admin Organization Model
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model;

// no direct access
defined( '_JEXEC' ) or die;

use FOF30\Container\Container;
use FOF30\Model\DataModel;
use JApplicationHelper;
use JComponentHelper;
use JFactory;
use JLoader;
use JUser;
use JUserHelper;
/**
 * Model for querying Joomla! users
 *
 * Fields:
 *
 * @property  int     $id
 * @property  string  $name
 * @property  string  $username
 * @property  string  $email
 * @property  string  $password
 * @property  bool    $block
 * @property  bool    $sendEmail
 * @property  string  $registerDate
 * @property  string  $lastvisitDate
 * @property  string  $activation
 * @property  string  $params
 * @property  string  $lastResetTime
 * @property  int     $resetCount
 * @property  string  $otpKey
 * @property  string  $otep
 * @property  bool    $requireReset
 *
 * Filters:
 *
 * @method  $this  id()             id(int $v)
 * @method  $this  name()           name(string $v)
 * @method  $this  username()       username(string $v)
 * @method  $this  email()          email(string $v)
 * @method  $this  password()       password(string $v)
 * @method  $this  block()          block(bool $v)
 * @method  $this  sendEmail()      sendEmail(bool $v)
 * @method  $this  registerDate()   registerDate(string $v)
 * @method  $this  lastvisitDate()  lastvisitDate(string $v)
 * @method  $this  activation()     activation(string $v)
 * @method  $this  lastResetTime()  lastResetTime(string $v)
 * @method  $this  resetCount()     resetCount(int $v)
 * @method  $this  otpKey()         otpKey(string $v)
 * @method  $this  otep()           otep(string $v)
 * @method  $this  requireReset()   requireReset(bool $v)
 * @method  $this  search()         search(string $userInfoToSearch)
 *
 **/
 class FrameworkUsers extends DataModel
{
	/**
	 * Attach to a framework core table and add the Filters behaviour
	 *
	 * @param Container $container
	 * @param array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
		$config['tableName'] = '#__users';
    $config['idFieldName'] = 'id';

    parent::__construct($container, $config);

		// Load the Filters behaviour
    $this->addBehaviour('Filters');

		// Do not run automatic value validation of data before saving it.
		$this->autoChecks = false;
  }

	/**
	 * Build the SELECT query for returning records. Overridden to apply custom filters.
	 *
	 * @param   \JDatabaseQuery  $query           The query being built
	 * @param   bool             $overrideLimits  Should I be overriding the limit state (limitstart & limit)?
	 *
	 * @return  void
	 */
	public function onAfterBuildQuery(\JDatabaseQuery $query, $overrideLimits = false)
	{
    $db = $this->getDbo();

    $userId = $this->getState('user_id', null, 'int');

		if (!empty($userId))
		{
			$query->where($db->qn('id') . ' = ' . $db->q($userId));
    }

    $search = $this->getState('search', null);

		if ($search)
		{
      $search = '%' . $search . '%';

			$query->where(
				'(' .
				'(' . $db->qn('username') . ' LIKE ' . $db->q($search) . ') OR ' .
				'(' . $db->qn('name') . ' LIKE ' . $db->q($search) . ') OR ' .
				'(' . $db->qn('email') . ' LIKE ' . $db->q($search) . ') ' .
				')'
			);
			return;
    }

    $username = $this->getState('username', null);

		if (is_string($username) && !empty($username))
		{
			$query->where($db->qn('username') . ' = ' . $db->q($username));
    }

    $email = $this->getState('email', null, 'raw');

		if (is_string($email) && !empty($email))
		{
			$query->where($db->qn('email') . ' = ' . $db->q($email));
    }

    $block = $this->getState('block', null, 'int');

		if (!is_null($block))
		{
			$query->where($db->qn('block') . ' = ' . $db->q($block));
		}
  }
}
