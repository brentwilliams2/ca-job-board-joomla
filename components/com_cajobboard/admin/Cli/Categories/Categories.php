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

/**
 * Category CLI Manager
 *
 */
class Categories extends CliApplication
{
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
      'params'      => array('category_layout' => '', 'image' => '', 'image_alt' => '', 'thumbnail_aspect_ratio' => 'aspect-ratio-4-3', 'image_aspect_ratio' => 'aspect-ratio-4-3'),
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
    $model = JTable::getInstance('category');

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

    $rules = new JAccessRules($rules);

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
      $model = JTable::getInstance('category');

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
}

// Execute this CLI application
$app = CliApplication::getInstance('Categories');
\JFactory::$application = $app;
$app->execute();






