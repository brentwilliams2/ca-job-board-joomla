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

// no direct access
defined('_JEXEC') or die;

class com_cajobboardInstallerScript
{
	/**
	 * Default category entries to add on installation for the Job Board
	 *
	 * @var    Array
	 */
  public $categories = array(
    "Uncategorised",
    "Places",
    "Persons",
    "Organizations",
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
   * Add categories for component in postflight programatically
   * in order to maintain nested table structure in #__categories
   *
   * @param  string    $type   - Type of PostFlight action. Possible values are:
   *                           - * install
   *                           - * update
   *                           - * discover_install
   * @return void
   */
  function postflight($type)
  {
    if ($type == 'install' || 'discover_install')
    {
      foreach ($this->categories as $category)
      {
        $data = array_merge($this->$categoryTemplate);

        // Set the category description from the translation key in en-GB.com_cajobboard.ini
        $data['description'] = JText::_('COM_CAJOBBOARD_CATEGORY_TITLE_' . strtoupper($category));

        $this->createCategory($data);
      }
    }
  }


  /**
   * Add category
   *
   * @param  \stdClass    $data   Object with category properties

   * @return void
   */
  function createCategory($data)
  {
    // Initialize a new category
    $category = JTable::getInstance('Category');

    // Bind passed category parameters to Category model
    foreach ($data as $property => $value) {
      $category->$property = $value;
    }

    // Set the location in the tree
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
}
