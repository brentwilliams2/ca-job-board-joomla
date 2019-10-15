<?php
/**
 * CLI Script to test the package install script by running it stand-alone. Also, apparently a grab-bag of helpful Joomla! CLI commands.
 *
 * @package   Calligraphic Job Board
 * @version   May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 *  Usage, from command prompt in job board package root directory:
 *
 *   composer seed <model name>
 */

include __DIR__ . '/CliApplication.php';

use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Table\Table;

// Load .sys language file for component
$lang = Factory::getLanguage();
$base_dir = JPATH_ADMINISTRATOR . '/components/com_cajobboard';
$lang->load('com_cajobboard.sys', $base_dir);

/**
 * Install script wrapper
 *
 * @var    JInput                       $input
 * @var    \Joomla\Registry\Registry    $config
 */
class InstallScriptTester extends CliApplication
{
	/**
	 * Default category entries to add on installation for the Job Board
	 *
	 * @var    Array
	 */
  public $categories = array(
    'Uncategorised',
    'Alerts',
    'Analytics',
    'Answers',
    'ApplicantTrackingRecords',
    'Applications',
    'AudioObjects',
    'Awards',
    'Candidates',
    'Compliance',
    'Email',
    'Help',
    'ImageObjects',
    'JobPostings',
    'Messages',
    'Organizations',
    'Panels',
    'Persons',
    'Places',
    'Profiles',
    'QAPages',
    'Questionnaires',
    'Questions',
    'Recommendations',
    'References',
    'Registrations',
    'Reports',
    'Resumes',
    'Reviews',
    'Scheduling',
    'Search',
    'Subscriptions',
    'Tasks',
    'VideoObjects',
  );


	/**
	 * User groups to add on installation
	 *
	 * @var    Array
	 */
  public $userGroups = array(
    'Connectors',
    'Employers',
    'Job Seekers',
    'Recruiters',
  );


	/**
	 * Default field values template for category entries
	 *
	 * @var    Array
	 */
  public $categoryTemplate = array(
    'extension'        => 'com_cajobboard',
    'published'        => 1,
    'access'           => 1,
    'created_user_id'  => 0,
    'language'         => '*',
    'params'           => '{"category_layout": "", "image": "", "image_alt": "", "thumbnail_aspect_ratio": "aspect-ratio-4-3", "image_aspect_ratio": "aspect-ratio-4-3"}',
    'metadata'         => '{"author": "", "robots": ""}',
  );


	/**
	 * Default models to add / remove asset records for on install / uninstall of the Job Board
	 *
	 * @var    Array
	 */
  public $assetEnabledModels = array(
    'Answers'
  );


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
  }


  /**
	 * Main method of class
	 */
  public function execute()
  {
    // Create the FOF Container object before any other code
    parent::execute();

    $this->removeComponentAssets();
  }


  /**
   * Add categories for component from install event programatically
   * in order to maintain nested table structure in #__categories
   *
   * @return void
   */
  function createCategories()
  {
    $currentCategories = $this->loadCategories();

    foreach ($this->categories as $category)
    {
      // Skip adding category if it already exists
      if (in_array($category, $currentCategories))
      {
        continue;
      }

      // Create a copy of the template array for category properties
      $data = array_merge($this->categoryTemplate);

      // Set the category description from the translation key in en-GB.com_cajobboard.sys.ini
      // remove any spaces from the category title when building the translation key
      $data['title'] = Text::_('COM_CAJOBBOARD_CATEGORY_TITLE_' . strtoupper(str_replace(' ', '', $category)));
      $data['description'] = $data['title'];

      // Initialize a new category
      $category = Table::getInstance('Category');

      // Bind passed category parameters to Category model
      $category->bind($data);

      // setLocation(integer $referenceId, string $position = 'after')
      $category->setLocation($category->getRootId(), 'last-child');

      // Check to make sure our data is valid. check() will auto generate alias if not set above.
      if (!$category->check())
      {
        throw new Error($category->getError(), 500);

        return false;
      }

      // Store the category
      if (!$category->store(true))
      {
        throw new Error($category->getError(), 500);

        return false;
      }

      // Build the path for our category and set it in the database
      $category->rebuildPath($category->id);
    }

    Table::getInstance('Category')->rebuild();
  }


  /**
   * Load categories to test if our new categories already exist, quick and dirty (not through Category model)
   *
   * @return array  An array of categories
   */
  function loadCategories()
  {
    // Get a db connection so we can find the installed version from #__extensions
    $db = Factory::getDbo();
    $query = $db->getQuery(true);

    $query
      ->select  ($db->quoteName('title'))
      ->from    ($db->quoteName('#__categories'))
      ->where   ($db->quoteName('extension') . ' = '. $db->quote('com_cajobboard'));

    $db->setQuery($query);

    return $db->loadColumn();
  }


  /**
   * Add a root and model default assets for the component
   *
   * @return void
   */
  function createAssets()
  {/*
    // Get the Joomla! asset model
    $assetModel = Table::getInstance('Asset');

    // @TODO: need a data structure for assets: name, title, parent_id, rules
    foreach ($data as $property => $value) {
      $category->$property = $value;
    }

    // Set the location in the tree
    $$assetModel->setLocation($$assetModel->getRootId(), 'last-child');

    // Check to make sure our data is valid. check() will auto generate alias if not set above.
    if (!$$assetModel->check())
    {
      throw new Error($$assetModel->getError(), 500);

      return false;
    }

    // Store the asset
    if (!$$assetModel->store(true))
    {
      throw new Error($$assetModel->getError(), 500);

      return false;
    }

    // Build the path for our category and set it in the database
    $$assetModel->rebuildPath($assetModel->id);

    // probably need rebuild method to rebuilt lgt/rgt
  */}


  /**
   * Remove assets for component from uninstall event programatically
   * in order to maintain nested table structure in #__assets
   *
   * @return void
   */
  function removeComponentAssets()
  {/*
    $db = Factory::getDbo();

    // get a list of all of the primary keys for this component's assets that need removed
    $query = $db->getQuery(true);

    $query
      ->select  ($db->quoteName('id'))
      ->from    ($db->quoteName('#__assets'))
      ->where   ($db->quoteName('name') . ' LIKE ' . $db->quote('com_cajobboard%'))
      ->order   ('id ASC');

    $db->setQuery($query);

    $componentAssetIds = $db->loadColumn();

    // Get a Joomla table instance to handle the removal
    $assetModel = Table::getInstance('Asset');

    foreach ($componentAssetIds as $assetId)
    {
      $assetModel->delete($assetId);
    }

    $assetModel->rebuild();
  */}


  /**
   * Add user groups on installation
   *
   * @return void
   */
  function addUserGroups()
  {
    $db = Factory::getDbo();

    // Get the PK of the "Registered" user group
    $query = $db->getQuery(true);

    $query
      ->select  ($db->quoteName(array('id', 'title')))
      ->from    ($db->quoteName('#__usergroups'))
      ->where   ($db->quoteName('title') . ' = '. $db->quote('Registered'));

    $db->setQuery($query);

    $registeredGroupId = $db->loadResult();

    unset($query);

    // Get a list of all of the existing user groups so we don't duplicate adding ones we want
    $query = $db->getQuery(true);

    $query
      ->select  ($db->quoteName('title'))
      ->from    ($db->quoteName('#__usergroups'));

    $db->setQuery($query);

    $existingUserGroups = $db->loadColumn();

    // Add our new user groups
    foreach ($this->userGroups as $userGroup)
    {
      if (!in_array($userGroup, $existingUserGroups))
      {
        $groupModel = Table::getInstance('Usergroup');

        $groupModel->save(array(
          'title' => $userGroup,
          'parent_id' => $registeredGroupId
        ));
      }
    }

    Table::getInstance('Usergroup')->rebuild();
  }
}

// Execute this CLI application
$app = CliApplication::getInstance('InstallScriptTester');
\Factory::$application = $app;
$app->execute();

