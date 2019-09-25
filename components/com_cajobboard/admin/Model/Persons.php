<?php
/**
 * Admin Persons Model. Uses core Joomla! user table (#__users)
 *
 * @package   Calligraphic Job Board
 * @version   July 5, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model;

// no direct access
defined( '_JEXEC' ) or die;

use \Calligraphic\Cajobboard\Admin\Helper\MessageCounts;
use \Calligraphic\Cajobboard\Admin\Model\Exception\UserGroupInvalid;
use \Calligraphic\Cajobboard\Admin\Model\Exception\UserSaveFailure;
use \FOF30\Container\Container;
use \FOF30\Model\DataModel;
use \FOF30\Platform\PlatformInterface;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\User\User;
use \Joomla\CMS\User\UserHelper;

/**
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
 */
class Persons extends DataModel
{
  /* Traits to include in the class */

	use Mixin\Constructor;          // Refactored base-class constructor, called from __construct method
	use Mixin\TableFields;          // Use an array of table fields instead of database reads on each table
  use Mixin\Count;                // Overridden count() method to cache value

  /*
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
   */
	public function __construct(Container $container, array $config = array())
	{
		$config['tableName'] = '#__users';
    $config['idFieldName'] = 'id';


    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.persons';

		//parent::__construct($container, $config);
		/* Overridden constructor */
		$this->constructor($container, $config);

		// Load the Filters behaviour
    $this->addBehaviour('Filters');

		// Do not run automatic value validation of data before saving it.
		$this->autoChecks = false;

    // many-to-many FK to #__cajobboard_persons_geos
		$this->belongsToMany('GeoCoordinates', 'GeoCoordinates@com_cajobboard', 'id', 'geo_coordinate_id', '#__cajobboard_organizations_employees', 'person_id', 'geo_coordinate_id');
  }


  /**
   * Proxy to Joomla! UserHelper for adding a user a user group by group ID
   *
   * @param int $groupId
   *
   * @return void
   */
  public function addUserToGroup($groupId)
	{
    try
    {
      UserHelper::addUserToGroup($this->getId(), $groupId);
    }
    catch ( \RuntimeException $e )
    {
      throw new UserGroupInvalid();
    }
  }


	/**
	 * Proxy to Joomla! UserHelper to get a list of groups the user is in.
	 *
	 * @return  array    List of groups
	 */
	public static function getUserGroups()
	{
    UserHelper::getUserGroups( $this->getId() );
  }


	/**
	 * Proxy to Joomla! UserHelper to remove the user from a group.
	 *
	 * @param   integer  $groupId  The id of the group.
	 */
	public static function removeUserFromGroup($groupId)
	{
    UserHelper::removeUserFromGroup( $this->getId(), $groupId );
  }


	/**
	 *Proxy to Joomla! UserHelper to set the groups for the user.
	 *
	 * @param   array    $groups  An array of group ids to put the user in.
	 */
	public static function setUserGroups($groups)
	{
    UserHelper::setUserGroups( $this->getId(), $groups );
  }


	/**
	 * Proxy to Joomla! UserHelper to activate and unblock the user
	 *
	 * @param   string  $activation  Activation string
	 */
	public static function activateUser($activation)
	{
    $user = User::getInstance((int) $id);

    $user->set('block', '0');

    $user->set('activation', '1');

    $user->save();
  }


  /**
	 * Get the message counts for this person
	 *
	 * @return  array  Returns assoc array with keys 'messagesTotal' and 'messagesUnread'
	 */
  public function getMessageCounts()
  {
    return $this->container->MessageCounts->getMessageCounts( $this->getId() );
  }


	/**
	 * Run the onUserSaveData event on the plugins before saving a row
	 *
	 * @param   array|\stdClass  $data  Source data
	 *
	 * @return  bool
	 */
	function onBeforeSave($data)
	{
    $pluginData = $data;

		if (is_object($data))
		{
			if ($data instanceof DataModel)
			{
				$pluginData = $data->toArray();
			}
			else
			{
				$pluginData = (array) $data;
			}
    }

    $this->container->platform->importPlugin('cajobboard');

    $jResponse = $this->container->platform->runPlugins('onUserSaveData', array($pluginData));

		if (in_array(false, $jResponse))
		{
			throw new UserSaveFailure();
		}
  }


	/**
	 * Build the SELECT query for returning records.
	 *
	 * @param   \JDatabaseQuery  $query           The query being built. Class not namespaced in Joomla! yet.
	 * @param   bool             $overrideLimits  Should I be overriding the limit state (limitstart & limit)?
	 *
	 * @return  void
	 */
	public function onAfterBuildQuery(\JDatabaseQuery $query, $overrideLimits = false)
	{
    // $userProfileFields = $this->getUserProfile();
  }
}
