<?php
/**
 * Base Admin Hierarchical Nested List Model for all Job Board Models
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c) 2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

namespace Calligraphic\Library\Platform;

use FOF30\Model\DataModel\Relation\BelongsTo;
use FOF30\Model\DataModel\Relation\BelongsToMany;
use FOF30\Model\DataModel\Relation\HasMany;
use FOF30\Model\DataModel\Relation\HasOne;

// no direct access
defined('_JEXEC') or die;

class RelationManager extends \FOF30\Model\DataModel\RelationManager
{
	/**
	 * Populates the static map of relation type methods and relation handling classes
	 *
	 * @return array Key = method name, Value = relation handling class
	 */
	public static function getRelationTypes()
	{
		if (empty(static::$relationTypes))
		{
      $relationClasses = array(
        'BelongsTo' => '\\FOF30\\Model\\DataModel\\Relation\\BelongsTo',
        'BelongsToMany' => '\\FOF30\\Model\\DataModel\\Relation\\BelongsToMany',
        'HasMany' => '\\FOF30\\Model\\DataModel\\Relation\\HasMany',
        'HasOne' => '\\FOF30\\Model\\DataModel\\Relation\\HasOne',

        // inverseSideOfHasOne is an alias for belongsTo() relation. FOF has a hasOne() relation, where the
        // relation field is in the foreign table and allowing 1 : 0..1 relations with a NOT NULL FK field.
        // This method is included to clearly indicate intent for 0..1 : 1 relations with nullable FK fields.
        // The need for this is due to following Schema.org entity schemas, where many properties are
        // logically single references, like "employmentType" referencing an enumerated list, even
        // though all Schema.org properties allow collections (FOF belongsTo).
        'inverseSideOfHasOne' => '\\FOF30\\Model\\DataModel\\Relation\\BelongsTo',
        // BelongsToSTI implements BelongsTo relationship with single table inheritance
        'BelongsToSTI' => '\\Calligraphic\\Library\\Platform\\BelongsTo'
      );

			foreach ($relationClasses as $relationClassName => $relationClass)
			{
				static::$relationTypes[$relationClassName] = $relationClass;
			}
    }

		return static::$relationTypes;
	}
}
