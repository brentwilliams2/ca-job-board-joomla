<?php
/**
* Install / uninstall script file of Calligraphic Job Board component
*
* @package   Calligraphic Job Board
* @version   0.1 May 1, 2018
* @author    Calligraphic, LLC http://www.calligraphic.design
* @copyright Copyright (C) 2018 Calligraphic, LLC
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*
*/

// @TODO: setParms() doesn't have any use atm

// @TODO: no method to create view access levels if desired

// no direct access
defined('_JEXEC') or die();

// Load FOF if not already loaded
if (!defined('FOF30_INCLUDED') && !@include_once(JPATH_LIBRARIES . '/fof30/include.php'))
{
	throw new RuntimeException('This component requires FOF 3.0.');
}

use \Joomla\CMS\Log\Log;
use \Joomla\CMS\Table\Table;
use \Joomla\CMS\Language\Text;

class com_cajobboardInstallerScript extends FOF30\Utils\InstallScript\Component
{
	/**
	 * The component's name
	 *
	 * @var   string
	 */
  protected $componentName = 'com_cajobboard';


	/**
	 * The minimum PHP version required to install this extension
	 *
	 * @var   string
	 */
  protected $minimumPHPVersion = '7.2.0';


	/**
	 * The minimum Joomla! version required to install this extension
	 *
	 * @var   string
	 */
  protected $minimumJoomlaVersion = '3.9.0';


	/**
	 * A list of scripts to be copied to the "cli" directory of the site
	 *
	 * @var   array
	 */
	protected $cliScriptFiles = array(
		// Use just the filename, e.g.
		// 'my-cron-script.php'
  );


	/**
	 * The path inside your package where cli scripts are stored
	 *
	 * @var   string
	 */
  protected $cliSourcePath = 'Cli';


	/**
	 * Obsolete files and folders to remove. Used to remove CLI scripts added with FOF installer.
   *
   * Use pathnames relative to the site's root, e.g. 'administrator/components/com_cajobboard'
   * Array can have the keys 'files' and 'folders
   *
	 * @var   array
	 */
	protected $removeFilesAllVersions = array(
		'files'   => array(
			// Remove CLI scripts
			'cli/unneded-script.php',
    ),
  );


	/**
	 * Default category entries to add on installation for the Job Board
	 *
	 * @var    Array
	 */
  public $categories = array(
    'AddressRegions',
    'AnalyticAggregates',
    'Answers',
    'ApplicationLetters',
    'Applications',
    'AudioObjects',
    'BackgroundChecks',
    'Candidates',
    'Categories',
    'Certifications',
    'Comments',
    'ControlPanels',
    'CreditReports',
    'DataFeeds',
    'DataFeedTemplates',
    'DigitalDocuments',
    'DiversityPolicies',
    'EmailMessages',
    'EmailMessageTemplates',
    'EmployerAggregateRatings',
    'EmploymentTypes',
    'FairCreditReportingAct',
    'GeoCoordinates',
    'Help',
    'ImageObjects',
    'Interviews',
    'IssueReportCategories',
    'IssueReports',
    'JobAlerts',
    'JobPostings',
    'Messages',
    'OccupationalCategories',
    'OccupationalCategoryGroups',
    'Offers',
    'OrganizationRoles',
    'OrganizationTypes',
    'Organizations',
    'PersonallyIdentifiableInformation',
    'Persons',
    'Places',
    'Profiles',
    'QAPages',
    'QuestionLists',
    'Questions',
    'References',
    'Registrations',
    'Reports',
    'ResumeAlerts',
    'Resumes',
    'Reviews',
    'Schedules',
    'ScoreCards',
    'SearchResultPages',
    'Subscriptions',
    'TaskActions',
    'TaskLists',
    'Uncategorised',
    'Vendors',
    'VideoObjects',
    'WorkFlows'
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
    'params'           => '{"category_layout": "", "robots":"","image": "", "image_alt": "", "thumbnail_aspect_ratio": "aspect-ratio-4-3", "image_aspect_ratio": "aspect-ratio-4-3"}',
    'metadata'         => '{"author": "", "robots": ""}',
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
	 * Default models to add / remove asset records for on install / uninstall of the Job Board
	 *
	 * @var    Array
	 */
  public $assetEnabledModels = array(
    'Answers'
  );


  /**
	 * Overridden class constructor
	 */
  public function __construct()
	{
    $this->componentTitle = Text::_('COM_CAJOBBOARD');
  }


	/**
	 * Called before any type of action. Verifications and pre-requisites should run in this function.
	 *
	 * @param   string            $type    Which action is happening (install|uninstall|discover_install|update)
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
  public function preflight($type, \JAdapterInstance $adapter)
  {
    parent::preflight($type, $adapter);

    $this->checkRequiredPhpModules();

    // abort if the component being installed is not newer than the currently installed version
    if ($type == 'update' && !$this->isInstallVersionNewer())
    {
      return false;
    }

    return true;
  }


  /**
   * Add a message to the post install message queue
   * 
   *
	 * The $options array contains the following mandatory keys:
	 *
	 *   type                 One of message, link or action. Their meaning is:
   *
	 *                        message     Informative message. The user can dismiss it.
   *
	 *                        link        The action button links to a URL. The URL is defined in the action parameter.
   *
	 *                        action      A PHP action takes place when the action button is clicked. You need to specify the
	 *                                    action_file (RAD path to the PHP file) and action (PHP function name) keys. See
	 *                                    below for more information.
	 *
	 *   title_key            The translation key for the title of this PIM
	 *
	 *   description_key      The translation key for the main body (description) of this PIM
   *
	 *   language_extension   The extension name which holds the translation keys used above
	 *
	 *   language_client_id   Should we load the front-end (0) or back-end (1) translation keys?
	 *
	 *   version_introduced   Which was the version of your extension where this message appeared for the first time?
	 *                        Example: 3.2.1
	 *
	 *   enabled              Must be 1 for this message to be enabled. If you omit it, it defaults to 1.
	 *
	 *   condition_file       The RAD path (e.g. admin://components/com_foobar/helpers/postinstall.php) to a PHP file
	 *                        containing a PHP function which determines whether this message should be shown to the user.
   *                        Joomla! will include this file before calling the condition_method.
	 *
	 *   condition_method     The name of a PHP function which will be used to determine whether to show this message to
	 *                        the user. This must be a simple PHP user function (not a class method, static method etc)
	 *                        which returns true to show the message and false to hide it. This function is defined in the
	 *                        condition_file.
	 *
   *
	 * The following additional keys are required when the 'type' key's value is 'link':
	 *
	 *   action               The URL which will open when the user clicks on the PIM's action button
	 *                        Example:    index.php?option=com_foobar&view=tools&task=installSampleData
   *
	 *   action_key           The translation key for the action button. Ignored and not required when the 'type' key's value is 'message'
	 *
   *
	 * The following additional keys are required when the 'type' key's value is 'action':
	 *
	 *   action_file          The RAD path to a PHP file containing a PHP function which performs the action of this PIM.
	 *
	 *   action               The name of a PHP function which will be used to run the action of this PIM. This must be a
	 *                        simple PHP user function (not a class method, static method etc) which returns no result.
   *
	 *   action_key           The translation key for the action button. Ignored and not required when the 'type' key's value is 'message'
   *
   * @param   array   $options    See fof/Utils/InstallScript/BaseInstaller.php for description
   */
  protected function setPostInstallationMessage(array $options)
	{
    $defaultOptions = array(
      'type'               => 'message',
      'title_key'          => '',
      'description_key'    => '',
      'language_extension' => 'com_cajobboard',
      'language_client_id' => '1',
      'condition_file'     => '',
      'condition_method'   => '',
      'version_introduced' => '1.0',
      'enabled'            => '1',
    );

    foreach ($options as $key => $value)
    {
      $defaultOptions[$key] = $value;
    }

    array_push($this->postInstallationMessages, $defaultOptions);
  }


	/**
	 * Called after any type of action is ran, can set parameters for component here
	 *
	 * @param   string            $type     Which action is happening (install|uninstall|discover_install|update)
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
  public function postflight($type, \JAdapterInstance $adapter)
  {
    parent::postflight($type, $adapter);

    if ($type == 'install' || $type == 'discover_install')
    {
      $this->createCategories();
      $this->addUserGroups();
      $this->seedMessageRootRecord();
      $this->seedCommentRootRecord();
      $this->seedDefaultRecordData();
    }

    return true;
  }


	/**
	 * Called on installation
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
  public function install(\JAdapterInstance $adapter)
  {
    $this->setParams();

    $adapter->getParent()->setRedirectURL('index.php?option=com_cajobboard');

    return true;
  }


	/**
	 * Called on update
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
  public function update(\JAdapterInstance $adapter)
  {
    return true;
  }


	/**
	 * Called on uninstall
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 */
  public function uninstall(\JAdapterInstance $adapter)
  {
    parent::uninstall($adapter);

    return true;
  }


	/**
	 * Make sure the component being installed is newer than the version already installed
	 *
	 * @return  boolean  True if component update is newer than installed version
	 */
  public function isInstallVersionNewer()
  {
    // Get a db connection so we can find the installed version from #__extensions
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query
      ->select  ($db->quoteName('manifest_cache'))
      ->from    ($db->quoteName('#__extensions'))
      ->where   ($db->quoteName('element') . ' = '. $db->quote('com_cajobboard'));

    $db->setQuery($query);

    $manifest         = json_decode($db->loadResult(), true);
    $installedRelease = $manifest['version'];

    if (version_compare($newRelease, $installedRelease, 'le'))
    {
      JFactory::getApplication()->enqueueMessage(
        Text::sprintf('COM_CAJOBBOARD_NO_UPDATE_TO_AN_OLDER_VERSION', $installedRelease, $newRelease), 'error'
      );

      return false;
    }

    return true;
  }


	/**
	 * Update component parameters
	 */
  public function setParams()
  {
    /*
    // @TODO: Decide if we want any params initialised on component install
    // always create or modify these parameters for any action
	  $params['component_version'] = 'Component version ' . $parent->get('manifest')->version;

    // define the following parameters only if it is an original install
    if ( $type == 'install' )
    {
      $params['cajobboard_param'] = '4';
    }

    // parent method?
    $this->setParams($params);
    */
  }


  /**
	 * Renders the post-installation message
   *
   * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 */
	protected function renderPostInstallation(\JAdapterInstance $adapter)
	{
		?>
      <h1>Calligraphic Job Board</h1>
      <h2 style="font-size: 14pt; font-weight: bold; padding: 0; margin: 0 0 0.5em;">Welcome to Calligraphic Job Board!</h2>
      <table width="100%" class="adminlist">
        <thead>
          <tr>
            <!--<td colspan="3" style="text-align: center;" align="center"><img style='vertical-align: middle;' src='media/com_cajobboard/images/calligraphic_logo.png'></td>-->
          </tr>
          <tr>
            <td colspan="1" align="right" width="33%" style="font-weight: bold; padding-right: 15px; text-align: right;">Version:</td>
            <td colspan="2" align="left">0.0.1</td>
          </tr>
          <tr>
            <td colspan="1" align="right" style="font-weight: bold; padding-right: 15px; text-align: right;">Release Date:</td>
            <td colspan="2" align="left">August 2018</td>
          </tr>
          <tr>
            <td colspan="1" align="right" style="font-weight: bold; padding-right: 15px; text-align: right;">Author:</td>
            <td colspan="2" align="left"><a href="www.calligraphic.design"></a>Calligraphic Design</a></td>
          </tr>
          <tr>
            <td colspan="1" align="right" style="font-weight: bold; padding-right: 15px; text-align: right;">Copyright:</td>
            <td colspan="2" align="left" style="width: 375px;">&copy;&nbsp;2018 Calligraphic Design, All rights reserved.</td>
          </tr>
          <tr>
            <td colspan="1" align="right" style="font-weight: bold; padding-right: 15px; text-align: right;">License:</td>
            <td colspan="2" align="left">GNU General Public License</td>
          </tr>
          <tr><td colspan="3" style="padding-bottom: 15px;">&nbsp;</td></tr>
        </thead>
      </table>
		<?php
  }


  /**
	 * Renders the post-uninstall message
   *
   * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 */
	protected function renderPostUninstallation(\JAdapterInstance $adapter)
	{
		?>
      <h2 style="font-size: 14pt; font-weight: bold; padding: 0; margin: 0 0 0.5em;">&nbsp;Callibraphic Job Board Uninstallation</h2>
      <p>We are sorry that you decided to uninstall Calligraphic Job Board.</p>
		<?php
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
        throw new \Exception($category->getError(), 500);

        return false;
      }

      // Store the category
      if (!$category->store(true))
      {
        throw new \Exception($category->getError(), 500);

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
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query
      ->select  ($db->quoteName('title'))
      ->from    ($db->quoteName('#__categories'))
      ->where   ($db->quoteName('extension') . ' = '. $db->quote('com_cajobboard'));

    $db->setQuery($query);

    return $db->loadColumn();
  }


  /**
   * Add user groups on installation
   *
   * @return void
   */
  function addUserGroups()
  {
    Log::add('User groups added in installation script', JLog::DEBUG, 'com_cajobboard');

    $db = JFactory::getDbo();

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


  /**
   * Initialize Comments and Messages model
   *
   * @return void
   */
  function seedCommentRootRecord()
  {
    $this->insertTreeRootRecord('#__cajobboard_comments');
  }


  /**
   * Initialize Comments and Messages model
   *
   * @return void
   */
  function seedMessageRootRecord()
  {
    $this->insertTreeRootRecord('#__cajobboard_messages');
  }


  /**
   * Insert mandatory root record for nested set hierarchical tables (FOF TreeModel)
   * 
   * @param string $tableName   The name of the table to initialize
   *
   * @throws \RuntimeException
   *
   * @return boolean  Whether the root record could be inserted successfuly
	 */
  protected function insertTreeRootRecord($tableName)
  {
    $root = new \stdClass();

    $root->slug = 'root';
    $root->name = 'Root Node';
    $root->description = 'The root node for this table.';
    $root->lft = '1';
    $root->rgt = '2';
    $root->hash = sha1($root->slug);

    return \JFactory::getDbo()->insertObject($tableName, $root);
  }


  /**
   * Insert mandatory root record for nested set hierarchical tables (FOF TreeModel)
   * @param string $tableName   The name of the table to initialize
   *
   * @throws \RuntimeException
	 */
  protected function checkRequiredPhpModules()
  {
    // Make sure BCMATH is installed to support MySQL geospatial operations
    $isBcmathInstalled = extension_loaded('bcmath');


    if (!$isBcmathInstalled)
    {
      $options = array(
        'title_key'          => 'COM_CAJOBBOARD_PIM_BCMATH_MISSING_TITLE',
        'description_key'    => 'COM_CAJOBBOARD_PIM_BCMATH_MISSING_DESC'
      );

      $this->setPostInstallationMessage($options);
    }
  }


  /**
   * Save default table records using the CLI Seeder system, instead of SQL INSERT queries
   * in the installation files so that tables that have data populated from other tables
   * (e.g. finding the proper category to enter for a 'cat_id' field) work properly.
   *
   * Used by: EmploymentTypes
   *
   * @return void
   */
  function seedDefaultRecordData()
  {
    // Make sure PHP is available as CLI
    if ( shell_exec("command -v php") )
    {
      // Seed default records
      exec("php " . JPATH_ADMINISTRATOR . "/components/com_cajobboard/Cli/Seeder/PopulateSampleData.php DataFeedTemplates");
      exec("php " . JPATH_ADMINISTRATOR . "/components/com_cajobboard/Cli/Seeder/PopulateSampleData.php EmailMessageTemplates");
      exec("php " . JPATH_ADMINISTRATOR . "/components/com_cajobboard/Cli/Seeder/PopulateSampleData.php EmploymentTypes");
    }
    else
    {
      throw new \Exception('PHP CLI is required for installation of the Job Board, and not available in the current environment');
    }
  }
}
