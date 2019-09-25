<?php
/**
 * Mixin to use an array of table fields instead of database reads on each table (Helper\TableFields)
 * 
 * @package   Calligraphic Job Board
 * @version   14 September, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Model\Mixin;

// no direct access
defined( '_JEXEC' ) or die;

/**
 * Trait for dealing with data stored as JSON-encoded strings
 */
trait TableFields
{
  /**
   * Setup the knownFields model property of database table metadata
   *
   * @param   string $tableName   Unused, maintain signature for overridden method.
   *
   * @return  array  An array of the field metadata.
   */
  public function getTableFields($tableName = null)
  {
    return $this->container->TableFields->getTableFieldsMetadata($this);
  }
}