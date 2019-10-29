<?php
/**
 * POPO Object Template for Email Message Templates model sample data seeding
 *
 * Uses returns in template properties so that all
 * properties can be loaded at once from real values
 *
 * @package   Calligraphic Job Board
 * @version   29 October, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates;

use Faker;
use \Joomla\CMS\User\UserHelper;

// no direct access
defined('_JEXEC') or die;

class EmailMessageTemplatesTemplate extends CommonTemplate
{
	/**
	 * Text template with shortcodes for the subject field of the e-mail.
	 *
	 * @property    string
   */
  public $subject;


	/**
	 * HTML template with shortcodes for the body field of the e-mail.
	 *
	 * @property    string
   */
  public $body;


  /**
	 * Setters for Comment fields
   */


  public function subject ($config, $faker)
  {
    $this->setTemplateProperties($config, $faker);
  }


  public function body ($config, $faker)
  {
    return;
  }


  /**
   * over-ridden from CommonTemplate
   */

  public function name ($config, $faker)
  {
    return;
  }


  public function slug ($config, $faker)
  {
    return;
  }


  public function description ($config, $faker)
  {
    return;
  }

  public function created_by ($config, $faker)
  {
    $this->created_by = UserHelper::getUserId('admin');
  }

 /**
  * Loads all values at once with real values (from image file)
  */
  protected function setTemplateProperties ($config, $faker)
  {
    $record = $this->loadRecord($config->item_id);

    $this->name = $record['name'];
    $this->slug = $record['slug'];
    $this->description = $record['description'];
    $this->subject = $record['subject'];
    $this->body = $record['body'];
  }


  /**
   * Return metadata for an image file saved on disk in the media/images/user_uploads directory
   *
   * NOTE: The number of records to generate in config.json for this template
   *       must match the number of elements in the returned array here
   *
   * @param   int   $recordId   The ID number of the record to get metadata for
   *
   * @return  array   An array of metadata for the record
   */
  public function loadRecord ($recordId)
  {
    $records = array(
      array(
        'name' => 'analytics_report', 'slug' => 'analytics-report', 'description' => 'Analytics reports template', 'subject' => 'Your [SITENAME] report for [TIMEPERIOD]', 'body' => '<div style=\"background-color: #e0e0e0; padding: 10px 20px;\">\r\n<div style=\"background-color: #f9f9f9; border-radius: 10px; padding: 5px 10px;\">\r\n<p>Hello [FIRSTNAME],</p>\r\n<p>Attached is your <span style=\"line-height: 1.3em;\">[TIMEPERIOD] </span><span style=\"line-height: 1.3em;\">report</span></p>\r\n</div>\r\n<p style=\"font-size: x-small; color: #667;\">You are receiving this automatic email message because you have set up automatic report generation on <em>[SITENAME]</em>. <span style=\"line-height: 1.3em;\">Do not reply to this email, it is sent from an unmonitored email address.</span></p>\r\n</div>'
      ),
      array(
        'name' => 'new_comment_posted_notification', 'slug' => 'new-comment-posted-notification', 'description' => 'New comment posted notification template', 'subject' => 'subject', 'body' => 'body'
      ),
      array(
        'name' => 'new_question_posted_notification', 'slug' => 'new-question-posted-notification', 'description' => 'New question posted notification template', 'subject' => 'subject', 'body' => 'body'
      ),
      array(
        'name' => 'new_answer_posted_notification', 'slug' => 'new-answer-posted-notification', 'description' => 'New answer posted notification template', 'subject' => 'subject', 'body' => 'body'
      ),
      array(
        'name' => 'new_employer_review_received_notification', 'slug' => 'new-employer-review-received-notification', 'description' => 'New employer review posted notification template', 'subject' => 'subject', 'body' => 'body'
      ),
      array(
        'name' => 'job_post_alert', 'slug' => 'job-post-alert', 'description' => 'Job posting alert template', 'subject' => 'subject', 'body' => 'body'
      ),
      array(
        'name' => 'resume_alert', 'slug' => 'resume-alert', 'description' => 'Resume alert template', 'subject' => 'subject', 'body' => 'body'
      ),
      array(
        'name' => 'new_message_received_notification', 'slug' => 'new-message-received-notification', 'description' => 'New user message notification template', 'subject' => 'subject', 'body' => 'body'
      ),
      array(
        'name' => 'fair_credit_reporting_act_notice', 'slug' => 'fair-credit-reporting-act-notice', 'description' => 'FCRA notice sent when credit check is done', 'subject' => 'subject', 'body' => 'body'
      ),
      array(
        'name' => 'new_application_received_notification', 'slug' => 'new-application-received-notification', 'description' => 'New application received for a job posting template', 'subject' => 'subject', 'body' => 'body'
      ),
      array(
        'name' => 'gdpr_notice', 'slug' => 'gdpr-notice', 'description' => 'GDPR user data removal notification template', 'subject' => 'subject', 'body' => 'body'
      ),
      array(
        'name' => 'complete_job_seeker_profile_request', 'slug' => 'complete-job-seeker-profile-request', 'description' => 'Reminders to complete a job seeker profile', 'subject' => 'subject', 'body' => 'body'
      ),
      array(
        'name' => 'connectors_job_post_alert', 'slug' => 'connectors-job-post-alert', 'description' => 'Connectors job posting alert template', 'subject' => 'subject', 'body' => 'body'
      ),
      array(
        'name' => 'recommendation_request', 'slug' => 'recommendation-request', 'description' => 'Recommendation request template', 'subject' => 'subject', 'body' => 'body'
      ),
      array(
        'name' => 'recommendation_follow_up', 'slug' => 'recommendation-follow-up', 'description' => 'Recommendation follow up template', 'subject' => 'subject', 'body' => 'body'
      ),
      array(
        'name' => 'reference_request', 'slug' => 'reference-request', 'description' => 'Reference request template', 'subject' => 'subject', 'body' => 'body'
      ),
      array(
        'name' => 'reference_follow_up', 'slug' => 'reference-follow-up', 'description' => 'Reference follow up template', 'subject' => 'subject', 'body' => 'body'
      ),
      array(
        'name' => 'ats_scheduling_reminder', 'slug' => 'ats-scheduling-reminder', 'description' => 'ATS scheduling reminder template', 'subject' => 'subject', 'body' => 'body'
      ),
      array(
        'name' => 'ats_workflow_notice', 'slug' => 'ats-workflow-notice', 'description' => 'ATS workflow notices template, e.g. when a scorecard is marked complete for a candidate, a background check completed, a reference received for a candidate', 'subject' => 'subject', 'body' => 'body'
      ),
    );

    return $records[$recordId - 1];
  }
}
