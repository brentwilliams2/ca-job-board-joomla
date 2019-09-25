<?php
/**
 * Site Persons Model. Uses core Joomla! user table (#__users)
 *
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Model;

// no direct access
defined( '_JEXEC' ) or die;

use \FOF30\Container\Container;

/**
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
 */
class Persons extends \Calligraphic\Cajobboard\Admin\Model\Persons
{
  /*
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
