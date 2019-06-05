<?php
/**
 * Site Address Region Model
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
defined('_JEXEC') or die;

use \FOF30\Container\Container;

/*
 * Fields:
 *
 * @property int      $address_region_id      Surrogate primary key
 * @property string   $name                   The name of the region, e.g. California
 * @property string   $item_list_element      The abbreviation for the region, e.g. CA
 */
class AddressRegions extends \Calligraphic\Cajobboard\Admin\Model\AddressRegions
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
