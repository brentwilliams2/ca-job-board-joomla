<?php
/**
 * Admin Model behavior class to filter access to items based on the 'enabled' field status,
 * over-ridden to handle TreeModel errors with 'ambiguous query field'
 *
 * @package   Calligraphic Job Board
 * @version   October 16, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Model\Behaviour;

defined('_JEXEC') or die;

class Enabled extends \FOF30\Model\DataModel\Behaviour\Enabled
{
	/**
	 * This event runs before we have built the query used to fetch a record
	 * list in a model. It is used to apply automatic query filters.
	 *
	 * @param   DataModel      &$model The model which calls this event
	 * @param   \JDatabaseQuery &$query The query we are manipulating
	 *
	 * @return  void
	 */
	public function onBeforeBuildQuery(&$model, &$query)
	{
    $fieldNameAlias = $model->getFieldAlias('enabled');

		// Sanity check
		if ( !$model->hasField($fieldNameAlias) )
		{
			return;
    }

    $db = $model->getDbo();

    // DataModel path
    if ($model instanceof \FOF30\Model\DataModel)
		{
			$model->where( $db->quoteName($fieldNameAlias) . ' = ' . $db->quote(1) );
    }

    // TreeModel path
    elseif ($model instanceof \FOF30\Model\TreeModel)
    {
      $model->where( $db->quoteName('node') . '.' . $db->quoteName($fieldNameAlias) . ' = ' . $db->quote(1) );
    }
  }
}