<?php
/**
 * Trait to override base Count method and implement caching
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Model\Mixin;

// no direct access
defined('_JEXEC') or die;

trait Count
{
  /**
   * A count of the number of records for this model when
   *
   * @var int
   */
  protected $count;

	/**
	 * Get the number of all items
	 *
	 * @return  integer
	 */
	public function count()
	{
		// Get a "count all" query
    $db = $this->getDbo();

    $query = $this->buildQuery(true);

    $query->clear('select')->clear('order')->select('COUNT(*)');

		// Run the "before build query" hook and behaviours
    $this->triggerEvent('onBuildCountQuery', array(&$query));

    $total = $db->setQuery($query)->loadResult();

		return $this->count = $total;
	}
}
