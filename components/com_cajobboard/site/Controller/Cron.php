<?php
/**
 * Controller for Cron tasks
 * 
 * @package   Calligraphic Job Board
 * @version   September 12, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
namespace Calligraphic\Cajobboard\Site\Controller;

defined('_JEXEC') or die;

// @TODO: Decide if we want to use the Akeeba Subs Cron script for our component

// @TODO: Cron tasks to add:  Need to run Smart Search CLI Indexer from Cron:
//          php -d memory_limit=256M finder_indexer.php

use \Akeeba\Subscriptions\Admin\Controller\Mixin;
use \FOF30\Container\Container;
use \FOF30\Controller\Controller;
use \Joomla\CMS\Log\Log;
use \Joomla\CMS\Filter\InputFilter;

class Cron extends Controller
{
  use \Calligraphic\Cajobboard\Admin\Controller\Mixin\PredefinedTaskList;

	/**
	 * Overridden. Limit the tasks we're allowed to execute.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
		$this->modelName = 'Subscribe';

		$this->csrfProtection = 0;

		// $this->resetPredefinedTaskList();

    $this->addPredefinedTaskList(array(
			'cron'
		));

		parent::__construct($container, $config);
  }


	public function cron()
	{
		// Register a new generic Akeeba Subs CRON logger
    Log::addLogger(['text_file' => 'akeebasubs_cron.php'], Log::ALL, ['akeebasubs.cron']);

    Log::add("Starting CRON job", Log::DEBUG, "akeebasubs.cron");

		// Makes sure SiteGround's SuperCache doesn't cache the CRON view
    $app = \JFactory::getApplication();

    $app->setHeader('X-Cache-Control', 'False', true);

    $configuredSecret = $this->container->params->get('secret', '');

		if (empty($configuredSecret))
		{
			Log::add("No secret key provided in URL", Log::ERROR, "akeebasubs.cron");
			header('HTTP/1.1 503 Service unavailable due to configuration');
			$this->container->platform->closeApplication();
    }

    $secret = $this->input->get('secret', null, 'raw');

		if ($secret != $configuredSecret)
		{
      Log::add("Wrong secret key provided in URL", Log::ERROR, "akeebasubs.cron");

      header('HTTP/1.1 403 Forbidden');

			$this->container->platform->closeApplication();
    }

    $command        = $this->input->get('command', null, 'raw');

    $command        = trim(strtolower($command));

    $commandEscaped = InputFilter::getInstance()->clean($command, 'cmd');

		if (empty($command))
		{
      Log::add("No command provided in URL", Log::ERROR, "akeebasubs.cron");

      header('HTTP/1.1 501 Not implemented');

      $this->container->platform->closeApplication();

    }

		// Register a new task-specific Akeeba Subs CRON logger
    Log::addLogger(['text_file' => "akeebasubs_cron_$commandEscaped.php"], Log::ALL, ['akeebasubs.cron.' . $command]);

    Log::add("Starting execution of command $commandEscaped", Log::DEBUG, "akeebasubs.cron");

    $this->container->platform->importPlugin('system');

    $this->container->platform->importPlugin('akeebasubs');

		$this->container->platform->runPlugins('onAkeebasubsCronTask', array(
			$command,
			array(
				'time_limit' => 10
			)
    ));

    Log::add("Finished running command $commandEscaped", Log::DEBUG, "akeebasubs.cron");

    echo "$command OK";

		$this->container->platform->closeApplication();
	}
}
