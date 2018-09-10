<?php
/**
 * Admin Reviews Model
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
use FOF30\Model\Model;

/**
 * Model class for User Registrations
 *
 * @param   string $email           The email address of the user to create
 * @param   string $userName        Screen name to use for the user
 * @param   string $name            The full name of the user
 * @param   string $language        The language to set for the user
 * @param   string $password        The user's password
 */
class Registrations extends Model
{
  /**
  * User's screen name
  *
  * @param string $userName
  */
  public $userName;

  /**
  * User's full name
  *
  * @param string $name
  */
  public $name;

  /**
  * User's email address
  *
  * @param string $email
  */
  public $email;

  /**
  * Language set by the user
  *
  * @param string $language
  */
  public $language;

  /**
  * User's password
  *
  * @param string $password
  */
  public $password;

  /*
   * Overridden constructor
   */
	public function __construct(Container $container, array $config = array())
	{
    // @TODO: Move validation logic from RegistrationHelper to here

    parent::__construct($container, $config);
  }
}
