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

namespace Calligraphic\Cajobboard\Admin\Model\Mixin;

use \Joomla\Registry\Registry;

// no direct access
defined('_JEXEC') or die;

/**
 * NOTE: Attribute getters/setters and Behaviours have the same effect, except that Behaviours
 *       can be overridden by model. Only add here if there is no chance it will need to be overridden.
 *
 * Transformations for model properties:
 *
 *   getMyAttribute($value)
 *
 * Called from find() or getItemsArray() via bind() via databaseDataToRecordData(), which
 * loops through all $recordData items, after bind()'s body is finished but before onAfterBind
 * event is fired. Also called from save() when that method is provided with optional data,
 * e.g. the DataController applySave() method calls getMyAttribute() with input->getData() as
 * the $value. save() subsequently calls the setMyAttribute() method before saving to the database.
 *
 *   setMyAttribute($value)
 *
 * Called from save() method to transform model properties to their database format before they
 * are saved with insertObject() / updateObject() JDatabase calls.
 */
trait Attributes
{
  /**
	 * Transform 'metadata' field to a JRegistry object on bind
	 *
	 * @return  Registry
	 */
  protected function getMetadataAttribute($value)
  {
    $metadata = $this->transformJsonToRegistry($value);

    // @TODO: Implement inheritance for robots / Author metadata tags (by component / by category / by global)

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


  /**
	 * Transform 'params' field to a JRegistry object on bind
	 *
	 * @return  Registry
	 */
  protected function getParamsAttribute($value)
  {
    return $this->transformJsonToRegistry($value);
  }


  /**
	 * Transform 'params' field's JRegistry object to a JSON string before save
	 *
	 * @return  string  JSON string
	 */
  protected function setParamsAttribute($value)
  {
    return $this->transformRegistryToJson($value);
  }
}
