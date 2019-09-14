<?php
/**
 * Trait for seeding join tables (belongsToMany relations)
 *
 * @package   Calligraphic Job Board
 * @version   September 11, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Use by unsetting the Template class property before returning from the class setter:
 *
 *   unset($this->my_belongs_to_many_temporary_relation_name);
 */

namespace Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates\Mixins;

// no direct access
defined('_JEXEC') or die;

trait SeedJoinTable
{
  /**
   * An array of join tables that have already been truncated
   *
   * @var   array   An array of pivot table names, e.g. '#__cajobboard_messages_video_objects'
   */
  protected static $truncatedJoinTables = array();


  /**
   * Seed a join table with sample data
   *
   * @property Faker  $faker
   * @property array  $config                 This template's configuration object
   * @property int    $chance                 Number between 0 and 10 indicating probability a record should be generated. 0 is no chance, 10 is 100%.
   * @property string $pivotTableName         The name of the join table
   * @property string $pivotLocalKeyName      The name of the local key field in the join table
   * @property string $foreignModelName       The name of the foreign model being joined to
   * @property string $pivotForeignKeyName    The name of the foreign key field in the join table
   *
   * @throws \RuntimeException
   */
  public function seedJoinTable ($faker, $config, $chance, $pivotTableName, $pivotLocalKeyName, $foreignModelName, $pivotForeignKeyName)
  {
    if ( !in_array($pivotTableName, self::$truncatedJoinTables) )
    {
      $this->truncateJoinTable($pivotTableName);
    }

    $randomInt = $faker->numberBetween(1, 10);

    if ($chance > $randomInt)
    {
      return;
    }

    $db = \JFactory::getDbo();

    $query = $db->getQuery(true);

    // Get the name of this model
    $className = explode( '\\', get_class($this) );
    $modelName = preg_replace('/Template$/', '', array_pop($className) );

    $localKeyValue = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, $modelName);

    $foreignKeyValue = $config->relationMapper->getFKValue('BelongsTo', $config, true, $faker, $foreignModelName);

    $profile = new \stdClass();

    $profile->$pivotLocalKeyName = $localKeyValue;
    $profile->$pivotForeignKeyName = $foreignKeyValue;

    $db->insertObject($pivotTableName, $profile);
  }


  /**
   * Truncate a join table before adding sample data
   *
   * @property string $pivotTableName         The name of the join table
   *
   * @throws \RuntimeException
   */
  public function truncateJoinTable ($pivotTableName)
  {
    $db = \JFactory::getDbo();

    $query = $db->getQuery(true);

    $db->setQuery( 'TRUNCATE TABLE ' . $db->quoteName($pivotTableName) );

    $db->execute();

    array_push(self::$truncatedJoinTables, $pivotTableName);
  }
}