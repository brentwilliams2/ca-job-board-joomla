<?php
/**
 * @package     Calligraphic Job Board
 * @subpackage  User.cajobboard
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// no direct access
defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;


// @TODO: Should the different profiles (employer, job seeker, recruiter) have different profile plugins?


/**
 * Custom user profile plugin.
 */
class PlgUserCajobboard extends JPlugin
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 * @since  1.0
	 */
  protected $autoloadLanguage = true;

	/**
	 * Constructor
	 *
	 * @param   object  &$subject  The object to observe
	 * @param   array   $config    An array that holds the plugin configuration
	 *
	 * @since   1.5
	 */
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		JFormHelper::addFieldPath(__DIR__ . '/field');
  }

	/**
	 * Runs on content preparation
   *
   * Called after the data for a JForm has been retrieved. It can be used
   * to modify the data for a JForm object in memory before rendering.
	 *
	 * @param   string  $context  The context for the data
	 * @param   object  $data     An object containing the data for the form.
	 *
	 * @return  boolean
	 *
	 * @since   1.0
	 */
	public function onContentPrepareData($context, $data)
	{
		// Check we are manipulating a valid form.
		if (!in_array($context, array('com_users.profile','com_users.registration','com_users.user','com_admin.profile'))){
			return true;
		}

		$userId = isset($data->id) ? $data->id : 0;

		// Load the profile data from the database.
		$db = JFactory::getDbo();
		$db->setQuery(
			'SELECT profile_key, profile_value FROM #__user_profiles' .
			' WHERE user_id = '.(int) $userId .
			' AND profile_key LIKE \'cajobboard.%\'' .
			' ORDER BY ordering'
		);
		$results = $db->loadRowList();

		// Check for a database error.
		if ($db->getErrorNum()) {
			$this->_subject->setError($db->getErrorMsg());
			return false;
		}

		// Merge the profile data.
		$data->cajobboard = array();
		foreach ($results as $v) {
			$k = str_replace('cajobboard.', '', $v[0]);
			$data->cajobboard[$k] = json_decode($v[1], true);
		}

		return true;
  }

	/**
	 * Adds additional fields to the user editing form
   *
   * Called before a JForm is rendered. It can be used to modify the JForm object in memory
   * before rendering. For example, use JForm->loadFile() to add fields or JForm->removeField()to remove fields.
   * Or use JForm->setFieldAttribute() or other JForm methods to modify fields for the form.
	 *
	 * @param   JForm  $form  The form to be altered.
	 * @param   mixed  $data  The associated data for the form.
	 *
	 * @return  boolean
	 *
	 * @since   1.0
	 */
	public function onContentPrepareForm(JForm $form, $data)
	{
		// Load user_profile plugin language
		$lang = JFactory::getLanguage();
		$lang->load('plg_user_cajobboard', JPATH_ADMINISTRATOR);

		if (!($form instanceof JForm)) {
			$this->_subject->setError('JERROR_NOT_A_FORM');
			return false;
		}
		// Check we are manipulating a valid form.
		if (!in_array($form->getName(), array('com_users.profile', 'com_users.registration','com_users.user','com_admin.profile'))) {
			return true;
		}
		if ($form->getName()=='com_users.profile')
		{
			// Add the profile fields to the form.
			JForm::addFormPath(dirname(__FILE__).'/profiles');
			$form->loadFile('profile', false);

			// Toggle whether the something field is required.
			if ($this->params->get('profile-require_something', 1) > 0) {
				$form->setFieldAttribute('something', 'required', $this->params->get('profile-require_something') == 2, 'cajobboard');
			} else {
				$form->removeField('something', 'cajobboard');
			}
		}

		//In this example, we treat the frontend registration and the back end user create or edit as the same.
		elseif ($form->getName()=='com_users.registration' || $form->getName()=='com_users.user' )
		{
			// Add the registration fields to the form.
			JForm::addFormPath(dirname(__FILE__).'/profiles');
			$form->loadFile('profile', false);

			// Toggle whether the something field is required.
			if ($this->params->get('register-require_something', 1) > 0) {
				$form->setFieldAttribute('something', 'required', $this->params->get('register-require_something') == 2, 'cajobboard');
			} else {
				$form->removeField('something', 'cajobboard');
			}
		}
  }

	/**
	 * Method is called before user data is stored in the database
   *
   * This event is triggered before an update of a user record. The old and new user
   * parameters are provided; commonly-used members are: username, name, email, password,
   * password_clear. Returning false aborts the save.
	 *
	 * @param   array    $user   Holds the old user data.
	 * @param   boolean  $isnew  True if a new user is stored.
	 * @param   array    $data   Holds the new user data.
	 *
	 * @return  boolean
	 *
	 * @since   1.0
	 * @throws  InvalidArgumentException on invalid date.
	 */
	public function onUserBeforeSave($user, $isnew, $data)
	{
		// Do any validation here, return false on validation failure.

		return true;
  }

	/**
	 * Saves user profile data
   *
   * This event is triggered after an update of a user record, or when a new
   * user has been stored in the database.
	 *
	 * @param   array    $data    Array of user object properties
	 * @param   boolean  $isNew   true if this is a new user
	 * @param   boolean  $result  true if saving the user in persistent store was successful
	 * @param   string   $error   error message if save failed
	 *
	 * @return  boolean
	 */
	public function onUserAfterSave($data, $isNew, $result, $error)
	{
		$userId	= JArrayHelper::getValue($data, 'id', 0, 'int');

		if ($userId && $result && isset($data['cajobboard']) && (count($data['cajobboard'])))
		{
			try
			{
				$db = JFactory::getDbo();
				$db->setQuery('DELETE FROM #__user_profiles WHERE user_id = '.$userId.' AND profile_key LIKE \'cajobboard.%\'');
				if (!$db->query()) {
					throw new Exception($db->getErrorMsg());
				}

				$tuples = array();
				$order	= 1;
				foreach ($data['cajobboard'] as $k => $v) {
					$tuples[] = '('.$userId.', '.$db->quote('cajobboard.'.$k).', '.$db->quote(json_encode($v)).', '.$order++.')';
				}

				$db->setQuery('INSERT INTO #__user_profiles VALUES '.implode(', ', $tuples));
				if (!$db->query()) {
					throw new Exception($db->getErrorMsg());
				}
			}
			catch (JException $e) {
				$this->_subject->setError($e->getMessage());
				return false;
			}
		}

		return true;
  }

	/**
	 * Remove all user profile information for the given user ID after user is deleted
	 *
	 * @param   array    $user     An associative array of the columns in the user table
	 * @param   boolean  $success  True if the deletion was successful
	 * @param   string   $msg      JError object if delete failed
	 *
	 * @return  boolean
	 */
	public function onUserAfterDelete($user, $success, $msg)
	{
		if (!$success) {
			return false;
		}

		$userId	= JArrayHelper::getValue($user, 'id', 0, 'int');

		if ($userId)
		{
			try
			{
				$db = JFactory::getDbo();
				$db->setQuery(
					'DELETE FROM #__user_profiles WHERE user_id = '.$userId .
					" AND profile_key LIKE 'cajobboard.%'"
				);

				if (!$db->query()) {
					throw new Exception($db->getErrorMsg());
				}
			}
			catch (JException $e)
			{
				$this->_subject->setError($e->getMessage());
				return false;
			}
		}

		return true;
	}
}
