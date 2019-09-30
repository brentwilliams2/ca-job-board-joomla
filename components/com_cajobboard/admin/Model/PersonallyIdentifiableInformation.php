<?php
/**
 * Admin Personally Identifiable Information Model
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * /*
 * @TODO: PII model needs to providing handling for three related systems:
 *
 *   1. Joomla! Privacy
 *   2. Akeeba PII
 *   3. Encrypting PII fields in the database
 *
 *   Extend to and implement PII system in all models that handle PII data
 *
 *   Handle PII notifications to remove user data and so, or maybe move to a plugin and handle it from Joomla!
 */

namespace Calligraphic\Cajobboard\Admin\Model;

// no direct access
defined( '_JEXEC' ) or die;

use \FOF30\Container\Container;
use \FOF30\Container\Model;

class PersonallyIdentifiableInformation extends Model
{
  /*
	 * @param   Container $container The configuration variables to this model
	 * @param   array     $config    Configuration values for this model
   */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);
  }
}
