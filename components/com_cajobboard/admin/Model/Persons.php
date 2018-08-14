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
use JLoader;

/**
 * Model class for Akeeba Subscriptions user data
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
 * // Need to figure out User Notes
 * @property  string	$notes
 *
 *
 * @property  int		  $needs_logout
 *
 * @property-read  JoomlaUsers		  $User
 *
 * @method  $this  notes()               notes(string $v)
 * @method  $this  needs_logout()        needs_logout(bool $v)
 *
 * @method  $this  block()               block(bool $v)
 * @method  $this  username()            username(string $v)
 * @method  $this  name()                name(string $v)
 * @method  $this  email()               email(string $v)
 * @method  $this  search()              search(string $v)
 *
 *
 *
 *
 * Properties from user_profiles EAV table
 *
 * SCHEMA: Thing
 *
 * @property  string	$description TEXT COMMENT 'A description of this person.',
 * @property  int		  $image BIGINT UNSIGNED COMMENT 'An image or avatar for this person.'  FK to ImageObjects table
 * @property  string	$mainEntityOfPage VARCHAR(2083) COMMMENT 'A homepage or website belonging to this person.'
 *
 * SCHEMA: Person
 *
 * @property  string	$givenName Text 'Given name. In the U.S., the first name of a Person. This can be used along with familyName instead of the name property.',
 * @property  string	$additionalName 	Text 	'An additional name for a Person, can be used for a middle name.',
 * @property  string	$familyName Text 'Family name. In the U.S., the last name of an Person. This can be used along with givenName instead of the name property.',

* $telephone = array(
  *  'default' => 'value'
  * );

 * @property  string	$telephone TEXT 'A telephone number for this person.',
 * @property  string	$faxNumber VARCHAR(30) COMMENT 'A fax number for this person.',

 * SCHEMA: Person (address) -> PostalAddress
 *
 * @property  string	$address__street_address VARCHAR(255) COMMENT 'The street address, e.g. 1600 Amphitheatre Pkwy',
 * @property  string	$address__address_locality VARCHAR(50) COMMENT 'The locality, e.g. Mountain View',
* @property  int		  $address_region BIGINT UNSIGNED NOT NULL COMMENT 'The name of the region, e.g. California',  FK to #__cajobboard_util_address_region(address_region)
 * @property  string	$address__postal_code VARCHAR(12) COMMENT 'The postal code, e.g. 94043',
 * @property  string	$address__address_country VARCHAR(2) COMMENT 'The two-letter ISO 3166-1 alpha-2 country code',

 * @property  string	$jobTitle Text 'The job title of the person (for example, Financial Manager).'

 * SCHEMA: Thing (subjectOf) -> OrganizationRole ( roleName )
 * @property  string	$roleName 'The type of user, e.g. job seeker, employer, recruiter, or connector.'

 * This needs validation somehow, don't want people to be arbitrarily ad that they work for somebody without that organization's agreement
 * worksFor Organization 'Organizations that the person works for.'  M:M FK to Organizations. Could use for Recruiters.
 *
 * geo
 * params
 *
 */
class Persons extends DataModel
{
  /*
   * Overridden constructor
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
	 * Run the onUserSaveData event on the plugins before saving a row
	 *
	 * @param   array|\stdClass  $data  Source data
	 *
	 * @return  bool
	 */
	function onBeforeSave(&$data)
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

    $jResponse = $this->container->platform->runPlugins('onUserSaveData', array(&$pluginData));

		if (in_array(false, $jResponse))
		{
			throw new \RuntimeException('Cannot save user data');
		}
  }

	/**
	 * Build the SELECT query for returning records.
	 *
	 * @param   \JDatabaseQuery  $query           The query being built
	 * @param   bool             $overrideLimits  Should I be overriding the limit state (limitstart & limit)?
	 *
	 * @return  void
	 */
	public function onAfterBuildQuery(\JDatabaseQuery $query, $overrideLimits = false)
	{
    $db = $this->getDbo();

    // search functionality was in here, as well as in FrameworkUsers
  }

	/**
	 * Returns the merged data from the Akeeba Subscriptions' user parameters, the Joomla! user data and the Joomla!
	 * user profile data.
	 *
	 * @param   int  $user_id  The user ID to load, null to use the alredy loaded user
	 *
	 * @return  object
	 */
	public function getMergedData($user_id = null)
	{
		if (is_null($user_id))
		{
			$user_id = $this->getState('user_id', $this->user_id);
		}
    $this->find(['user_id' => $user_id]);

		// Get a legacy data set from the user parameters
    $userRow = $this->user;

		if (empty($this->user_id) || !is_object($userRow))
		{
			/** @var JoomlaUsers $userRow */
			$userRow = $this->container->factory->model('JoomlaUsers')->tmpInstance();
			$userRow->find($user_id);
		}
		// Decode user parameters
    $params = $userRow->params;

		if (!($userRow->params instanceof \JRegistry))
		{
      JLoader::import('joomla.registry.registry');

			$params = new \JRegistry($userRow->params);
		}
    $businessname = $params->get('business_name', '');

		$nativeData = array(
			'isbusiness'     => empty($businessname) ? 0 : 1,
			'businessname'   => $params->get('business_name', ''),
			'occupation'     => $params->get('occupation', ''),
			'vatnumber'      => $params->get('vat_number', ''),
			'viesregistered' => 0,
			'taxauthority'   => '',
			'address1'       => $params->get('address', ''),
			'address2'       => $params->get('address2', ''),
			'city'           => $params->get('city', ''),
			'state'          => $params->get('state', ''),
			'zip'            => $params->get('zip', ''),
			'country'        => $params->get('country', ''),
			'params'         => array()
    );

    $userData = $userRow->toArray();

    $myData = $nativeData;

		foreach (array('name', 'username', 'email') as $key)
		{
			$myData[$key] = $userData[$key];
    }

    $myData['email2'] = $userData['email'];

    unset($userData);

    if (($user_id > 0) && ($this->user_id == $user_id))

		{
      $myData = array_merge($myData, $this->toArray());

			if (is_string($myData['params']))
			{
        $myData['params'] = json_decode($myData['params'], true);

				if (is_null($myData['params']))
				{
					$myData['params'] = array();
				}
			}
		}
		else
		{
      $taxParameters = $this->container->factory->model('TaxHelper')->tmpInstance()->getTaxDefiningParameters($myData);

			$taxData = array(
				'isbusiness' => $taxParameters['vies'] ? 1 : 0,
				'city'       => $taxParameters['city'],
				'state'      => $taxParameters['state'],
				'country'    => $taxParameters['country'],
				'params'     => array()
      );

			$myData = array_merge($myData, $taxData);
    }

		// Finally, merge data coming from the plugins. Note that the
		// plugins only run when a new subscription is in progress, not
		// every time the user data loads.
    $this->container->platform->importPlugin('akeebasubs');

    $jResponse = $this->container->platform->runPlugins('onAKUserGetData', array((object)$myData));

		if (is_array($jResponse) && !empty($jResponse))
		{
			foreach ($jResponse as $pResponse)
			{
				if (!is_array($pResponse))
				{
					continue;
				}
				if (empty($pResponse))
				{
					continue;
				}
				if (array_key_exists('params', $pResponse))
				{
					if (!empty($pResponse['params']))
					{
						foreach ($pResponse['params'] as $k => $v)
						{
							$myData['params'][$k] = $v;
						}
					}
					unset($pResponse['params']);
				}
				foreach ($pResponse as $k => $v)
				{
					if (!empty($v))
					{
						$myData[$k] = $v;
					}
				}
			}
		}
		if (!isset($myData['params']))
		{
			$myData['params'] = array();
		}
    $myData['params'] = (object)$myData['params'];

		return (object)$myData;
  }

  /*
   * Convert params string from record to JRegistry object
   */
	protected function getParamsAttribute($value)
	{
		return $value;
  }

  /*
   * Convert JRegistry params object to string before updating
   */
	protected function setParamsAttribute($value)
	{
		return $value;
	}
}
