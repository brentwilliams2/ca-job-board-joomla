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

use Exception;
use stdClass;
use Faker;

use Calligraphic\Cajobboard\Admin\Helper\BasicEnum;

// no direct access
defined('_JEXEC') or die;

/*
 * Relation types this sample data generator can handle
 *
 * This ENUM class is only loaded when class JoinTableManager is
 * instantiated, and unavailable to other classes using the autoloader.
 */
abstract class RelationTypes extends BasicEnum {
  const BelongsTo = 0;
  const InverseSideOfHasOne = 1;
  const InverseSideOfHasMany = 2;
  const BelongsToMany = 3;
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
	 * @param   Array  $joinMap   The join map from the application config.json file
	 */
	public function __construct($count)
	{
    $this->modelFKProviders = array_keys($count);

    // First-level array keys are the model names
    foreach ($count as $model => $itemCount)
    {
      $this->$model = $itemCount;
    }
  }

  /**
	 *  Call an appropriate handler to get a foreign key value for a model relation field
   *
	 *  @param   string  $relationType   The type of relation, a valid constant from RelationTypes abstract class
	 *  @param   Array   $config         The config object passed to the calling method by generate().
   *  @param   Faker   $faker          A Faker object for generating deterministic random numbers.
   *  @param   bool    $isRequired     Whether this foreign key value is required or not.
   *  @param   string  $foreignModel   The name of the foreign model being joined
	 */
  public function getFKValue($relationType, $config, $isRequired, $faker = null, $foreignModel = null)
  {
    if (!RelationTypes::isValidName($relationType))
    {
      throw new Exception("Relation type in Relation Mapper's getFKValue() method is not valid: $relationType");
    }

    if (RelationTypes::InverseSideOfHasOne === $relationType)
    {
      return $this->InverseSideOfHasOne($config, $isRequired, $faker);
    }
    else
    {
      // Determine the model and property being worked on
      list($null, $caller) = debug_backtrace(false, 2);

      // Assigned to local variables in order to avoid pass-by-reference error, PHP language limitation
      $callingClassArray = explode('\\', $caller['class'] );
      $callingClass = array_pop($callingClassArray);

      $model = preg_replace('/Template$/', '', $callingClass);
      $field = $caller['function'];

      return $this->$relationType($config, $isRequired, $faker, $model, $field, $foreignModel);
    }
  }

  /**
	 * HasOne relations seeder for the inverse side model's foreign key field
   *
   * Maps 1:1, assumes the current model has the same count of items to generate as the foreign model in config.json
   * This function is unaware of what the foreign model is, just that the subject model needs a FK for a relation field
	 *
	 * @param   Array  $config      The config object passed to the calling method by generate().
   * @param   Faker  $faker       A Faker object for generating deterministic random numbers.
   * @param   bool   $isRequired  Whether this foreign key value is required or not.
	 */
  public function InverseSideOfHasOne($config, $isRequired, $faker)
  {
    // If it's not a required relation, then make one item with no relation
    if (!$isRequired && 1 == $config->item_id)
    {
      return null;
    }

    return $config->item_id;
  }

  /**
	 * HasMany relations seeder for the inverse side model's foreign key field
	 *
	 * @param   Array  $config      The config object passed to the calling method by generate().
   * @param   Faker  $faker       A Faker object for generating deterministic random numbers.
   * @param   bool   $isRequired  Whether this foreign key value is required or not.
	 */
  public function InverseSideOfHasMany($config, $isRequired, $faker, $model, $field, $foreignModel)
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

    return $faker->numberBetween(4, $this->$foreignModel);
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
  public function BelongsTo($config, $isRequired, $faker, $model, $field, $foreignModel)
  {
    return $this->InverseSideOfHasMany($config, $isRequired, $faker, $model, $field, $foreignModel);
  }

  /**
	 * Seeder for BelongsToMany relations
	 *
	 * @param   Array  $config   The config object passed to the calling method by generate()
	 */
  public function BelongsToMany($config, $isRequired, $faker, $model, $field, $foreignModel)
  {
    throw new Exception ('BelongsToMany() method in RelationMapper not implemented');
  }
}
