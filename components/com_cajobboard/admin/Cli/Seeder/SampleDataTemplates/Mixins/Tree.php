<?php
/**
 * Trait for checking consistency of Tree Data Models
 *
 * @package   Calligraphic Job Board
 * @version   September 8, 2019
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2019 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Use by overriding default constructor in sample data template:
 *
 *   public function __construct()
 *   {
 *     $this->validateTreeTable('#__cajobboard_tablename');
 *   }
 */

namespace Calligraphic\Cajobboard\Admin\Cli\Seeder\SampleDataTemplates\Mixins;

// no direct access
defined('_JEXEC') or die;

trait Tree
{
 	/**
	 * Whether the tree table has an initial root node initialized
	 *
	 * @var   boolean
	 */
  protected $hasRoot = false;


	/**
	 * Called from class constructor
   *
   * @throws \RuntimeException
	 */
  public function validateTreeTable($tableName)
  {
    $this->hasRoot = $this->hasRoot($tableName);

    if (!$this->hasRoot)
    {
      $this->hasRoot = $this->insertRoot($tableName);
    }
  }


	/**
	 * Determines if a Tree Model database table has a root initalized
   *
   * @param string $tableName   The name of the table to check
   *
   * @throws \RuntimeException
   *
   * @return boolean  Whether the table has a root record
	 */
  protected function hasRoot($tableName)
  {
    $db = \JFactory::getDbo();

    $query = $db->getQuery(true);

    $query
      ->select('COUNT(*)')
      ->from($db->quoteName($tableName));

    // Reset the query using our newly populated query object.
    $db->setQuery($query);

    return (bool) $db->loadResult();
  }


	/**
	 * Inserts a root record into the tree model to initialize the database table
   *
   * @param string $tableName   The name of the table to initialize
   *
   * @throws \RuntimeException
   *
   * @return boolean  Whether the root record could be inserted successfuly
	 */
  protected function insertRoot($tableName)
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
}