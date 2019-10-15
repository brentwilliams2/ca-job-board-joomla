<?php
/**
 * Pagination Helper class for use in site views
 *
 * @package   Calligraphic Job Board
 * @version   July 13, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Site\Helper;

use \FOF30\Model\DataModel;
use \FOF30\View\DataView\DataViewInterface;
use \Joomla\CMS\HTML\HTMLHelper;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Pagination\Pagination as JoomlaPagination;

// no direct access
defined('_JEXEC') or die;

class Pagination
{
  /**
   * A reference to the application container
   *
   * @property Container
   */
  protected $container = null;


  /**
   * Whether the combo select box to limit the number of records shown on a page
   * should be displayed, based on config and the number of records from the query
   *
   * @property boolean
   */
  protected $showLimitBox = false;


  /**
	 * @param   Container   $container    The application container
	 */
	public function __construct ($container)
	{
    $this->container = $container;
  }


  /**
   * Whether the combo select box to limit the number of records shown on a page should be displayed
   *
	 * @return   boolean
	 */
	public function shouldDisplayLimitBox ()
	{
    return $this->showLimitBox;
  }


	/**
	 * Set the pagination object for this view
   *
   * @param  DataViewInterface  $view     The view object
   * @param  DataModel          $model    The model object for this view
	 *
	 * @return void
	 */
	public function setPaginationObject(DataViewInterface $view, DataModel $model)
	{
    // Display limits
		$defaultLimit = 20;

		$view->setItemCount( $model->count() );

    if (!$view->getContainer()->platform->isCli())
    {
      $app = $view->getContainer()->platform->getApplication();
      $defaultLimit = $app->get('list_limit', 20);
    }

    $lists = $view->getLists();

    $lists->limitStart = $model->getState('limitstart', 0, 'int');
    $lists->limit = $model->getState('limit', $defaultLimit, 'int');

    $model->limitstart = $lists->limitStart;
    $model->limit = $lists->limit;

		// Ordering information
		$lists->order = $model->getState('filter_order', $model->getIdFieldName(), 'cmd');
    $lists->order_Dir = $model->getState('filter_order_Dir', null, 'cmd');

		if ($lists->order_Dir)
		{
			$lists->order_Dir = strtolower($lists->order_Dir);
    }

    // Pagination
    $Pagination = new JoomlaPagination($view->getItemCount(), $lists->limitStart, $lists->limit);

    $view->setPagination($Pagination);

    $this->initShowLimitBox( $model, $view->getItemCount() );
  }


  /**
   * Sets state variable to control whether a combo box to control results per page should
   * be shown. Override state variable 'showLimitBox' in View if desired. This logic is
   * handled in the Joomla! Pagination class for the pagination buttons it creates, but
   * the Job Board uses a Blade template instead of a JHtml template to show the limit box.
   *
   * @param   DataModel   $model    The model attached to this view
   * @param   int         $count    The number of records to be paginated for this view
   *
   * @return void
   */
  private function initShowLimitBox(DataModel $model, $count)
  {
    if ( false == $model->getState('showLimitBox') )
    {
      return;
    }

    if ($count >= $model->limit)
    {
      $this->showLimitBox = $this->container->params->getConfigOption('showLimitBox', true, $model);
    }
  }
}
