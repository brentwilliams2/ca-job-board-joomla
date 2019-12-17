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

use \Calligraphic\Cajobboard\Admin\Cli\Seeder\Exception\CliApplicationException;
use \Calligraphic\Cajobboard\Admin\Cli\Seeder\RelationMapper;
use \Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates\UsersTemplate;
use \Calligraphic\Cajobboard\Admin\Helper\Category;
use \Calligraphic\Cajobboard\Admin\Helper\Json;
use \FOF30\Container\Container;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Input\Cli;
use \Joomla\CMS\Table\Table;
use \Joomla\CMS\User\UserHelper;
use \Joomla\Registry\Registry;


/**
 * Calligraphic Job Board Sample Data Seeder CLI Application
 *
 * @var    \JInput                       $input
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
   * Keys are the usergroup name ('Employer', 'JobSeeker', 'Recruiter', 'Connector')
   * Each key holds an assoc array with the keys 'count' (integer value) and 'existing'
   * (array of user IDs that are existing).
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
	 */
  public function __construct()
  {
    parent::__construct();
    $this->loadConfig();
    $this->loadUserMap();
  }


  /**
	 * Load the config.json file and set config from it
   *
   * @return void
	 */
  public function loadConfig()
  {
    // Load the configuration file
    $file = file_get_contents(__DIR__ . DS . 'config.json');

    if (false === $file)
    {
      throw new CliApplicationException("The config.json file can't be found\n");
    }

    $config = json_decode($file, true);

    // Throw an error if the config.json file isn't valid JSON
    if(!$config)
    {
      throw new CliApplicationException("There is a JSON error in the config.json file:\n" . Json::getJsonErrorDesc() . "\n");
    }

    $this->count      = $config['count'];
    $this->scaling    = $config['scaling'] ? $config['scaling'] : 1;
    $this->seed       = $config['seed'] ? $config['seed'] : 1;

    $this->relationMapper = new RelationMapper($this->count);

    $arg = $this->input->args[0];

    // Allow specifying a single model name on the command line to populate
    if ($arg && 'remove' != $arg)
    {
      // Only a single model may be specified on the command line
      if ( count($this->input->args) > 1 )
      {
        throw new CliApplicationException("Only one model can be specified as a parameter on the command line for individual seeding, received: " . implode(", ", $this->input->args) . "\n" );
      }

      // Make sure the CLI argument is a valid model to populate in the seeder's config
      if ( in_array( $arg, $config['models'] ))
      {
        $this->models = array($arg);
      }
      else
      {
        throw new CliApplicationException("The model specified as a parameter on the command line for individual seeding isn't valid in config.json, received: " . implode(", ", $this->input->args) . "\n" );
      }
    }
    else
    {
      $this->models = $config['models'];
    }
  }


  /**
	 * Load the user.json map file of created users
   *
   * @return void
	 */
  public function loadUserMap()
  {
    $file = file_get_contents(__DIR__ . DS . 'user.json');

    if (false === $file)
    {
      throw new CliApplicationException("The user.json file can't be found\n");
    }

    $this->users = json_decode($file, true);

    // Throw an error if the user.json file isn't valid JSON
    if(!$this->users)
    {
      throw new CliApplicationException("There is a JSON error in the user.json file:\n" . Json::getJsonErrorDesc() . "\n");
    }
  }


  /**
	 * Main method of class
   *
   * @return void
	 */
  public function execute()
  {
    // Create the FOF Container object
    parent::execute();

    // allow removing the data in a table, this allows the model to handle it's own clean-up: asset records, etc.
    if ( $this->input->args[0] && 'remove' == $this->input->args[0] )
    {
      // Make sure there's only two arguments, 'remove' and the name of the Model
      if ( count($this->input->args) != 2 )
      {
        throw new CliApplicationException("Too many arguments after 'remove', only a single model name permitted.\n" );
      }

      // Make sure the model name is valid
      if ( !in_array($this->input->args[1], $this->models) )
      {
        throw new CliApplicationException("Model name given to remove isn't valid: " . $this->input->args[1] . "\n" );
      }

      $this->truncateTable($this->input->args[1]);

      return;
    }

    // Create a config object for the User template
    $userConfig = new \stdClass();

    $this->addSampleUsers($userConfig);

    // Create a config object for model sample data generators to pass to field faker functions
    $config = new \stdClass();

    $config->users =& $this->users;

    // Add all user IDs to cache
    $userIds = array();

    foreach (array_keys($this->users) as $userType)
    {
      array_push($userIds, $this->users[$userType]['existing']);
    }

    // Flatten the $userIds array into a single-dimensional array
    $flattenedUserIds = call_user_func_array('array_merge', $userIds);
    $config->userIds =& $flattenedUserIds;

    // Get category records for the Job Board. Array of stdClass objects with category properties.
    $categories = Category::getCategories();
    $config->categories =& $categories;

    // Get tag records for the Job Board
    $tags = $this->getTags();
    $config->tags =& $tags;

    // add the Join Table Manager object to the config object to pass to field faker methods
    $config->relationMapper = $this->relationMapper;

    $this->addSampleData($config);
  }


  /**
	 *  Add sample users to the database
   *
   * @param  $userConfig  A configuration object
	 *
   *  @return void
	 */
  public function addSampleUsers($userConfig)
  {
    $isUserConfigDirty = false;

    // $users class property is a nested arrray, loaded from JSON data in user.json
    foreach (array_keys($this->users) as $userType)
    {
      $userConfigClone = clone $userConfig;
      $userConfigClone->userType = $userType;

      // Get the array for this user type, should have `count` and `existing` keys
      $user = $this->users[$userType];

      // `count` key is int, `existing` key is flat array of existing user IDs for the user type
      if ($user['count'] > count($user['existing']))
      {
        $loops = $user['count'] - count($user['existing']);

        for ($i = 1; $i <= $loops; $i++)
        {
          try
          {
            $model = $this->container->factory->model('Persons', array('factoryClass' => 'FOF30\\Factory\\MagicFactory'));

            $template = new UsersTemplate();

            $data = $template->generate($userConfigClone, $this->seed++);

            $model->save($data);

            // Add the new user ID to our list of existing users
            array_push( $this->users[$userType]['existing'], $model->getId() );

            $isUserConfigDirty = true;
          }
          catch(\Exception $e)
          {
            $this->out($e->getMessage());
            exit();
          }
        }
      }
    }

    // Add the join table records for user <-> usergroups M:M relation
    $this->addJoinRecordUserToGroup();

    if($isUserConfigDirty)
    {
      // Save the mutated $userConfig array (with new user IDS) back as JSON in user.json
      $userFile = __DIR__ . DS . 'user.json';
      $userData = json_encode($this->users);

      if (false === $userData)
      {
        throw new CliApplicationException("The data to save back to user.json isn't valid JSON:\n" . Json::getJsonErrorDesc() . "\n");
      }

      try
      {
        file_put_contents($userFile, $userData);
      }
      catch(\Exception $e)
      {
        $this->out("Couldn't save data back to user.json: " . $e->getMessage());
        exit();
      }
    }
  }


  /**
	 * Add join table record to `#__user_usergroup_map` for sample data users
	 */
  public function addJoinRecordUserToGroup()
  {
    $db = $this->container->db;

    // #1 Get all maps from `#__user_usergroup_map`
    $query = $db->getQuery(true);

    $query
      ->select  ($db->quoteName('user_id'))
      ->from    ($db->quoteName('#__user_usergroup_map'));

    $db->setQuery($query);

    // These are the users who already have a record, and don't need one created
    $mappedUsers = $db->loadColumn();

    // #2 Get `id` and `title` for usergroups from `#__usergroups` table
    unset($query);
    $query = $db->getQuery(true);

    $query
      ->select  ($db->quoteName(array('id', 'title')))
      ->from    ($db->quoteName('#__usergroups'));

    $db->setQuery($query);

    // Each key in $existingUserGroups is the usergroup table row, and
    // the value is  an assoc array with keys `id` and `title`
    $existingUserGroups = $db->loadAssocList();

    // Flatten the associative array we got back from Joomla! above
    $groups = array();

    foreach($existingUserGroups as $group)
    {
      $groupId = $group['id'];

      // Strip white space characters from user group titles, which are human-readable e.g. 'Job Seekers'
      $groups[$groupId] = preg_replace('/\s+/', '', $group['title']);
    }

    // Iterate through each of our user groups from our user.json config file
    foreach ($this->users as $userGroup => $userData)  // 'Connector', 'Recruiter', 'JobSeeker', 'Employer'
    {
      $userGroupNormalized = implode('', preg_grep( '/' . $userGroup . '/i' , $groups));

      $userGroupId = array_search($userGroupNormalized, $groups);

      // Iterate through all user IDs already created
      foreach ($userData['existing'] as $userId)
      {
        // Make sure the user doesn't already have a join table record saved
        if (!in_array($userId, $mappedUsers))
        {
          UserHelper::addUserToGroup($userId, $userGroupId);
        }
      }
    }
  }


  /**
	 * Add sample data to the database
   *
   * @param   $config   A configuration object
	 *
   * @return void
	 */
  public function addSampleData($config)
  {
    // Run each model template set in config.json or a single model specified on the command line
    foreach($this->models as $modelName)
    {
      $class = 'Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates\\' . $modelName . 'Template';

      if (!class_exists($class))
      {
        throw new CliApplicationException("Template class doesn't exist:\n" . $class . "\n");
      }

      $this->truncateTable($modelName);

      $nextConfig = clone $config;

      if ( !array_key_exists($modelName, $this->count) )
      {
        throw new CliApplicationException("Model " . $modelName . " doesn't exist in config.json count parameter.\n");
      }

      // Run this model template for the number of items of each model
      // (adjusted by scaling factor) that is set in config.json
      for ($i = 1; $i <= $this->count[$modelName] * $this->scaling; $i++)
      {
        try
        {
          // Add $i to the config object. We use this as the primary key value when
          // we need a PK value to pass in the templates to the relation mapper
          $nextConfig->item_id = $i;

          $model = $this->container->factory->model($modelName, array('factoryClass' => 'FOF30\\Factory\\MagicFactory'));

          $template = new $class();

          $data = $template->generate( $nextConfig, $this->seed++ );

          // save the new record
          if ( property_exists($template, 'hasRoot') )
          {
            // TreeModel
            $db = $model->getDbo();

            $idFieldName = $model->getIdFieldName();

            $query = $db->quoteName($idFieldName) . ' = ' . $db->quote(1);

            $rootNode = $model->getClone()->reset()->where($query)->firstOrFail();

            $model->bind($data);

            $recordId = $model->insertAsLastChildOf($rootNode)->getId();
          }
          else
          {
            // DataModel
            $recordId = $model->create($data)->getId();
          }

          $this->out("Saved $modelName item #$recordId");
        }
        catch(\Exception $e)
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
   * @param  string     $modelName   The name of the model to truncate
   */
  public function truncateTable($modelName)
  {
    $db = $this->container->db;

    // Convert model name from PascalCase to snake_case, add Joomla! table name prefix and quote it
    $tableName = '#__cajobboard_' . strtolower( preg_replace('/(?<!^)[A-Z]/', '_$0', $modelName) );

    // Remove all records for the given modelName from its database table
    try
    {
      $db->truncateTable($tableName);

      $query = $db->getQuery(true);

      // Reset the primary key to number new records from '1'
      $query->setQuery('ALTER TABLE ' . $tableName . ' AUTO_INCREMENT = 1');

      $query->execute();
    }
    catch (\Exception $e)
    {
      throw new CliApplicationException("Could not truncate table for model name: $modelName\n" . $e);
    }

    $this->RemoveAssetsForModel($modelName);
  }


  /**
   * Remove assets for records in tables that are being truncated
   *
   * @return void
   */
  function removeAssetsForModel($modelName)
  {
    // Normalize the model name, e.g. JobPostings to job_posting
    $normalModelName = strtolower( $this->container->inflector->singularize($modelName) );

    $db = $this->container->db;

    // Get a list of all item-level access control records from the '#__assets' table for this model
    $query = $db->getQuery(true);

    // Build a "LIKE" SQL clause to match asset records for this model
    $condition = array(
      $db->quoteName('name') . ' LIKE ' . $db->quote(
        $this->container->componentName . '.' . $normalModelName . '.%'
      )
    );

    $query
      ->select  ($db->quoteName('id'))
      ->from    ($db->quoteName('#__assets'))
      ->where   ($condition);

    $db->setQuery($query);

    try
    {
      $assetIdsToRemove = $db->loadColumn();
    }
    catch (\Exception $e)
    {
      throw new CliApplicationException("Could not get asset records in removeAssets() for model name: $modelName\n" . $e);
    }

    // Remove any assets
    if ($assetIdsToRemove)
    {
      $assetModel = Table::getInstance('Asset');

      foreach ($assetIdsToRemove as $assetId)
      {
        $assetModel->delete($assetId);
      }
    }

    // Rebuild the nesting on the `#__assets` table
    Table::getInstance('Asset')->rebuild();
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
Factory::$application = $app;
$app->execute();
