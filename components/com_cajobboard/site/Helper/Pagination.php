<?php
/**
 * Extended Pagination object for use in site views
 *
 * @package   Calligraphic Job Board
 * @version   July 13, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Site\Helper;

use \FOF30\Model\DataModel;
use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Pagination\Pagination as JoomlaPagination;

// no direct access
defined('_JEXEC') or die;

/**
 * Pagination Class. Provides a common interface for content pagination using Joomla! CMS classes.
 */
class Pagination
{
  /**
   * A reference to the application container
   *
   * @property Container
   */
  protected $container = null;


  /**
	 * @param   Container   $container    The application container
	 */
	public function __construct ($container)
	{
    $this->container = $container;
  }


  /**
	 * Return a Joomla! Pagination instance.
	 *
	 * @param   integer         $total       The total number of items.
	 * @param   integer         $limitstart  The offset of the item to start at.
	 * @param   integer         $limit       The number of items to display per page.
	 * @param   string          $prefix      The prefix used for request variables.
	 * @param   CMSApplication  $app         The application object
	 */
  public function getJoomlaPaginator($total, $limitstart, $limit, $prefix = '', CMSApplication $app = null)
  {
    return new JoomlaPagination($total, $limitstart, $limit, $prefix, $app);
  }


  /**
	 * Create the pagination options for this view. This logic is refactored
   * out of the base Raw view's onBeforeBrowse() method.
   *
   * @param  DataModel  $model    The model object for this view
	 *
	 * @return void
	 */
	public function getPaginationParams(DataModel $model)
	{
    // Display limits
    $defaultLimit = 20;

  	// Create the lists object
    $paginationOptions = new \stdClass();

    $defaultLimit = $this->container->platform->getConfigOption('list_limit', 20);

    $model->limitstart = $paginationOptions->limitStart = $model->getState('limitstart', 0, 'int');

    $model->limit = $paginationOptions->limit = $model->getState('limit', $defaultLimit, 'int');

    // Ordering information
    // @TODO: display by "featured" at top and by date or other criteria like in admin section for Answers
    $paginationOptions->order = $model->getState('filter_order', 'created_on', 'cmd');

    $paginationOptions->order_Dir = $model->getState('filter_order_Dir', 'ASC', 'cmd');

		if ($paginationOptions->order_Dir)
		{
			$paginationOptions->order_Dir = strtolower($paginationOptions->order_Dir);
    }

    // $paginationOptions->order      The field name to order by
    // $paginationOptions->order_Dir  The direction to order by (ASC for ascending or DESC for descending)
    // Alias of $this->setState('filter_order', $paginationOptions->order) and $this->setState('filter_order_Dir', $paginationOptions->order_Dir)
    $model->orderBy($paginationOptions->order, $paginationOptions->order_Dir);

    return $paginationOptions;
  }


  /**
   * Create a Pagination object by querying the DB for a count of total items,
   * based on the previous query filters used to actually fetch the data.
   *
   * @param  DataModel  $model    The model object for this view
   * @param  \StdClass  $options  An object with properties
	 *
	 * @return void
   */
  public function getPaginator(DataModel $model, $paginationOptions)
	{
    // Run a "count all" query on the DB (or get the cached count)
    $this->itemCount = $model->count();

    // Create the view's pagination object with results from the model
    return $this->getJoomlaPaginator($this->itemCount, $paginationOptions->limitStart, $paginationOptions->limit);
  }
}
