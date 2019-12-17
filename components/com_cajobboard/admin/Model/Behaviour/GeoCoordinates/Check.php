<?php
/**
 * FOF model behavior class for model validation
 *
 * Checks for valid geospatial coordinates in the GeoCoordinates model
 *
 * @package   Calligraphic Job Board
 * @version   November 6, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
namespace Calligraphic\Cajobboard\Admin\Model\Behaviour\GeoCoordinates;

use \Calligraphic\Cajobboard\Admin\Model\Behaviour\Check as BaseCheck;
use \FOF30\Model\DataModel;
use \Joomla\CMS\Language\Text;

// no direct access
defined( '_JEXEC' ) or die;

class Check extends BaseCheck
{
  /* Trait methods to include in class */
  use \Calligraphic\Cajobboard\Admin\Model\Behaviour\Mixin\Assertions;

  /**
	 * Add the category id field to the fieldsSkipChecks list of the model.
	 * it should be empty so that we can fill it in through this behaviour.
	 *
	 * @param   DataModel  $model
	 */
	public function onCheck(DataModel $model)
	{
    parent::onCheck($model);

    $this->checkForValidGeoCoordinate($model);
  }


  /**
	 * Perform checks on data for validity.
   *
   * Called from save() and updateUcmContent() after those methods call bind().
	 *
	 * @param   DataModel  $model
	 */
	public function checkForValidGeoCoordinate(DataModel $model)
	{
    $this->assertNotEmpty($this->longitude, 'COM_CAJOBBOARD_GEO_COORDINATES_ERR_LONGITUDE_EMPTY');
    $this->assertNotEmpty($this->latitude, 'COM_CAJOBBOARD_GEO_COORDINATES_ERR_LATITUDE_EMPTY');

    if ( !function_exists ('bccomp') )
    {
      throw new \Exception( Text::_('COM_CAJOBBOARD_GEO_COORDINATES_NO_BCMATH') );
    }

    $this->assert( bccomp($this->getLatitude(), '90.000000', 6) < 1, 'COM_CAJOBBOARD_GEO_COORDINATES_ERR_LATITUDE_OUT_OF_RANGE' );
    $this->assert( bccomp('-90.000000', $this->getLatitude(), 6) < 1, 'COM_CAJOBBOARD_GEO_COORDINATES_ERR_LATITUDE_OUT_OF_RANGE' );
    $this->assert( bccomp($this->getLongitude(), '180.000000', 6) < 1, 'COM_CAJOBBOARD_GEO_COORDINATES_ERR_LONGITUDE_OUT_OF_RANGE' );
    $this->assert( bccomp('-180.000000', $this->getLongitude(), 6) < 1, 'COM_CAJOBBOARD_GEO_COORDINATES_ERR_LONGITUDE_OUT_OF_RANGE' );

		parent::check();

    return $this;
  }
}
