<?php
/**
 * Admin Answer HTML View
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\View\Answers;

use FOF30\Container\Container;
use Joomla\CMS\HTML\HTMLHelper;
use JComponentHelper;
use JFactory;

// no direct access
defined('_JEXEC') or die;

if(!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

HTMLHelper::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR . '/Helper/Html');

class Html extends \FOF30\View\DataView\Html
{
	/**
	 * The component-level parameters stored in #__extensions by com_config
	 *
	 * @var  \JRegistry
	 */
  protected $componentParams;


	/**
	 * Overridden. Load view-specific language file.
	 *
	 * @param   Container $container
	 * @param   array     $config
	 */
	public function __construct(Container $container, array $config = array())
	{
    parent::__construct($container, $config);

    // Get component parameters
    $this->componentParams = \JComponentHelper::getParams('com_cajobboard');

    // Using view-specific language files for maintainability
    $lang = JFactory::getLanguage();

    // Load Answers language file
    $lang->load('answers', JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_cajobboard', $lang->getTag(), true);

    // Load javascript file for Job Posting views
    // $this->addJavascriptFile('media://com_cajobboard/js/imageObjects.js');
  }


	/**
	 * Overridden. Executes before rendering the page for the Browse task.
   * Modified to eager load Author relation to Persons model.
	 */
	protected function onBeforeBrowse()
	{
		// Create the lists object
    $this->lists = new \stdClass();

		// Load the model
		/** @var DataModel $model */
    $model = $this->getModel();

		// We want to persist the state in the session
    $model->savestate(1);

		// Display limits
    $defaultLimit = 20;

		if (!$this->container->platform->isCli() && class_exists('JFactory'))
		{
      $app = \JFactory::getApplication();

			if (method_exists($app, 'get'))
			{
				$defaultLimit = $app->get('list_limit');
			}
			else
			{
				$defaultLimit = 20;
			}
    }

		$this->lists->limitStart = $model->getState('limitstart', 0, 'int');
    $this->lists->limit = $model->getState('limit', $defaultLimit, 'int');

		$model->limitstart = $this->lists->limitStart;
    $model->limit = $this->lists->limit;

		// Assign items to the view
    $this->items = $model->with(array('Author', 'Publisher'))->get(false);

    $this->itemCount = $model->count();

		// Ordering information
		$this->lists->order = $model->getState('filter_order', $model->getIdFieldName(), 'cmd');
    $this->lists->order_Dir = $model->getState('filter_order_Dir', null, 'cmd');

		if ($this->lists->order_Dir)
		{
			$this->lists->order_Dir = strtolower($this->lists->order_Dir);
    }

		// Pagination
    $this->pagination = new \JPagination($this->itemCount, $this->lists->limitStart, $this->lists->limit);

		// Pass page params on frontend only
		if ($this->container->platform->isFrontend())
		{
			/** @var \JApplicationSite $app */
			$app = \JFactory::getApplication();
			$params = $app->getParams();
			$this->pageParams = $params;
		}
	}
}
