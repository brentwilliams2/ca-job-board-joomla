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

JLog::addLogger(array('text_file' => 'com_cajobboard.log.php'), JLog::DEBUG, array('com_cajobboard'));

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
    'VideoObjects'
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
    $this->componentTitle = JText::_('COM_CAJOBBOARD');
  }


	/**
	 * Called before any type of action. Verifications and pre-requisites should run in this function.
	 *
	 * @param   string            $type    Which action is happening (install|uninstall|discover_install|update)
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
  public function preflight($type, JAdapterInstance $adapter)
  {
    parent::preflight($type, $adapter);

    // @TODO: Add a Post-Installation Message (PIM) to show as a flash message in the admin's dashboard area
    // See fof/Utils/InstallScript/BaseInstaller.php
    // $this->addPostInstallationMessage($options);

    // abort if the component being installed is not newer than the currently installed version
    if ($type == 'update' && !$this->isInstallVersionNewer())
    {
      return false;
    }

    return true;
  }


	/**
	 * Called after any type of action is ran, can set parameters for component here
	 *
	 * @param   string            $type     Which action is happening (install|uninstall|discover_install|update)
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
  public function postflight($type, JAdapterInstance $adapter)
  {
    parent::postflight($type, $adapter);

    if ($type == 'install' || $type == 'discover_install')
    {
      $this->createCategories();
      $this->addUserGroups();
      $this->seedMessageRootRecord();
      $this->seedCommentRootRecord();
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
  public function install(JAdapterInstance $adapter)
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
  public function update(JAdapterInstance $adapter)
  {
    return true;
  }


	/**
	 * Called on uninstall
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 */
  public function uninstall(JAdapterInstance $adapter)
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
    JLog::add('Version to be installed checked for newer in installation script', JLog::DEBUG, 'com_cajobboard');

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
        JText::sprintf('COM_CAJOBBOARD_NO_UPDATE_TO_AN_OLDER_VERSION', $installedRelease, $newRelease), 'error'
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
	protected function renderPostInstallation($adapter)
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
	protected function renderPostUninstallation($adapter)
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
      $data['title'] = JText::_('COM_CAJOBBOARD_CATEGORY_TITLE_' . strtoupper(str_replace(' ', '', $category)));
      $data['description'] = $data['title'];

      // Initialize a new category
      $category = \JTable::getInstance('Category');

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

    \JTable::getInstance('Category')->rebuild();
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
    JLog::add('User groups added in installation script', JLog::DEBUG, 'com_cajobboard');

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
        $groupModel = \JTable::getInstance('Usergroup');

        $groupModel->save(array(
          'title' => $userGroup,
          'parent_id' => $registeredGroupId
        ));
      }
    }

    \JTable::getInstance('Usergroup')->rebuild();
  }


  /**
   * Initialize Comments model
   *
   * @return void
   */
  function seedCommentRootRecord()
  {
    $this->insertTreeRootRecord();
  }


  /**
   * Initialize Comments model
   *
   * @return void
   */
  function seedMessageRootRecord()
  {
    $this->insertTreeRootRecord();
  }


  /**
   * Insert mandatory root record for nested set hierarchical tables (FOF TreeModel)
   *
   * @return void
   */
  function insertTreeRootRecord()
  {

  }
}
