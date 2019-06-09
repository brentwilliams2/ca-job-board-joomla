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

use FOF30\Container\Container;

defined('_JEXEC') or die();

JLoader::import('joomla.application.plugin');

class plgActionlogCajobboardAnalytics extends JPlugin
{
	/** @var Container */
	private $container;

	/**
	 * Constructor
	 *
	 * @param       object $subject The object to observe
	 * @param       array  $config  An array that holds the plugin configuration
	 *
	 * @since       6.4.0
	 */
	public function __construct(& $subject, $config)
	{
		JLoader::import('joomla.application.component.helper');

		if ( !JComponentHelper::isEnabled('com_cajobboard'))
		{
			return;
		}

		// Load FOF
		if (!defined('FOF30_INCLUDED') && !@include_once(JPATH_LIBRARIES . '/fof30/include.php'))
		{
			return;
		}

		$this->container = Container::getInstance('com_cajobboard');

		// No point in logging guest actions
		if ($this->container->platform->getUser()->guest)
		{
			return;
		}

		// If any of the above statement returned, our plugin is not attached to the subject, so it's basically disabled
		parent::__construct($subject, $config);
	}


	/**
	 * Logs the creation of a new backup profile
	 *
	 * @param \Akeeba\Backup\Admin\Controller\Profiles	$controller
	 * @param array										$data
	 * @param int										$id
	 */
	public function onComAkeebaControllerProfilesAfterApplySave($controller, $data, $id)
	{
    // $data['id']
    // $data['description']
    // $this->container->input->get('ajax', '', 'cmd');
    // $this->container->platform->getSessionVar('profile', -10, 'akeeba');

    // logUserAction($title, $logText, $extension)
		$this->container->platform->logUserAction($profile_title, 'COM_CAJOBBOARD_LOGS_PROFILE_ADD', 'com_cajobboard');
	}
}
