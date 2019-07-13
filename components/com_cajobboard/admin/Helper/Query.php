<?php
/**
 * Admin Repository buildQuery Helper Class
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Cajobboard\Admin\Helper;

// no direct access
defined('_JEXEC') or die;

class Query
{
	/**
	 * Correctly quote an array of SQL column aliases (AS) conveniently with Joomla's quoting methods:
   *
   *   $query = $db->getQuery(true)->select( $query->quoteColumnNames( array('job_posting_id', 'slug') ));
   *
   * @param   Container $container  A container instance
   * @param   array $columns  Array with either columns as indexed values, or with alias as key/value $column => $alias
	 *
	 * @return  void
	 */
	public function quoteColumnNames(Container $container, $columns)
	{
    if (is_array($columns))
    {
      $db = $this->getDbo();

      $columnName = array();
      $as = array();

      foreach ($columns as $key => $value)
      {
        if (is_numeric($key))
        {
          array_push($columnName, $value);
          array_push($as, null);
        }
        else
        {
          array_push($columnName, $key);
          array_push($as, $value);
        }
      }

      return $db->qn($columnName, $as);
    }
    else
    {
      throw new Exception("Array passed to quoteColumnNames() is null", 1);

    }
  }

	/**
	 * Applies custom WHERE clauses to the query
	 *
	 * @return  void
	 */
	protected function applyWhereClauses(&$query)
	{
    if (count($this->whereClauses))
    {
      foreach ($this->whereClauses as $clause)
      {
        $query->where($clause);
      }
    }
  }
}
