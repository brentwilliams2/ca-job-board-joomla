<?php
/**
 * Calligraphic Job Board Privacy Plugin
 *
 * @package     Calligraphic Job Board
 * @subpackage  User Plugin User.cajobboard
 * @version     0.1 May 1, 2018
 * @author      Calligraphic, LLC http://www.calligraphic.design
 * @copyright   Copyright (C) 2018 Calligraphic, LLC
 * @license     http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

  // no direct access
  defined('_JEXEC') or die;

JLoader::register('PrivacyPlugin', JPATH_ADMINISTRATOR . '/components/com_privacy/helpers/plugin.php');

/**
 * Privacy plugin managing job board user data
 *
 * @since  3.9.0
 */
class PlgPrivacyCajobboard extends PrivacyPlugin
{
	/**
	 * Processes an export request for Joomla core user content data
	 *
	 * This event will collect data for the content core table
	 *
	 * - Content custom fields
	 *
	 * @param   PrivacyTableRequest  $request  The request record being processed
	 * @param   JUser                $user     The user account associated with this request if available
	 *
	 * @return  PrivacyExportDomain[]
	 *
	 * @since   3.9.0
	 */
	public function onPrivacyExportRequest(PrivacyTableRequest $request, JUser $user = null)
	{
    throw new \Exception('implement privacy plugin for job board');
    /*
		if (!$user)
		{
			return array();
		}
		$domains   = array();
		$domain    = $this->createDomain('user_content', 'joomla_user_content_data');
		$domains[] = $domain;
		$query = $this->db->getQuery(true)
			->select('*')
			->from($this->db->quoteName('#__content'))
			->where($this->db->quoteName('created_by') . ' = ' . (int) $user->id)
			->order($this->db->quoteName('ordering') . ' ASC');
		$items = $this->db->setQuery($query)->loadObjectList();
		foreach ($items as $item)
		{
			$domain->addItem($this->createItemFromArray((array) $item));
		}
		$domains[] = $this->createCustomFieldsDomain('com_content.article', $items);
    return $domains;
    */
	}
}
