<?php
/**
 * POPO Object Template for seeding User sample data
 * Override any setters in child class to provide custom output.
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates;

use Calligraphic\Cajobboard\Admin\Cli\Seeder\JoinTableManager;

// no direct access
defined('_JEXEC') or die;

class UsersTemplate extends BaseTemplate
{
  /**
	 * Long name of the user
	 *
	 * @var    string
   */
  public $name;

  /**
	 * Login / screen name for user
	 *
	 * @var    string
   */
  public $username;

  /**
	 * Email addy for user
	 *
	 * @var    string
   */
  public $email;

  /**
	 * User's password
	 *
	 * @var    string
   */
  public $password;

  /**
	 * Whether user is activated, not set by default
	 *
	 * @var    string
   */
  public $activation;

  /**
	 * Parameters for this user
	 *
	 * @var    string
   */
  public $params;

  /**
	 * Setters for User fields
   */
  public function name ($userConfig, $faker)
  {
    // Split camel cased user types into words, e.g. 'JobSeeker' to 'Job Seeker'
    $this->name = implode(' ', preg_split('/(?=[A-Z])/', $userConfig->userType)) . ' ' . $faker->firstName;
  }

  public function username ($userConfig, $faker)
  {
    $this->username = $faker->userName;
  }

  public function email ($userConfig, $faker)
  {
    $this->email = $faker->email;
  }

  public function password ($userConfig, $faker)
  {
    $this->password = md5('12345');
  }

  public function activation ($userConfig, $faker)
  {
    $this->activation = 1;
  }

  public function params ($userConfig, $faker)
  {
    $this->params = '{"site_language":"en-GB","language":"en-GB","update_cache_list":1}';
  }
}
