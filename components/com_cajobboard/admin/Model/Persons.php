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
use JFactory;

/**
 * Model class for Job Board users
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
 *
 * @TODO: enable user notes outside of core Joomla system
 */
class Persons extends DataModel
{
  // User Profile Properties - SCHEMA: Thing

  /*
  * A description of this person.
  *
  * @var string
  */
  protected $description;

 /*
  * An image or avatar for this person, FK to ImageObjects table.
  *
  * @var int
  */
  protected $image;

 /*
  * A thumbnail image or avatar for this person, FK to ImageObjects table.
  *
  * @var int
  */
  protected $imageThumbnail;

 /*
  * A caption for the image or avatar of this person, FK to ImageObjects table.
  *
  * @var int
  */
  protected $imageCaption;

 /*
  * The height of the image or avatar for this person, FK to ImageObjects table.
  *
  * @var int
  */
  protected $imageHeight;

 /*
  * The width of the image or avatar for this person, FK to ImageObjects table.
  *
  * @var int
  */
  protected $imageWidth;

  /*
  * A homepage or website belonging to this person.
  *
  * @var string
  */
  protected $mainEntityOfPage;

  // User Profile Properties - SCHEMA: Person

  /*
  * Given name. In the U.S., the first name of a Person. This can be used along with familyName instead of the name property.
  *
  * @var string
  */
  protected $givenName;

  /*
  * An additional name for a Person, can be used for a middle name.
  *
  * @var string
  */
  protected $additionalName;

  /*
  * Family name. In the U.S., the last name of an Person. This can be used along with givenName instead of the name property.
  *
  * @var string
  */
  protected $familyName;

  /*
  * A telephone number for this person. Associate array, key is type of number (mobile, home, etc.).
  *
  * @var array
  */
  protected $telephone = array();

  /*
  * A fax number for this person.
  *
  * @var string
  */
  protected $faxNumber;

  /*
  * Organizations that the person works for, M:M FK to Organizations. Could use for Recruiters.
  *
  * @var \Calligraphic\Cajobboard\Admin\Model\Organization
  */
  protected $worksFor;

  /*
  * The job title of the person (for example, Financial Manager).
  *
  * @var string
  */
  protected $jobTitle;

  // User Profile Properties - SCHEMA: Person (address) -> PostalAddress

  /*
  *
  * The street address of the person, e.g. 1600 Amphitheatre Pkwy.
  *
  * @var string
  */
  protected $address__street_address;

 /*
  *
  * The locality or city of the person, e.g. San Francisco.
  *
  * @var string
  */
  protected $address__locality;

  /*
  *
  * The region or state of the person, e.g. California, FK to AddressRegions
  *
  * @var string
  */
  protected $address_region;

  /*
  * The postal code of the person, e.g. 94043.
  *
  * @var string
  */
  protected $address__postal_code;

  /*
  * The two-letter ISO 3166-1 alpha-2 country code of the person
  *
  * @var string
  */
  protected $address__address_country;

  // User Profile Properties - SCHEMA: Thing (subjectOf) -> OrganizationRole (roleName)

  /*
  * The type of user, e.g. job seeker, employer, recruiter, or connector.
  *
  * @var string
  */
  protected $roleName;

  // User Profile Properties - SCHEMA: Thing (additionalType) -> Geo(longitude, latitude)

  /*
  * The (longitude, latitude) geographic coordinates of the user, FK to #__cajobboard_user_geo
  *
  * @var array
  */
  protected $geo = array();

  use Mixin\JsonData;

  /*
   * Overridden constructor
   */
	public function __construct(Container $container, array $config = array())
	{
		$config['tableName'] = '#__users';
    $config['idFieldName'] = 'id';


    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.persons';

    parent::__construct($container, $config);

		// Load the Filters behaviour
    $this->addBehaviour('Filters');

		// Do not run automatic value validation of data before saving it.
    $this->autoChecks = false;

    // M:M between $WorksFor and Organization
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
    $userProfileFields = $this->getUserProfile();

    $db = $this->getDbo();

    // Apply custom filters here, e.g.:
    /*
      $username = $this->getState('username', null, 'string');
      if ($username)
      {
        $this->whereHas('user', function(\JDatabaseQuery $subQuery) use($username, $db) {
          $subQuery->where($db->qn('username') . ' LIKE ' . $db->q('%' . $username . '%'));
        });
      }
    */

    // Add faceted search functionality here
  }


  /*
   *  Method to load the extended profile fields managed by plg_user_cajobboard for a user into the model
   *
   * @param   int       $userId      The ID of the user to load extended profile fields for
   * @param   array     $joins       Array of which joins to do (ALL, NONE, IMAGE, ADDRESS, GEO, WORKSFOR)
   *
	 * @return  bool True on success.
   */
  public function getUserProfile ($userId = null, $joins = array('ALL'))
  {
    // EAV table holding extended user profile information
    $profile_table = '#__user_profiles';

    // Key to store user extended profile information in EAV table
    $profile_key = 'cajobboard';

    $user = JFactory::getUser();

    // Don't do anything if guest user
    if (!$userId && $user->id == 0) return;

    // Use user id from state if not passed to function
		if (!$userId) $userID = $user->id;

    $db = JFactory::getDbo();

    // Load the profile data from the user profile table for this user
    $query = $db->getQuery(true)
      ->select($db->quoteName(array('profile_key', 'profile_value')))
      ->from($db->quoteName($profile_table, 'profiles'))
      ->where($db->quoteName('user_id') . " = " . (int) $userId)
      ->andWhere($db->quoteName('profile_key') . ' LIKE '. $db->quote('\'' . $profile_key . '.%\''));

    // Get an indexed array of indexed arrays from the profile records returned by the query
    try
    {
      $db->setQuery($query);
      $results = $db->loadRowList();
    }
    catch (Exception $e)
    {
      JLog::add('Database error in class Persons, method getUserProfile: ' . $e->getMessage(), JLog::ERROR, 'database');

      // Don't show the user a server error if there was an error in the database query
      throw new Exception(JText::_('COM_CAJOBBOARD_DATABASE_ERROR'), 404);
    }

    $normalizedProfileKey = array
    (
      'description' => 'description',
      'main_entity_of_page' => 'mainEntityOfPage',
      'given_name' => 'givenName',
      'additional_name' => 'additionalName',
      'family_name' => 'familyName',
      'telephone' => 'telephone',
      'fax_number' => 'faxNumber',
      'job_title' => 'jobTitle',
      'address__street_address' => 'address__street_address',
      'address__locality' => 'address__locality',
      'address__postal_code' => 'address__postal_code',
      'address__address_country' => 'address__address_country',
      'role_name' => 'roleName'
    );

    // Merge the profile data
		foreach ($results as $value) {
      // Remove the profile key from the attribute value for this EAV field,
      //  e.g. normalize "profile.address1" to "address1"
      $key = str_replace($profile_key . '.', '', $value[0]);

      // Get the attribute's value.
      if (array_key_exists ($key , $normalizedProfileKey))
      {
        $this->{$normalizedProfileKey[$key]} = $value[1];
      }
      else
      {
        JLog::add('User profile key not in list, class Persons method getUserProfile(): ' . $key, JLog::ERROR, 'user-profile-error');
      }
    }

    // Base select query, without any joins
    $query = $db->getQuery(true)->select($db->quoteName('users.id'));

    // Get the relations data. We're joining on the users table, since it's always going to return a user record.
    // add array parameter to choose which joins to do: ALL, NONE, IMAGE, ADDRESS, GEO, WORKSFOR
    if (!in_array ('NONE', $joins))
    {
      //
      $profileVars = array(
        'address_region' => isset($results['address_region']) && (in_array('ADDRESS', $joins) || array_key_exists ('ALL', $joins)) ? $results['address_region'] : NULL,
        'geo' => isset($results['geo']) && (in_array('GEO', $joins) || array_key_exists ('ALL', $joins)) ? $results['geo'] : NULL,
        'image' => isset($results['image']) && (in_array ('IMAGE', $joins) || array_key_exists ('ALL', $joins)) ? $results['image'] : NULL,
        'worksFor' => isset($results['works_for']) && (in_array('WORKSFOR', $joins) || array_key_exists ('ALL', $joins)) ? $results['works_for'] : NULL
      );

      // SELECT statement from Images table
      if ($profileVars['image'])
      {
        $query
          ->select($db->quoteName('db_images.image'))
          ->select($db->quoteName('db_images.thumbnail', 'image_thumbnail'))
          ->select($db->quoteName('db_images.caption', 'image_caption'))
          ->select($db->quoteName('db_images.height', 'image_height'))
          ->select($db->quoteName('db_images.width', 'image_width'));
      }
      // SELECT statement from Regions table
      if ($profileVars['address_region'])
      {
        $query->select($db->quoteName('db_regions.name', 'address_region'));
      }

      // SELECT statement from Geo table
      if ($profileVars['geo'])
      {
        $query->select($db->quoteName('db_geos', 'geo'));
      }

      // SELECT statement from Organizations table
      if ($profileVars['worksFor'])
      {
        $query->select($db->quoteName('db_organizations.name', 'organization_name'));
      }

      // FROM statement
      $query->from($db->quoteName('#__users', 'users'));

      // LEFT JOIN statement from Images table
      if ($profileVars['image'])
      {
        $query->leftJoin($db->quoteName('#__cajobboard_image_objects', 'db_images') . ' ON (' . $db->quoteName($profileVars['image']) . ' = ' . $db->quoteName('db_images.image_object_id') . ')');
      }

      // LEFT JOIN statement from Regions table
      if ($profileVars['address_region'])
      {
        $query->leftJoin($db->quoteName('#__cajobboard_address_regions', 'db_regions') . ' ON (' . $db->quoteName($profileVars['address_region']) . ' = ' . $db->quoteName('db_regions.address_region_id') . ')');
      }

      // LEFT JOIN statement from Geo table
      if ($profileVars['geo'])
      {
        $query->leftJoin($db->quoteName('#__cajobboard_person_geos', 'db_geos') . ' ON (' . $db->quoteName($profileVars['geo']) . ' = ' . $db->quoteName('db_geos.person_geo_id') . ')');
      }

      // LEFT JOIN statement from Organizations table
      if ($profileVars['worksFor'])
      {
        $query
          ->leftJoin($db->quoteName('#__cajobboard_persons_organizations', 'db_persons_organizations') . ' ON (' . $db->quoteName(db_persons_organizations.organization_id) . ' = ' . $db->quoteName($profileVars['worksFor']) . ')')
          ->leftJoin($db->quoteName('#__cajobboard_organizations', 'db_organizations') . ' ON (' . $db->quoteName('db_organizations.organization_id') . ' = ' . $db->quoteName('db_persons_organizations.organization_id') . ')');
      }

      // WHERE statement
      $query->where($db->quoteName('users.id') . " = " . (int) $userId);

      try {
        $db->setQuery($query);
        $joinResults = $db->loadAssoc();
      }
      catch (Exception $e)
      {
        JLog::add('Database error in class Persons, method getUserProfile, load join tables: ' . $e->getMessage(), JLog::ERROR, 'database');

        // Don't show the user a server error if there was an error in the database query
        throw new Exception(JText::_('COM_CAJOBBOARD_DATABASE_ERROR'), 404);
      }

      $this->image = $joinResults['image'];
      $this->imageThumbnail = $joinResults['image_thumbnail'];
      $this->imageCaption = $joinResults['image_caption'];
      $this->imageHeight = $joinResults['image_height'];
      $this->imageWidth = $joinResults['image_width'];
      $this->address_region = $joinResults['address_region'];
      $this->geo = $joinResults['geo'];
      $this->worksFor = $joinResults['worksFor'];
    }

    return true;
  }
}
