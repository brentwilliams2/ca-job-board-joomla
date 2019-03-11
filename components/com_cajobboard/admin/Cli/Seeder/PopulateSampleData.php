<?php
/**
 * CLI Script to populate sample data using FOF "ORM"
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 *  Usage, from command prompt in job board package root directory:
 *
 *   composer seed <model name>
 */

include realpath(__DIR__ . '/../CliApplication.php');

use FOF30\Container\Container;
use Calligraphic\Cajobboard\Admin\Cli\Seeder\RelationMapper;
use Calligraphic\Cajobboard\Admin\Helper\CategoryHelper;
use Calligraphic\Cajobboard\Admin\Helper\JsonHelper;
use Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates\UsersTemplate;

// JTable::addIncludePath(JPATH_ADMINISTRATOR.'/libraries/joomla/table');

/**
 * Calligraphic Job Board Sample Data Seeder CLI Application
 *
 * @var    JInput                       $input
 * @var    \Joomla\Registry\Registry    $config
 */
class PopulateSampleData extends CliApplication
{
  /**
	 * An initial seed to use with Faker. Using the same seed twice
   * generates the same Faker output both times.
	 *
	 * @var   int
	 */
  protected $seed;

  /**
	 * The models that this script should generate sample data for.
	 *
	 * @var   Array
	 */
  protected $models;

  /**
	 * A scaling factor for how many sample data records should be generated.
   * Defaults to 1. This allows $count to specify the relative number of each
   * model's sample data records necessary for a basic installation, and
   * scale up without recalculating.
	 *
	 * @var    int
	 */
  protected $scaling;

  /**
	 * An array of $modelName => $number showing how many sample data records
   * to generate for each model.
	 *
	 * @var    Array
	 */
  protected $count;

  /**
	 * Array of category records for the Job Board. Each array item is a stdClass object with properties:
   *
   *   $category->id, $category->title, $category->language, $category->level
	 *
	 * @var    Array
	 */
  protected $categories = null;

  /**
	 * Tag records for the Job Board
	 *
	 * @var    Array
	 */
  protected $tags = null;

  /**
	 * User records for the Job Board
	 *
	 * @var    Array
	 */
  protected $users;

 	/**
	 * A manager to handle foreign keys from sample data in the model templates
	 *
	 * @var   RelationMapper
	 */
  protected $relationMapper;

	/**
	 * Class constructor
	 *
   * @param JInputCli   $input
   * @param JRegistry   $config
   * @param JDispatcher $dispatcher
	 */
  public function __construct(JInputCli $input = null, JRegistry $config = null, JDispatcher $dispatcher = null)
  {
    parent::__construct($input, $config, $dispatcher);

    // Load the configuration file
    $file = file_get_contents(__DIR__ . DS . 'config.json');

    if (false === $file)
    {
      throw new Exception("The config.json file can't be found\n");
    }

    $config = json_decode($file, true);

    // Throw an error if the config.json file isn't valid JSON
    if(!$config)
    {
      throw new Exception("There is a JSON error in the config.json file:\n" . JsonHelper::getJsonErrorDesc() . "\n");
    }

    $this->seed       = $config['seed'];
    $this->models     = $config['models'];
    $this->count      = $config['count'];
    $this->scaling    = $config['scaling'];
    $this->relationMapper = new RelationMapper($this->count);

    // Load the user records file
    unset($file);
    $file = file_get_contents(__DIR__ . DS . 'user.json');

    if (false === $file)
    {
      throw new Exception("The user.json file can't be found\n");
    }

    $this->users = json_decode($file, true);

    // Throw an error if the user.json file isn't valid JSON
    if(!$this->users)
    {
      throw new Exception("There is a JSON error in the user.json file:\n" . JsonHelper::getJsonErrorDesc() . "\n");
    }
  }

  /**
	 * Main method of class
	 */
  public function execute()
  {
    // Create the FOF Container object
    parent::execute();

    // Create user records if they're not set
    $userConfig = new stdClass();
    $userConfig->seed = $this->seed['Users'];

    foreach (array_keys($this->users) as $userType)
    {
      $userConfig->userType = $userType;

      $user = $this->users[$userType];

      if ($user['count'] > count($user['existing']))
      {
        for ($i = 1; $i <= $user['count'] - count($user['existing']); $i++)
        {
          try
          {
            $model = $this->container->factory->model('Persons', array('factoryClass' => 'FOF30\\Factory\\MagicFactory'));

            $template = new UsersTemplate();

            $data = $template->generate($userConfig);

            $model->bind($data);
          }
          catch(Exception $e)
          {
            $this->out($e->getMessage());
            exit();
          }
        }
      }
    }

    // Create a config object to pass to field faker functions
    $config = new stdClass();

    $config->users = $this->users;

    // Add all user IDs to cache
    $userIds = array();

    foreach (array_keys($this->users) as $userType)
    {
      array_push($userIds, $this->users[$userType]['existing']);
    }

    // Flatten the array into a single-dimensional array
    $config->userIds = call_user_func_array('array_merge', $userIds);

    // Get category records for the Job Board
    $config->categories = CategoryHelper::getCategories();

    // Get tag records for the Job Board
    $config->tags = $this->getTags();

    // add the Join Table Manager to the config object to pass to field faker methods
    $config->relationMapper = $this->relationMapper;

    // Run each model template set in config.json
    foreach($this->models as $modelName)
    {
      $class = 'Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates\\' . $modelName . 'Template';

      if (!class_exists($class))
      {
        throw new Exception("Template class doesn't exist:\n" . $class . "\n");
      }

      $this->truncateTable($this->container, $modelName);

      // Get the seed for this model
      $config->seed = $this->seed[$modelName];

      // Run this model template for the number of items of each model
      // (adjusted by scaling factor) that is set in config.json
      for ($i = 1; $i <= $this->count[$modelName] * $this->scaling; $i++)
      {
        try
        {
          // Add $i to the config object. We use this as the primary key value when
          // we need a PK value to pass in the templates to the relation mapper
          $config->item_id = $i;

          $model = $this->container->factory->model($modelName, array('factoryClass' => 'FOF30\\Factory\\MagicFactory'));

          $template = new $class();

          $data = $template->generate($config);

          $recordId = $model->create($data)->getId();

          $this->out("Saved $modelName item #$recordId");
        }
        catch(Exception $e)
        {
          $this->out($e->getMessage());
          exit();
        }
      }
    }
  }


   /**
   * Truncate a table for the current model so we can load sample data fresh
   *
   * @param  Container  $container  The FOF container object
   * @param  string     $modelName   The name of the model to truncate
   */
  public function truncateTable($container, $modelName)
  {
    $db = $this->container->db;

    // Remove all records for the given modelName from its database table
    $query = $db->getQuery(true);

    $query->delete($db->quoteName('#__cajobboard_' . strtolower($modelName)));

    $db->setQuery($query);

    try
    {
      $result = $db->execute();
    }
    catch (Exception $e)
    {
      throw new Exception("Could not truncate table for model name: $modelName\n" . $e);
    }

    // Remove all item-level access control records from the '#__assets' table for this model
    $query = $db->getQuery(true);

    // Build a "LIKE" SQL clause to match asset records for this model
    $condition = array(
      $db->quoteName('name')
      . ' LIKE '
      . $db->quote(
        $this->container->componentName
        . '.'
        . strtolower($container->inflector->singularize($modelName))
        . '%'
      )
    );

    // @TODO: do a raw-SQL truncate so primary key numbering restarts

    $query
      ->delete($db->quoteName('#__assets'))
      ->where($condition);

    $db->setQuery($query);

    try
    {
      $result = $db->execute();
    }
    catch (Exception $e)
    {
      throw new Exception("Could not remove asset records for model name: $modelName\n" . $e);
    }
  }


  /**
   * Display a banner above CLI application output
   */
  protected function displayBanner()
  {
    $this->out("Calligraphic Job Board");
    $this->out("Sample Data Seeder");
  }


  /**
   * Get the tag records for the Job Board and cache them
   */
  protected function getTags()
  {
    if (!$this->tags)
    {
      $this->tags = null;
      $this->out("@TODO: Implement fetching tag records. This uses UCM and has to be done from the model.");
    }

    return $this->tags;
  }
}

// Execute this CLI application
$app = CliApplication::getInstance('PopulateSampleData');
\JFactory::$application = $app;
$app->execute();
