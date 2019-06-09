<?php
/**
 * Admin Email Messages Model
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
defined('_JEXEC') or die;

use \FOF30\Container\Container;
use FOF30\Model\DataModel;
/**
 * Model Akeeba\Subscriptions\Admin\Model\EmailTemplates
 *
 * Fields:
 *
 * @property  int     $emailtemplate_id
 * @property  string  $key
 * @property  string  $subject
 * @property  string  $body
 * @property  string  $language
 *
 * Filters:
 *
 * @method  $this  emailtemplate_id()             emailtemplate_id(int $v)
 * @method  $this  key()                          key(string $v)
 * @method  $this  subject()                      subject(string $v)
 * @method  $this  body()                         body(string $v)
 * @method  $this  language()                     language(string $v)
 * @method  $this  enabled()                      enabled(bool $v)
 * @method  $this  ordering()                     ordering(int $v)
 * @method  $this  created_on()                   created_on(string $v)
 * @method  $this  created_by()                   created_by(int $v)
 * @method  $this  modified_on()                  modified_on(string $v)
 * @method  $this  modified_by()                  modified_by(int $v)
 * @method  $this  locked_on()                    locked_on(string $v)
 * @method  $this  locked_by()                    locked_by(int $v)
 *
 **/
class EmailMessages extends DataModel
{
	/**
	 * Overrides the constructor to add the Filters behaviour
	 *
	 * @param Container $container
	 * @param array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
		parent::__construct($container, $config);
		$this->addBehaviour('Filters');
	}
	/**
	 * Unpublish the newly copied item
	 *
	 * @param EmailMessages $copy
	 */
	protected function onAfterCopy(EmailTemplates $copy)
	{
		// Unpublish the newly copied item
		if ($copy->enabled)
		{
			$this->publish(0);
		}
	}
}
