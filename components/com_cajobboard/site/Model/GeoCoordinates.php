<?php
/**
 * Site GeoCoordinates Model
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Model;

// no direct access
defined( '_JEXEC' ) or die;

use FOF30\Container\Container;

/*
 * Fields:
 *
 * UCM
 * @property int            $geo_coordinates_id   Surrogate primary key.
 * SCHEMA: GeoCoordinates
 * @property  string	      $latitude             latitude of a place
 * @property  string	      $longitude            longitude of a place
 */
class GeoCoordinates extends \Calligraphic\Cajobboard\Admin\Model\GeoCoordinates
{
	/**
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
	 *
	 * @throws NoTableColumns
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);
  }
}
