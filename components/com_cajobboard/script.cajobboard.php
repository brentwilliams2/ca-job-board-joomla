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
	 * Array of category entries
	 */
  $categories = json_decode('{
    "0": {
      "title": "Places",
      "alias": "places",
      "note": "",
      "description": "<p>Images depicting a place or location</p>",
      "metadesc": "",
      "params": {
        "category_layout": "",
        "image": "",
        "image_alt": "",
        "thumbnail_aspect_ratio": "aspect-ratio-4-3",
        "image_aspect_ratio": "aspect-ratio-4-3"
      },
      "metadata": {
        "author": "",
        "robots": ""
      }
    },
    "1": {
      "title": "Persons",
      "alias": "persons",
      "note": "",
      "description": "<p>Thumbnail images representing a user</p>",
      "metadesc": "",
      "params": {
        "category_layout": "",
        "image": "",
        "image_alt": "",
        "thumbnail_aspect_ratio": "aspect-ratio-1-1",
        "image_aspect_ratio": "aspect-ratio-4-3"
      },
      "metadata": {
        "author": "",
        "robots": ""
      }
    },
    "2": {
      "title": "Organizations",
      "alias": "organizations",
      "note": "",
      "description": "<p>Logo images for an organization</p>",
      "metadesc": "",
      "params": {
        "category_layout": "",
        "image": "",
        "image_alt": "",
        "thumbnail_aspect_ratio": "aspect-ratio-4-3",
        "image_aspect_ratio": "aspect-ratio-4-3"
      },
      "metadata": {
        "author": "",
        "robots": ""
      }
    }
  }', true);


  /**
   * Add categories for component in postflight programatically in order to maintain nested table structure in #__categories
   *
   * @param  string    $type   - Type of PostFlight action. Possible values are:
   *                           - * install
   *                           - * update
   *                           - * discover_install
   * @return void
   */
  function postflight($type)
  {
    if ($type == 'update' || 'discover_install')
    {
      foreach ($categories as $data)
      {
        // Convert array to JSON string for params and metadata properties
        $data['params']           = json_encode($data['params']);
        $data['metadata']         = json_encode($data['metadata']);

        // Set default values for category
        $data['extension']        = "com_cajobboard";
        $data['published']        = "1";
        $data['access']           = "1";
        $data['created_user_id']  = "0";
        $data['language']         = "*";

        createCategory($data);
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

    // Build the path for our category
    $category->rebuildPath($category->id);
  }
}
