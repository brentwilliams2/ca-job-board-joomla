<?php
/**
 * Admin Ordering Controller Mixin
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Controller\Mixin;

use \FOF30\Container\Container;

// no direct access
defined('_JEXEC') or die;

trait Ordering
{
  /**
	 * Set DataModel ordering for browse views
   *
   * Ordering and order direction are checked for validity in the DataModel
   * before use so no danger here of setting them to request state
	 *
	 * @return  void
	 */
	public function setOrdering($order = 'created_on', $orderDir = 'DESC')
	{
    $model = $this->getModel();

    // if filter_order is set to primary key field (assuming it was set by
    // default), change it to order by created_on date or passed parameter.
    if ( $model->getState('filter_order') == $model->getIdFieldName() )
    {
      $model->setState('filter_order', $order);
    }

    // if filter_order_Dir is already set in either the user input or user session,
    // respect the user's choice. Otherwise, override the default set in DataModel.
    $requestOrderDir = $model->getState('filter_order_Dir');
    $sessionOrderDir = $this->input->get('filter_order_Dir');

    if (!$requestOrderDir && !$sessionOrderDir)
    {
      $model->setState('filter_order_Dir', $orderDir);
    }
  }
}
