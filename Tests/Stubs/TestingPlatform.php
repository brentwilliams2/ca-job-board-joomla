<?php
/**
 * Plugin Testing Platform for Calligraphic Job Board
 *
 * F0F Platform class is an adapter/facade to Joomla! CMS classes.
 * This class adds mocks to allow testing plugins.
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018-2019 Calligraphic LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

namespace Calligraphic\Cajobboard\Tests\Stubs;

use FOF30\Platform\Joomla\Platform;

class TestingPlatform extends Platform
{
	/** @var   array   Fake plugin event handlers. Format: eventName => callable[] */
  protected static $eventHandlers = [];

	/**
	 * Fake load plugins of a specific type
	 *
	 * @param   string $type The type of the plugins to be loaded
	 *
	 * @see PlatformInterface::importPlugin()
	 *
	 * @return void
	 *
	 * @codeCoverageIgnore
	 */
	public function importPlugin($type)
	{
		return;
  }

	/**
	 * Reset the fake event handlers
	 */
	static function resetEventHandlers()
	{
		static::$eventHandlers = [];
  }

	/**
	 * Add a fake event handler
	 *
	 * @param   string   $event    Name of the event
	 * @param   callable $handler  Event handler
	 */
	static function addEventHandler($event, callable $handler)
	{
    $event = strtolower($event);

		if (!isset(static::$eventHandlers[$event]))
		{
			static::$eventHandlers[$event] = [];
		}
		static::$eventHandlers[$event][] = $handler;
  }

	/**
	 * Execute plugins (system-level triggers) and fetch back an array with
	 * their return values.
	 *
	 * @param   string $event The event name, e.g. onBeforeTask
	 * @param   array  $data  A hash array of data sent to the plugins as part of the trigger
	 *
	 * @see PlatformInterface::runPlugins()
	 *
	 * @return  array  A simple array containing the results of the plugins triggered
	 *
	 * @codeCoverageIgnore
	 */
	public function runPlugins($event, $data)
	{
    $return = [];

    $event = strtolower($event);

		if (isset(static::$eventHandlers[$event]))
		{
			foreach (static::$eventHandlers[$event] as $handler)
			{
				$return[] = call_user_func_array($handler, $data);
			}
		}
		return $return;
	}
}
