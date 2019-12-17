<?php
/**
 * Attribute getters and setters for data-aware models
 *
 * @package   Calligraphic Job Board
 * @version   October 9, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Model\Mixin\Attributes;

use \Calligraphic\Library\Platform\Registry;

// no direct access
defined('_JEXEC') or die;

/**
 * Transformations for model properties (attributes) to an appropriate data type (e.g.
 * Registry objects). Validation checks and setting attribute values from state should
 * be done in Behaviours (which can be enabled and overridden per model).
 *
 * Getter called from bind() via databaseDataToRecordData(), which loops through all $recordData
 * items after bind()'s body is finished but before onAfterBind event is fired. Called via bind() from:
 *
 *  1. find()
 *  2. getItemsArray()
 *  3. save() when that method is provided with optional data.
 *
 *   getMyAttribute($value)
 *
 * Setter called only from save() method via recordDataToDatabaseData() to transform model properties to
 * their database format before they are saved with insertObject() / updateObject() JDatabase calls.
 * Results are typecast to (object).
 *
 *    setMyAttribute($value)
 */
trait Metadata
{
  /**
	 * Called from databaseDataToRecordData()
	 *
	 * @return  Registry
	 */
  protected function getMetadataAttribute($value)
  {
    $metadata = $this->transformJsonToRegistry($value);

    return $metadata;
  }


  /**
	 * Called from recordDataToDatabaseData()
	 *
	 * @return  string  JSON string
	 */
  protected function setMetadataAttribute($value)
  {
    return $this->transformRegistryToJson($value);
  }
}

