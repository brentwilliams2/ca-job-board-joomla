<?php
/**
 * Admin Email Messages Model
 *
 * There is no site-side counterpart to EmailMessages, because it is a send-
 * only feature and the admin views are only for setting configuration to allow
 * non-developer updates to the HTML e-mail templates.
 *
 * This MVC triad allows using an HTML editor to modify the available
 * e-mail templates for tasks. It does not allow adding additional
 * templates to the database. Adding tasks requires adding appropriate
 * methods to the plg_cajobboard_mail plugin, and adding controller code
 * to dispatch events to the plugin task method.
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

  /*
    Plugin - check if CLI script is available, if not call the model sync, for other models to call the mail
    CLI Script - for cron to call, or for the plugin to trigger when it's possible.

    @TODO: Need to send both HTML and text emails in the same message, for Outlook
            Probably don't need enabled, since all would be enabled.

    Send a report
    New comment
    New question or answer on FAQs
    New review (for employers)
    Job posting alert matching (for job seekers)
    Resume alert (for employers in the ATS system)
    New message (user-to-user messaging)
    FCRA (Fair Credit Reporting Act) notice (when credit check is done, set as a manual task in the ATS workflow initially)
    New application received against a job posting
    ATS scheduling reminders (with configurable advance notice period), e.g. "Just a reminder, you have a phone interview scheduled tomorrow with..."
    ATS workflow notices - configurable for which actions trigger the notice, e.g. when a scorecard is marked complete for a candidate, a background check completed, a reference received for a candidate
    GDPR notices - when a candidate has requested their information be purged from the system, so the employer can  understand what has happened (could involve a candidate that is in their workflow pipeline)
    Reminders to fill out part of a job seeker profile.
    Job posting alert (for Connectors)
    */


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
