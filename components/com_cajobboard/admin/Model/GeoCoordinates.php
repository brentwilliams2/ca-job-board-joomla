<?php
/**
 * Admin GeoCoordinates Model
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
use \Calligraphic\Cajobboard\Admin\Model\BaseModel;

/*
 * Fields:
 *
 * UCM
 * @property int            $geo_coordinates_id   Surrogate primary key.
 * SCHEMA: GeoCoordinates
 * @property  string	      $latitude             latitude of a place
 * @property  string	      $longitude            longitude of a place
 */
class GeoCoordinates extends BaseModel
{
  use \FOF30\Model\Mixin\Assertions;

  /**
   * Latitude
   *
   * @property string
   */
  private $latitude;

  /**
   * Longitude
   *
   * @property string
   */
  private $longitude;

	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws \FOF30\Model\DataModel\Exception\NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    // override default table names and primary key id
		$config['tableName'] = '#__cajobboard_geo_coordinates';
    $config['idFieldName'] = 'geo_coordinates_id';

    // Define a contentType to enable the Tags behaviour
    $config['contentType'] = 'com_cajobboard.geo_coordinates';

    parent::__construct($container, $config);
  }


  /**
	 * @return   string   Latitude value (-90 to 90) with six digits of precision, e.g. '47.000022'
	 */
  protected function getLatitude()
  {
    return $this->latitude;
  }


  /**
	 * @param   string  $latitude   Latitude value (-90 to 90) with six digits of precision, e.g. '47.000022'
	 */
  protected function setLatitude($latitude)
  {
    $this->latitude = $latitude;
  }


  /**
	 * @return   string   Longitude value (-180 to 180) with six digits of precision, e.g. '-112.0034320'
	 */
  protected function getLongitude()
  {
    return $this->longitude;
  }


  /**
   * @param   string  $longitude   Longitude value (-180 to 180) with six digits of precision, e.g. '-112.0034320'
	 */
  protected function setLongitude($longitude)
  {
    $this->longitude = $longitude;
  }


  /**
	 * Transform 'geo' field on bind from the database or $data format to the model format. Populates
   * class properties from the input, which will be transformed later to a suitable database format.
   *
   * @param   string  $geo   The value of the geo field
	 *
	 * @return
	 */
  protected function getGeoAttribute($geo)
  {
    if ( is_object($geo) )
    {
      $this->setLongitude($geo->longitude);
      $this->setLatitude($geo->latitude);
    }
    elseif ($this->input->longitude && $this->input->latitude)
    {
      $this->setLongitude($this->input->longitude);
      $this->setLatitude($this->input->latitude);
    }
    else
    {
      // unpack MySQL binary data  https://codeutopia.net/blog/2011/02/19/using-spatial-data-in-doctrine-2/
      $coordinates = unpack('x4/clat/Llat/dlat/dlon', $geo);

      $this->setLongitude( $coordinates['lat'] );
      $this->setLatitude( $coordinates['lon'] );
    }

    return $geo;
  }


  /**
	 * Transform 'geo' field on save from the class properties for longitude and latitude to
   * a suitable database format.
   *
   * @param   string  $value   The value of the geo field as returned from the database
	 *
	 * @return
	 */
  protected function setGeoAttribute($value)
  {
    $geo = new \stdClass();

    $geo->longitude = $this->getLongitude();
    $geo->latitude = $this->getLatitude();

    $this->setFieldValue('geo', $geo);

    return $geo;
  }


  /**
	 * Perform checks on data for validity.
   *
   * Called from save() and updateUcmContent() after those methods call bind().
	 *
	 * @return  static  Self, for chaining
	 *
	 * @throws \RuntimeException  When the data bound to this record is invalid
	 */
	public function check()
	{
    $this->assertNotEmpty($this->longitude, 'COM_CAJOBBOARD_GEO_COORDINATES_ERR_LONGITUDE');
    $this->assertNotEmpty($this->latitude, 'COM_CAJOBBOARD_GEO_COORDINATES_ERR_LATITUDE');

    if ( !function_exists ('bccomp') )
    {
      throw new \Exception('The BCMATH module is not installed, and necessary for the job board to handle geospatial coordinates.');
    }

    $this->assert( bccomp($this->getLatitude(), '90.000000', 6) < 1, 'COM_CAJOBBOARD_GEO_COORDINATES_ERR_LATITUDE' );
    $this->assert( bccomp('-90.000000', $this->getLatitude(), 6) < 1, 'COM_CAJOBBOARD_GEO_COORDINATES_ERR_LATITUDE' );
    $this->assert( bccomp($this->getLongitude(), '180.000000', 6) < 1, 'COM_CAJOBBOARD_GEO_COORDINATES_ERR_LONGITUDE' );
    $this->assert( bccomp('-180.000000', $this->getLongitude(), 6) < 1, 'COM_CAJOBBOARD_GEO_COORDINATES_ERR_LONGITUDE' );

		parent::check();

    return $this;
  }


	/**
	 * Save a record, creating it if it doesn't exist or updating it if it exists. By default it uses the currently set data,
	 * unless you provide a $data array. Overridden to use SQL SET instead of VALUES syntax, required for MySQL's GEOMETRY
   * data type. The relations logic is also removed from the base class method, as GeoCoordinate's doesn't use relations.
   *
   * Called with $this->input->getData() as the $data param from DataController's applySave() method.
	 *
	 * @param   null|array  $data            [Optional] Data to bind.
	 *
	 * @return   DataModel  Self, for chaining
	 */
	public function save($data = NULL, $orderingFilter = '', $ignore = NULL, $resetRelations = true)
	{
		// Stash the primary key
    $oldPKValue = $this->getId();

		// Call the onBeforeSave event
    $this->triggerEvent('onBeforeSave', array(&$data));

		// Bind (optional) data. If no data is provided, the current record data is used.
		if (!is_null($data))
		{
			$this->bind($data, $ignore);
    }

		// Is this a new record?
		if (empty($oldPKValue))
		{
			$isNewRecord = true;
		}
		else
		{
			$isNewRecord = $oldPKValue != $this->getId();
    }

    $this->check();

    $db = $this->getDbo();

		// Insert or update the record. Note that the object we use for
		// insertion / update is a copy holding the transformed data.
    $dataObject = (object) $this->recordDataToDatabaseData();

    $point = sprintf('POINT(%f %f)', $dataObject->geo->longitude, $dataObject->geo->latitude);

		if ($isNewRecord)
		{
      $this->triggerEvent('onBeforeCreate', array(&$dataObject));

      $query = $db->getQuery(true);

      $query
        ->insert( $db->quoteName( $this->tableName) )
        ->set( "geo=ST_PointFromText('" . $point . "')" );

      $db->setQuery($query);

      $result = $db->execute();

			// Update ourselves with the new ID field's value
      $this->{$this->idFieldName} = $db->insertid();

			$this->triggerEvent('onAfterCreate');
		}
		else
		{
      $this->triggerEvent('onBeforeUpdate', array(&$dataObject));

      $query = $db->getQuery(true);

      $query
        ->update($this->tableName)
        ->set( "geo=ST_PointFromText('" . $point . "')" )
        ->where( $db->quoteName($this->idFieldName) . ' = ' . $this->getId() );

      $db->setQuery($query);

      $result = $db->execute();

			$this->triggerEvent('onAfterUpdate');
    }

		// Finally, call the onAfterSave event
    $this->triggerEvent('onAfterSave');

		return $this;
  }


  /**
	 * Overridden, called by Joomla! to update the UCM content
	 *
	 * @return  bool
	 */
	public function updateUcmContent()
	{
    throw new \Exception('updateUcmContent() method called in GeoCoordinates DataModel, GEOM handling not implemented for this method.');
  }
}
