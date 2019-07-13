<?php
/**
 * Attribute getters and setters for data-aware models
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Model\Mixin\Attributes;

use \Joomla\Registry\Registry;

// no direct access
defined('_JEXEC') or die;

/**
 * Transformations for model properties (attributes) to an appropriate data type (e.g.
 * Registry objects). Validation checks and setting attribute values from state should
 * be done in Behaviours (which can be enabled and overridden per model).
 *
 *   getMyAttribute($value)
 *
 * Getter called from find() or getItemsArray() via bind() via databaseDataToRecordData(), which
 * loops through all $recordData items, after bind()'s body is finished but before onAfterBind
 * event is fired. Also called from save() when that method is provided with optional data,
 * e.g. the DataController applySave() method calls getMyAttribute() with input->getData() as
 * the $value. save() subsequently calls the setMyAttribute() method before saving to the database.
 *
 *   setMyAttribute($value)
 *
 * Setter called from save() method to transform model properties to their database format before
 * they are saved with insertObject() / updateObject() JDatabase calls.
 */
trait Metadata
{
  /**
	 * Transform 'metadata' field to a JRegistry object on bind
	 *
	 * @return  Registry
	 */
  protected function getMetadataAttribute($value)
  {
    $metadata = $this->transformJsonToRegistry($value);

    return $metadata;
  }


  /**
	 * Transform 'metadata' field's JRegistry object to a JSON string before save
	 *
	 * @return  string  JSON string
	 */
  protected function setMetadataAttribute($value)
  {
    return $this->transformRegistryToJson($value);
  }
}
