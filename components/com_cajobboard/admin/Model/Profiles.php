<?php
/**
 * Admin User Profiles Model
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Model;

use \Joomla\CMS\User\UserHelper;

// no direct access
defined( '_JEXEC' ) or die;

class Profiles extends DataModel
{
  use Mixin\JsonData;


  /**
   *
   *
   * @var array
   */
  protected $normalizedProfileKey = array
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


  /*
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
   */
	public function __construct(Container $container, array $config = array())
	{
		$config['tableName'] = '#__user_profiles';
    $config['idFieldName'] = 'user_id';


    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.person_profiles';

    parent::__construct($container, $config);

		// Load the Filters behaviour
    $this->addBehaviour('Filters');

		// Do not run automatic value validation of data before saving it.
    $this->autoChecks = false;

    // M:M between $WorksFor and Organization
  }


  /*
   * @TODO: Get collection of user profiles in one database query, using buildQuery() and the like
   *
   * @param   array     $joins       Array of which joins to do (ALL, NONE, IMAGE, ADDRESS, GEO, WORKSFOR)
   *
	 * @return  bool True on success.
   */
  public function buildQuery ($joins = array('ALL'))
  {
    $db = $this->getDbo();

    // Load the profile data from the user profile table for this user
    $query = $db->getQuery(true)
      ->select    ($db->quoteName( array('profile_key', 'profile_value', 'ordering')) )
      ->from      ($db->quoteName( $this->getTableName(), 'profiles') )
      ->where     ($db->quoteName( 'user_id') . " = " . $this->getId() )
      ->andWhere  ($db->quoteName( 'profile_key') . ' LIKE '. $db->quote('\'profile.%\'') );

    // Get an indexed array of indexed arrays from the profile records returned by the query
    try
    {
      $db->setQuery($query);

      $results = $db->loadRowList();
    }
    catch (\Exception $e)
    {
      throw new \Exception(Text::_('COM_CAJOBBOARD_DATABASE_ERROR'), 404);
    }
  }


  /*
   * @TODO: or whatever event to transform the collection of keys, and organized by user, to stuff into the model
   *
   * @param   array     $joins       Array of which joins to do (ALL, NONE, IMAGE, ADDRESS, GEO, WORKSFOR)
   *
	 * @return  bool True on success.
   */
  public function onBeforeBind ($joins = array('ALL'))
  {
    // Merge the profile data
		foreach ($results as $value) {
      // Remove the profile key from the attribute value for this EAV field,
      //  e.g. normalize "profile.address1" to "address1"
      $key = str_replace('cajobboard.', '', $value[0]);

      // Get the attribute's value.
      if (array_key_exists ($key , $this->normalizedProfileKey))
      {
        $this->{ $this->normalizedProfileKey[$key] } = $value[1];
      }
      else
      {
        throw new \RuntimeException('User profile key not in list');
      }
    }
  }


  // @TODO: Override get() method and find() to return the right results?


  /*
   *
   */
  public function bind ()
  {
    /** @var PlatformInterface $platform */
    $platform = $this->container->platform;

    $db = $this->getDbo();

    // buildQuery()

    // onBeforeBind()


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
      $query->where($db->quoteName('users.id') . " = " . $this->getId() );

      try {
        $db->setQuery($query);
        $joinResults = $db->loadAssoc();
      }
      catch (\Exception $e)
      {
        Log::add('Database error in class Persons, method getUserProfile, load join tables: ' . $e->getMessage(), Log::ERROR, 'database');

        // Don't show the user a server error if there was an error in the database query
        throw new \Exception(Text::_('COM_CAJOBBOARD_DATABASE_ERROR'), 404);
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
