<?php
/**
 * Overridden model behavior class to order comments based on about__foreign_model_id / about__foreign_model_name fields
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
namespace Calligraphic\Cajobboard\Admin\Model\Behaviour\Comments;

use \FOF30\Event\Observer;
use \FOF30\Model\DataModel;
use \JDatabaseQuery;

// no direct access
defined( '_JEXEC' ) or die;

/**
 * Ordering and order direction are checked for validity in the DataModel
 * before use so no danger here of setting them to request state
 */
class Ordering extends Observer
{
  /**
	 * Set the first ordering parameter here
	 *
	 * @param   DataModel           $model  The model which called this event
	 * @param   JDatabaseQuery      &$query  The query we are manipulating
	 *
	 * @return  void
	 */
	public function onBeforeBuildQuery(DataModel $model, &$data)
	{
    $orderBy = $model->getState('filter_order', 'featured');
    $orderDir = $model->getState('filter_order_Dir', 'DESC');

    $sessionOrderBy  = $model->getContainer()->input->get('filter_order');
    $sessionOrderDir = $model->getContainer()->input->get('filter_order_Dir');

    $sessionOrderBy  ? $orderBy = $sessionOrderBy : $orderBy;
    $sessionOrderDir ? $orderDiry = $sessionOrderDiry : $orderDir;

    // if filter_order is set to primary key field (probably
    // set by default), change it to order by default value.
    if ( $orderBy == $model->getIdFieldName() )
    {
      $model->setState('filter_order', 'featured');
    }
    else
    {
      $model->setState('filter_order', $orderBy);
    }

    $model->setState('filter_order_Dir', $orderDir);


    $model->orderBy($orderBy, $orderDir);
  }


	/**
	 * Set the second and subsequent ordering parameters here
	 *
	 * @param   DataModel           $model  The model which called this event
	 * @param   JDatabaseQuery      &$query  The query we are manipulating
	 *
	 * @return  void
	 */
	public function onAfterBuildQuery(DataModel $model, &$query)
	{
    $orderBy = $model->getState('filter_order', 'featured');

    // Only set the second ordering parameter if we haven't over-ridden
    // the default ordering ('featured) in the first order parameter
    if ('featured' == $orderBy)
    {
      $db = $model->getDbo();

      $orderId = $db->quoteName('created_on') . ' DESC';

      $query->order(array($orderId));
    }
  }
}
