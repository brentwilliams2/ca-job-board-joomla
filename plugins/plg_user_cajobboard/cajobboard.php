<?php
/**
 * Joomla! User Profile Plugin
 *
 * Allows the addition of supplemental fields in the registration and profile forms
 * of the com_user front end and in the user create/edit form in the back end.
 *
 * Joomla! stupidly reuses the same events for user profile fields that it uses for
 * article (content) events. The event call is built-in to the Joomla base MVC classes.
 * Confusing!
 *
 * This plugin also handles the profile fields on user create / update / delete.
 *
 * @package     Calligraphic Job Board
 * @version     July 13, 2019
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2019 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// no direct access
defined('_JEXEC') or die;

use \Joomla\CMS\Factory;
use \Joomla\CMS\Form\FormHelper;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Log\Log;
use \Joomla\CMS\Plugin\CMSPlugin;
use \Joomla\Utilities\ArrayHelper;

/**
 * Custom user profile plugin.
 */
class PlgUserCajobboard extends CMSPlugin
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 */

  // Autoload language files in all clients, handled by JPlugin constructor
  protected $autoloadLanguage = true;

  // EAV table holding extended user profile information
  protected $profile_table = '#__user_profiles';

  // Key to store user extended profile information in EAV table ($this->profile_table)
  protected $profile_key = 'cajobboard';

  // Make sure we're not acting on calls for article (content) events, since Joomla! stupidly reuses the same events for both.
  protected $validForms = array(
    'com_users.profile',
    'com_users.registration',
    'com_users.user',
    'com_admin.profile'
  );


	/**
	 * Constructor
	 *
	 * @param   object  &$subject  The object to observe
	 * @param   array   $config    An array that holds the plugin configuration
	 */
	public function __construct(&$subject, $config)
	{
    parent::__construct($subject, $config);

    // Add the path for special XML form field definitions, like 'geo', 'region', and 'tos'
		FormHelper::addFieldPath(__DIR__ . '/field');
  }


	/**
   * Add supplemental profile fields in the registration and profile forms of the com_user front end
   *
   * Called from the following places:
   *
   *   (1)  \Joomla\CMS\User\UserHelper::getProfile($userId), with $context set to 'com_users.profile'
   *
   *   (2)  UsersModelRegistration->getData(), a method to get the registration form data,
   *        front-end com_users model, with $context set to  'com_users.registration'
   *
   *   (3)  UsersModelProfile->loadFormData(), a method to get the data that should be injected in the form,
   *        ront-end com_users model, with $context set to  'com_users.profile'
   *
   *   (4)  UsersModelNote->getItem($pk), admin com_users model, with $context set to 'com_users.note'
   *
   *   (5)  ContactModelContact->buildContactExtendedData($contact), to load extended data (profile,
   *        articles) for a contact, front-end com_contact model, with $context set to 'com_users.profile'
   *
   *   ...more, but the idea's clear
	 *
	 * @param   string  $context  The context for the data
	 * @param   object  $data     An object containing the data for the form.
	 *
	 * @return  boolean
	 */
	public function onContentPrepareData($context, $data)
	{
    // Return if we aren't manipulating a valid form.
    if ( !in_array($context, $this->validForms) ) return true;

    // Set user id to guest if not set in form data
		$userId = isset($data->id) ? $data->id : 0;

    $db = Factory::getDbo();

    // Load the profile data from the user profile table for this profile plug
    $query = $db->getQuery(true)
      ->select($db->quoteName(array('profile_key', 'profile_value')))
      ->from($db->quoteName($this->profile_table))
      ->where($db->quoteName('user_id') . " = " . (int) $userId)
      ->andWhere($db->quoteName('profile_key') . ' LIKE '. $db->quote('\'' . $this->profile_key . '.%\''))
      ->order('ordering ASC');

    // Get an indexed array of indexed arrays from the profile records returned by the query
    try {
      $db->setQuery($query);
      $results = $db->loadRowList();
    }
    catch (\Exception $e)
    {
      Log::add('Database error in plugin User, method onContentPrepareData: ' . $e->getMessage(), Log::ERROR, 'database');

      // Don't show the user a server error if there was an error in the database query
      throw new \Exception(Text::_('PLG_USER_CAJOBBOARD_DATABASE_ERROR'), 404);
    }

    $data->{$this->profile_key} = array();

    // Merge the profile data into the form data object.
		foreach ($results as $value) {
      // Remove the profile key from the attribute value for this EAV field,
      //  e.g. normalize "profile.address1" to "address1"
      $key = str_replace($this->profile_key . '.', '', $value[0]);

      // Get the attribute's value as a JSON string.
			$data->{$this->profile_key}[$key] = json_decode($value[1], true);
		}

		return true;
  }


	/**
	 * Adds additional fields to the user editing form
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
    // Only work on forms
    if (!($form instanceof JForm))
    {
      $this->_subject->setError('JERROR_NOT_A_FORM');

			return false;
    }

    // Return if we aren't manipulating a user profile form.
    if (!in_array($form->getName(), $this->validForms)) return true;

    // Add the profile fields to the form.
    \JForm::addFormPath(dirname(__FILE__).'/profiles');

    $form->loadFile('profile', false);

    return true;
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
	 * @throws  \InvalidArgumentException on invalid date.
	 */
	public function onUserBeforeSave($user, $isnew, $data)
	{
    // Do any validation here, return false on validation failure.

    // @TODO Need to validate worksFor, don't want people to be arbitrarily ad that they work for somebody without that organization's agreement

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
		$userId	= ArrayHelper::getValue($data, 'id', 0, 'int');

		if ($userId && $result && isset($data->{$this->profile_key}) && (count($data->{$this->profile_key})))
    {
      $db = Factory::getDbo();

      // Delete profile keys for this user first, for database engine-independent implementation
      $query = $db->getQuery(true)
        ->delete($db->quoteName($profile_table))
        ->where($db->quoteName('user_id') . " = " . $userId)
        ->andWhere($db->quoteName('profile_key') . ' LIKE '. $db->quote('\'' . $this->profile_key . '.%\''));

      try {
        $db->setQuery($query)->execute();
      }
      catch (\Exception $e)
      {
        // Don't show the user a server error if there was an error in the database query
        throw new \Exception(Text::_('PLG_USER_CAJOBBOARD_DATABASE_ERROR'), 404);
      }

      $tuples = array();
      $order	= 1;

      // Add the profile key to each attribute value, e.g. normalize "address1" to "profile.address1" and JSON-encoded value
      foreach ($data->{$this->profile_key} as $key => $value) {
        $tuples[] = '(' . $userId . ', ' . $db->quote($this->profile_key . '.' . $key) . ', ' . $db->quote(json_encode($value)) . ', ' . $order++ . ')';
      }

      // Columns to insert in the profiles table, matching our tuples built above
      $columns = array('user_id', 'profile_key', 'profile_value', 'ordering');

      // Query to add new additional profile records to database for this user
      $query = $db->getQuery(true)
        ->insert($db->quoteName($this->profile_table))
        ->columns($db->quoteName($columns))
        ->values(implode(',', $tuples));

      try {
        $db->setQuery($query)->execute();
      }
      catch (\Exception $e)
      {
        // Don't show the user a server error if there was an error in the database query
        throw new \Exception(Text::_('PLG_USER_CAJOBBOARD_DATABASE_ERROR'), 404);
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
    // Don't delete profile attributes and values for this user if deleting the user failed
		if (!$success) return false;

		$userId	= ArrayHelper::getValue($user, 'id', 0, 'int');

		if ($userId)
		{
      $db = Factory::getDbo();

      // Query to delete profile records for this user from database
      $query = $db->getQuery(true)
        ->getQuery(true)
        ->delete($db->quoteName($profile_table))
        ->where($db->quoteName('user_id') . " = " . $userId)
        ->andWhere($db->quoteName('profile_key') . ' LIKE '. $db->quote('\'' . $this->profile_key . '.%\''));

      try {
        $db->setQuery($query)->execute();
      }
      catch (\Exception $e)
      {
        // Don't show the user a server error if there was an error in the database query
        throw new \Exception(Text::_('PLG_USER_CAJOBBOARD_DATABASE_ERROR'), 404);
      }
    }

		return true;
	}
}
