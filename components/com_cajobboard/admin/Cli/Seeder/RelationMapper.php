<?php
/**
 * POPO Object Template for Answer model sample data seeding
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

namespace Calligraphic\Cajobboard\Admin\Cli\Seeder;

use Calligraphic\Cajobboard\Admin\Helper\Enum\BasicEnum;
use \Exception;
use \Faker;
use \Joomla\CMS\Factory;
use \stdClass;

// no direct access
defined('_JEXEC') or die;

/*
 * Relation types this sample data generator can handle
 *
 * This ENUM class is only loaded when class JoinTableManager is
 * instantiated, and unavailable to other classes using the autoloader.
 */
abstract class RelationTypes extends BasicEnum {
  const BelongsTo = null;
  const InverseSideOfHasOne = null;
  const InverseSideOfHasMany = null;
}

/*
 * use $config->item_id: this is $i in the for loop
 *  0 no value in join field
 *  1 single record for each join, to first record in related field
 *  > 1 many records, to range between second and last record in related field
 */
class RelationMapper
{
 	/**
	 * An array of the model names providing foreign
   * keys to other model's templates and setters
	 *
	 * @var Array
	 */
  protected $modelFKProviders;


	/**
	 * Class constructor
	 *
	 * @param   Array  $itemCountPerModel   The 'count' key of model names => number of items, from the application config.json file
	 */
	public function __construct($itemCountPerModel)
	{
    $this->modelFKProviders = array_keys($itemCountPerModel);

    // First-level array keys are the model names
    foreach ($itemCountPerModel as $modelName => $itemCount)
    {
      $this->$modelName = $itemCount;
    }
  }


  /**
	 *  Call an appropriate handler to get a foreign key value for a model` relation field
   *
	 *  @param   string  $relationType      The type of relation, a valid constant from RelationTypes abstract class
	 *  @param   Array   $config            The config object passed to the calling method by generate().
   *  @param   bool    $isRequired        Whether this foreign key value is required or not. Defaults to true.
   *  @param   Faker   $faker             A Faker object for generating deterministic random numbers.
   *  @param   string  $foreignModelName  The name of the foreign model being joined. Defaults to null.
   *  @param   string  $joinTableName     The Join Table name for HasMany relations
	 */
  public function getFKValue($relationType, $config, $isRequired = true, $faker = null, $foreignModelName = null, $joinTableName = null)
  {
    if (!RelationTypes::isValidConstant($relationType))
    {
      throw new Exception('Relation type in Relation Mapper\'s getFKValue() method is not valid: ' . $relationType);
    }

    if (RelationTypes::InverseSideOfHasOne == $relationType)
    {
      return $this->InverseSideOfHasOne($config, $isRequired);
    }

    // Make sure we have a foreign model name for other relation types
    if ( !isset($foreignModelName) )
    {
      throw new Exception('foreignModelName given to Relation Mapper\'s getFKValue() method is not set or is invalid: ' . $foreignModelName . ', $relationType: ' . $relationType);
    }

    // RelationType must be InverseSideOfHasMany or BelongsTo
    return $this->$relationType($config, $isRequired, $faker, $foreignModelName);
  }


  /**
	 * HasOne relations seeder for the inverse side model's foreign key field
   *
   * Maps 1:1, assumes the current model has the same count of items to generate as the foreign model in config.json
   * This function is unaware of what the foreign model is, just that the subject model needs a FK for a relation field
	 *
	 * @param   Array  $config      The config object passed to the calling method by generate().
   * @param   bool   $isRequired  Whether this foreign key value is required or not. Defaults to true.
	 */
  public function InverseSideOfHasOne($config, $isRequired = true)
  {
    // If it's not a required relation, then make:
    // (a) one item with no relation
    if (!$isRequired && 1 == $config->item_id)
    {
      return null;
    }

    // (b) rest of items with relation to entity with same primary key as this item
    return $config->item_id;
  }


  /**
	 * HasMany relations seeder for the inverse side model's foreign key field
	 *
	 * @param   Array  $config      The config object passed to the calling method by generate().
   * @param   Faker  $faker       A Faker object for generating deterministic random numbers.
   * @param   bool   $isRequired  Whether this foreign key value is required or not.
	 */
  public function InverseSideOfHasMany($config, $isRequired, $faker, $foreignModelName)
  {
    // If it's not a required relation, then make one item with no relation
    if (!$isRequired && 1 == $config->item_id)
    {
      return null;
    }
    elseif (1 == $config->item_id)
    {
      return 1;
    }

    // Make two (if $isRequired = true) or three (if $isRequired = false) items point
    // to a single foreign model item to show a sparsely-populated view
    if (2 == $config->item_id || 3 == $config->item_id)
    {
      return 1;
    }

    return $faker->numberBetween(2, $this->$foreignModelName);
  }


  /**
	 * BelongsTo relations seeder for the subject side model's foreign key field
   *
   * Alias to InverseSideOfHasMany()
	 *
	 * @param   Array  $config      The config object passed to the calling method by generate().
   * @param   Faker  $faker       A Faker object for generating deterministic random numbers.
   * @param   bool   $isRequired  Whether this foreign key value is required or not.
	 */
  public function BelongsTo($config, $isRequired, $faker, $foreignModelName)
  {
    return $this->InverseSideOfHasMany($config, $isRequired, $faker, $foreignModelName);
  }


  /**
	 * Seeder for BelongsToMany relations
	 *
	 * @param   Array   $config                   The config object passed to the calling method by generate()
   * @param   Faker   $faker                    A Faker object for generating deterministic random numbers.
   * @param   string  $foreignModelName         The name of the foreign model
   * @param   string  $modelIdFieldName         The PK of this model
   * @param   string  $foreignModelIdFieldName  The PK of the foreign model
   * @param   string  $joinTableName            The name of the join table, e.g. '#__cajobboard_interviews_questions'
   * @param   int     $count                    The number of join records to create for this single seed record
	 */
  public function BelongsToMany($config, $faker, $modelIdFieldName, $foreignModelName, $foreignModelIdFieldName, $joinTableName, $count = 1)
  {
    $db = Factory::getDbo();

    if (1 == $config->item_id)
    {
      $db->truncateTable($joinTableName);
    }

    for ($i = 0; $i < $count; $i++)
    {
      $query = $db->getQuery(true);

      $query
        ->insert( $db->quoteName($joinTableName) )
        ->columns( $db->quoteName( array($modelIdFieldName, $foreignModelIdFieldName) ) )
        ->values( implode(',', array($config->item_id, $this->BelongsTo($config, true, $faker, $foreignModelName) ) ) );

      $db->setQuery($query);

      $db->execute();
    }
  }
}
