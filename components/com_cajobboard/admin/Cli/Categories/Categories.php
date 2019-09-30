<?php
/**
 * CLI Script to add Categories conveniently
 *
 * @package   Calligraphic Job Board
 * @version   September 2, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

include realpath(__DIR__ . '/../CliApplication.php');

use \Calligraphic\Cajobboard\Admin\Cli\Seeder\Exception\CliApplicationException;
use \Calligraphic\Library\Platform\Language;
use \FOF30\Container\Container;
use \Joomla\CMS\Access\Rules;
use \Joomla\CMS\Factory;
use \Joomla\CMS\Language\Text;
use \Joomla\CMS\Table\Table;

/**
 * Category CLI Manager
 *
 */
class Categories extends CliApplication
{
  /**
   * Category parameters
   *
   * @var array
   */
  private $params = array(
    'category_layout' => '',
    'image' => '',
    'image_alt' => '',
    'thumbnail_aspect_ratio' => 'aspect-ratio-4-3',
    'image_aspect_ratio' => 'aspect-ratio-4-3'
  );

  /**
   * Entry point for the script
   *
   * @return  void
   */
  public function execute()
  {
    // Create the FOF Container object
    parent::execute();

    // Allow deleting a category
    if ( count($this->input->args) == 2 &&  $this->input->args[0] == 'delete' )
    {
      $this->deleteCategory($this->input->args[1]);

      return;
    }

    // Make sure there's only one argument
    if ( count($this->input->args) != 1 )
    {
      throw new CliApplicationException("Too many arguments, only a single category name permitted.\n" );
    }

    // Allow seeding Question and Answer Page categories
    if ( $this->input->args[0] == 'seedQAPageCategories' )
    {
      $this->seedQAPageCategories();
      return;
    }

    $fieldArray = $this->getFieldArray($this->input->args[0]);

    $this->addCategory($fieldArray);
  }


  /**
   * Initialize the array representing the model fields
   *
   * @param   array   $categoryName   An array of Category table properties and values to enter for a record
   *
   * @return  void
   */
  public function getFieldArray($categoryName)
  {
    $underscored = $this->container->inflector->underscore($categoryName);
    $humanized   = $this->container->inflector->humanize($underscored);
    $hyphenated  = $this->container->inflector->hyphenate($categoryName);

    return array(
      'id'          => 0,  // Force a new node to be created
      'parent_id'   => 1,
      'level'       => 1,
      'extension'   => 'com_cajobboard',
      'path'        => $hyphenated,
      'title'       => $humanized,
      'alias'       => $hyphenated,
      'description' => $humanized,
      'published'   => 1,
      'access'      => 1,
      'params'      => $this->params,
      'language'    => '*',
      'metadesc'    => '',
      'metakey'     => '',
      'metadata'    => array('author' => '', 'robots' => ''),
      'note'        => '',
    );
  }



  /**
   * Add a category to the Joomla! category table
   *
   * @param   array   $fieldArray   An array of Category table properties and values to enter for a record
   *
   * @return  void
   */
  public function addCategory($fieldArray)
  {
    $model = Table::getInstance('category');

    // Specify where to insert the new node.
    $model->setLocation($fieldArray['parent_id'], 'last-child');

    $model->bind($fieldArray);

    $rules = array(
      'core.edit.state' => array(),
      'core.edit.delete' => array(),
      'core.edit.edit' => array(),
      'core.edit.state' => array(),
      'core.edit.own' => array(1 => true)
    );

    $rules = new Rules($rules);

    $model->setRules($rules);

    if ( !$model->check() )
    {
      throw new \Exception('The category model failed the check method before saving');
    }

    $status = $model->store();

    if ($status)
    {
      echo "Successfully added category " . $fieldArray['alias'] . "\n";
    }
    else
    {
      echo "Could not add the category with path " . $fieldArray['alias'] . ", is it an existing category?\n";
    }
  }


  /**
   * Delete a category to the Joomla! category table
   *
   * @param   string   $category   The category to delete, in CamelCase
   *
   * @return  void
   */
  public function deleteCategory($category)
  {
      $model = Table::getInstance('category');

      $normalCategory = $this->container->inflector->hyphenate($category);

      $status = $model->load( array('extension' => 'com_cajobboard', 'path' => $normalCategory) );

      if ($status)
      {
        $model->delete();

        echo "Successfully deleted category $normalCategory \n";
      }
      else
      {
        echo "Could not find the category that has the path $normalCategory \n";
      }
  }


  /**
   * Seed the Question and Answer Page categories
   *
   * @return  void
   */
  public function seedQAPageCategories()
  {
    // Load the QAPages language file
    $lang = JFactory::getLanguage();

    $lang->load('qapages', JPATH_ADMINISTRATOR . '/components/com_cajobboard', 'en-GB', true);

    // Get the parent 'QAPages' category
    $db = Factory::getDbo();

    $query = $db->getQuery(true);

    $query
      ->select('id')
      ->from($db->quoteName('#__categories'))
      ->where($db->quoteName('alias')." = ".$db->quote('qapages'));

    // Reset the query using our newly populated query object.
    $db->setQuery($query);

    $parentCategory = $db->loadResult();

    $categories = array(
      array('title' => 'CAJOBBOARD_QAPAGE_CATEGORY_BENEFITS', 'description' => 'COM_CAJOBBOARD_QAPAGE_CATEGORY_BENEFITS_DESCRIPTION'),
      array('title' => 'CAJOBBOARD_QAPAGE_CATEGORY_CAREER_DEVELOPMENT', 'description' => 'COM_CAJOBBOARD_QAPAGE_CATEGORY_CAREER_DEVELOPMENT_DESCRIPTION'),
      array('title' => 'CAJOBBOARD_QAPAGE_CATEGORY_COMMUNICATION', 'description' => 'COM_CAJOBBOARD_QAPAGE_CATEGORY_COMMUNICATION_DESCRIPTION'),
      array('title' => 'CAJOBBOARD_QAPAGE_CATEGORY_COMPENSATION', 'description' => 'COM_CAJOBBOARD_QAPAGE_CATEGORY_COMPENSATION_DESCRIPTION'),
      array('title' => 'CAJOBBOARD_QAPAGE_CATEGORY_CULTURE', 'description' => 'COM_CAJOBBOARD_QAPAGE_CATEGORY_CULTURE_DESCRIPTION'),
      array('title' => 'CAJOBBOARD_QAPAGE_CATEGORY_DIVERSITY', 'description' => 'COM_CAJOBBOARD_QAPAGE_CATEGORY_DIVERSITY_DESCRIPTION'),
      array('title' => 'CAJOBBOARD_QAPAGE_CATEGORY_ENVIRONMENTAL_FRIENDLINESS', 'description' => 'COM_CAJOBBOARD_QAPAGE_CATEGORY_ENVIRONMENTAL_FRIENDLINESS_DESCRIPTION'),
      array('title' => 'CAJOBBOARD_QAPAGE_CATEGORY_HANDICAPPED_ACCESSIBILITY', 'description' => 'COM_CAJOBBOARD_QAPAGE_CATEGORY_HANDICAPPED_ACCESSIBILITY_DESCRIPTION'),
      array('title' => 'CAJOBBOARD_QAPAGE_CATEGORY_IMPROVEMENT', 'description' => 'COM_CAJOBBOARD_QAPAGE_CATEGORY_IMPROVEMENT_DESCRIPTION'),
      array('title' => 'CAJOBBOARD_QAPAGE_CATEGORY_JOB_SECURITY', 'description' => 'COM_CAJOBBOARD_QAPAGE_CATEGORY_JOB_SECURITY_DESCRIPTION'),
      array('title' => 'CAJOBBOARD_QAPAGE_CATEGORY_MANAGEMENT', 'description' => 'COM_CAJOBBOARD_QAPAGE_CATEGORY_MANAGEMENT_DESCRIPTION'),
      array('title' => 'CAJOBBOARD_QAPAGE_CATEGORY_PERKS', 'description' => 'COM_CAJOBBOARD_QAPAGE_CATEGORY_PERKS_DESCRIPTION'),
      array('title' => 'CAJOBBOARD_QAPAGE_CATEGORY_TEAMWORK', 'description' => 'COM_CAJOBBOARD_QAPAGE_CATEGORY_TEAMWORK_DESCRIPTION'),
      array('title' => 'CAJOBBOARD_QAPAGE_CATEGORY_WORK_ENVIRONMENT', 'description' => 'COM_CAJOBBOARD_QAPAGE_CATEGORY_WORK_ENVIRONMENT_DESCRIPTION'),
      array('title' => 'CAJOBBOARD_QAPAGE_CATEGORY_WORK_LIFE_BALANCE', 'description' => 'COM_CAJOBBOARD_QAPAGE_CATEGORY_WORK_LIFE_BALANCE_DESCRIPTION'),
      array('title' => 'CAJOBBOARD_QAPAGE_CATEGORY_WORKPLACE_SAFETY', 'description' => 'COM_CAJOBBOARD_QAPAGE_CATEGORY_WORKPLACE_SAFETY_DESCRIPTION'),
      array('title' => 'CAJOBBOARD_QAPAGE_CATEGORY_OTHER', 'description' => 'COM_CAJOBBOARD_QAPAGE_CATEGORY_OTHER_DESCRIPTION')
    );

    foreach ($categories as $category)
    {
      $hyphenated  = str_replace('cajobboard-qapage-category-', '', strtolower( preg_replace('/_/', '-', Text::_( $category['title'] ))));

      //$this->addCategory(
      $this->addCategory(
        array(
          'id'          => 0,  // Force a new node to be created
          'parent_id'   => $parentCategory,
          'level'       => 2,
          'extension'   => 'com_cajobboard',
          'path'        => 'qapages/' . $hyphenated,
          'title'       => $category['title'],
          'alias'       => $hyphenated,
          'description' => $category['description'],
          'published'   => 1,
          'access'      => 1,
          'params'      => $this->params,
          'language'    => '*',
          'metadesc'    => '',
          'metakey'     => '',
          'metadata'    => array('author' => '', 'robots' => ''),
          'note'        => '',
        )
      );
    }
  }
}

// Execute this CLI application
$app = CliApplication::getInstance('Categories');
Factory::$application = $app;
$app->execute();






