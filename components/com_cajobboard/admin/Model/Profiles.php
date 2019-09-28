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

use \FOF30\Container\Container;
use \FOF30\Model\DataModel;

// no direct access
defined( '_JEXEC' ) or die;

/**
 * Fields:
 *
 * @property  int     $user_id
 * @property  string  $profile_key
 * @property  string  $profile_value
 * @property  int     $ordering
 */
class Profiles extends DataModel
{
  use Mixin\Constructor;  // Refactored base-class constructor, called from __construct method
  use Mixin\JsonData;
  use Mixin\TableFields;  // Use an array of table fields instead of database reads on each table

  /*
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
   */
	public function __construct(Container $container, array $config = array())
	{
    // Add behaviours to the model. Filters, Created, and Modified behaviours are added automatically.
    $config['behaviours'] = array(
      'Filter'
    );

		$config['tableName'] = '#__user_profiles';
    $config['idFieldName'] = 'user_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.person_profiles';

    // Do not run automatic value validation of data before saving it.
		$config['autoChecks'] = false;

    /* Overridden constructor */
    $this->constructor($container, $config);
  }


  /**
   * @TODO: Need a way to fetch the join records from the #__user_profiles EAV table for the joined
   * fields, e.g. image, address_region, geo, and works_for
   *
   * @param   mixed   $data     An associative array or object to bind to the DataModel instance.
	 * @param   mixed   $ignore   An optional array of profile keys to ignore while binding.
   */
  public function getProfileJoinFields($data, $ignore = array())
  {
    $db = $this->getDbo();

    $query = $db->getQuery(true);

    $query->select($db->quoteName(array('user_id', 'profile_key', 'profile_value', 'ordering')));
    $query->from($db->quoteName('#__user_profiles'));
    $query->where($db->quoteName('user_id') . " = " . $this->getId() ); // @TODO: this won't be a valid PK here
    $query->order('ordering ASC');

    // @TODO: None of these joins are set up right
    if ( isset($data['image']) && !in_array('image', $ignore) )
    {
      $query->leftJoin($db->quoteName('#__cajobboard_image_objects', 'db_images') . ' ON (' . $db->quoteName($data['image']) . ' = ' . $db->quoteName('db_images.image_object_id') . ')');
    }

    if ($data['address_region'])
    {
      $query->leftJoin($db->quoteName('#__cajobboard_address_regions', 'db_regions') . ' ON (' . $db->quoteName($data['address_region']) . ' = ' . $db->quoteName('db_regions.address_region_id') . ')');
    }

    if ($data['geo'])
    {
      $query->leftJoin($db->quoteName('#__cajobboard_person_geos', 'db_geos') . ' ON (' . $db->quoteName($data['geo']) . ' = ' . $db->quoteName('db_geos.person_geo_id') . ')');
    }

    if ($data['works_for'])
    {
      $query
        ->leftJoin($db->quoteName('#__cajobboard_persons_organizations', 'db_persons_organizations') . ' ON (' . $db->quoteName('db_persons_organizations.organization_id') . ' = ' . $db->quoteName($data['worksFor']) . ')')
        ->leftJoin($db->quoteName('#__cajobboard_organizations', 'db_organizations') . ' ON (' . $db->quoteName('db_organizations.organization_id') . ' = ' . $db->quoteName('db_persons_organizations.organization_id') . ')');
    }

    $db->setQuery($query);

    $joinResults = $db->loadAssoc();

    // @TODO: Maybe setting it by $this->recordData[$name] = $value; and then unsetting the value? Dealing with knownValues array?
    $this->image = $joinResults['image'];
    $this->imageThumbnail = $joinResults['image_thumbnail'];
    $this->imageCaption = $joinResults['image_caption'];
    $this->imageHeight = $joinResults['image_height'];
    $this->imageWidth = $joinResults['image_width'];
    $this->address_region = $joinResults['address_region'];
    $this->geo = $joinResults['geo'];
    $this->worksFor = $joinResults['worksFor'];
  }
}
