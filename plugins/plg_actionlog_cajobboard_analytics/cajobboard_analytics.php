<?php
/**
 * Action Log Plugin for Calligraphic Job Board Analytics Events
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

defined('_JEXEC') or die();

use \Joomla\CMS\Component\ComponentHelper;
use \Joomla\CMS\MVC\Model\BaseDatabaseModel;

// Load FOF
if (!defined('FOF30_INCLUDED') && !@include_once(JPATH_LIBRARIES . '/fof30/include.php'))
{
  return;
}

class plgActionlogCajobboardAnalytics extends JPlugin
{
  /**
   * Only load the Joomla! Action Log model once
   */
  static $joomlaModelAdded = false;

	/**
	 * Constructor. Called on every page load, so should do minimal work.
	 *
	 * @param       object $subject The object to observe
	 * @param       array  $config  An array that holds the plugin configuration
	 */
	public function __construct(& $subject, $config)
	{
		// Include required Joomla Model
		if (!$this->joomlaModelAdded)
		{
      BaseDatabaseModel::addIncludePath(JPATH_ROOT . '/administrator/components/com_actionlogs/models', 'ActionlogsModel');

			$this->joomlaModelAdded = true;
    }

		parent::__construct($subject, $config);
	}


	/**
	 * Logs the creation of a new backup profile
	 *
	 * @param \Calligraphic\Cajobboard\Admin\Model\JobPostings	$model
	 * @param array   $data
	 * @param int			$id
	 */
	public function onCalligraphicJobPostingCreate($model, $data, $id)
	{
    // @TODO: logic to create analytics record for new job posting

    // logUserAction($title, $logText, $extension)
		return $this->logUserAction($profile_title, 'COM_CAJOBBOARD_LOGS_PROFILE_ADD');
  }


  /**
   * Log the action to the Action Log
   *
   * @param string $title
   * @param string $extension
   *
   * @return void
   */
	public function logUserAction($title, $extension)
	{
    /*
      Example Message in table #__action_logs

      'message':

      {
        "action":"checkin",
        "type":"PLG_ACTIONLOG_JOOMLA_TYPE_USER",
        "id":"753",
        "title":"admin",
        "itemlink":"index.php?option=com_users&task=user.edit&id=753",
        "userid":"753",
        "username":"admin",
        "accountlink":"index.php?option=com_users&task=user.edit&id=753",
        "table":"#__extensions"
      }

 	    'message_language_key':

        PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN

      Translation key in en-GB.plg_actionlog_joomla.ini:

        PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN="User <a href='{accountlink}'>{username}</a> logged in to {app}"

      Example admin panel output, where first 'admin' is a link:

        User admin logged in to admin

      Example message from Joomla! user action log plugin:

        $message = array(
          'action'   => $isNew ? 'add' : 'update',
          'type'     => $params->text_prefix . '_TYPE_' . $params->type_title,
          'id'       => $id,
          'title'    => $article->get($params->title_holder),
          'itemlink' => ActionlogsHelper::getContentTypeLink($option, $contentType, $id, $params->id_holder)
        );

        $this->addLog(array($message), $messageLanguageKey, $context);

      administrator/components/com_actionlogs/models/actionlog.php

    	* @param   array    $messages            The contents of the messages to be logged
      * @param   string   $messageLanguageKey  The language key of the message, a translation look-up key e.g. PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN
      * @param   string   $context             The 'extension' field of #__action_logs, with values like 'com_content.article'
      * @param   integer  $userId              ID of user perform the action, usually ID of current logged in user. Will default to 0 if not provided.
      *
      * @return  void
      public function addLog($messages, $messageLanguageKey, $context, $userId = null)
    */

		$user = $this->getUser();

		// No log for guest users
		if ($user->guest)
		{
			return false;
		}

		$message = array(
			'title' => $title
		);

		try
		{
      $model = BaseDatabaseModel::getInstance('Actionlog', 'ActionlogsModel');

			$model->addLog(array($message), $logText, $extension, $user->id);
		}
		catch (\Exception $e)
		{
			return false;
    }

    return true;
	}
}
