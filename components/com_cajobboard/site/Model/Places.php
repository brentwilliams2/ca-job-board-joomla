<?php
/**
 * Site Place Model
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
 * @property int            $place_id                       Surrogate primary key.
 * @property string         $slug                           Alias for SEF URL.
 * @property bool           $featured                       Whether this answer is featured or not.
 * @property int            $hits                           Number of hits this answer has received.
 * @property int            $created_by                     Userid of the creator of this answer.
 * @property string         $createdOn                      Date this answer was created.
 * @property int            $modifiedBy                     Userid of person that last modified this answer.
 * @property string         $modifiedOn                     Date this answer was last modified.
 *
 * @property  string	      $branch_code                    A short textual code that uniquely identifies a place of business.
 * @property  string	      $fax_number                     The E.164 PSTN fax number.
 * @property  bool		      $public_access                  A flag to signal that the Place is open to public visitors. If this property is omitted there is no assumed default boolean value.
 *
 * SCHEMA: Place (geo) -> GeoCoordinates NOTE: https://schema.org/GeoCoordinates has separate latitude, longitude properties instead of using GIS point.
 * @property  string	      $geo                            latitude and longitude of place using MySQL GIS spatial data type. Example: INSERT INTO place(geo) VALUES (Point(1,2));
 *
 * Place (address) -> PostalAddress
 * @property  string	      $address__address_country       The two-letter ISO 3166-1 alpha-2 country code.
 * @property  string	      $address__address_locality      The locality, e.g. Mountain View.
 * @property  string	      $address__postal_code           The postal code, e.g. 94043.
 * @property  string	      $address__street_address        The street address, e.g. 1600 Amphitheatre Pkwy.
 * @property  int			      $address__address_region        The name of the region, e.g. California', FK to #__cajobboard_util_address_region(address_region)
 * @property  string        $telephone                      The E.164 PSTN telephone number.
 * @property  string	      $openingHoursSpecification      The days and times this location is open.
 * @property  int			      $Logo                           A logo image that represents this place. FK to #__cajobboard_images(image_id)
 * @property  int			      $Photo                          One or more photographs of this place. FK M:M relationship in to #__cajobboard_images(image_id)
 */
class Places extends \Calligraphic\Cajobboard\Admin\Model\Places
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
