<?php
/**
 * Helper class for preparing permissions data to display in admin tab at item (object/record) level
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC, (c)2010-2019 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 *
 */

namespace Calligraphic\Cajobboard\Admin\Helper;

use \Joomla\CMS\Access\Access;
use \Joomla\CMS\Factory;

// no direct access
defined('_JEXEC') or die;

// @TODO: finish Permissiosn helper class

abstract class Permissions
{
	/**
	 * Method to get the field input markup for Access Control Lists.
	 * Optionally can be associated with a specific component and section.
	 *
	 * @return  string
	 */
	public static function permissions()
	{
		// Initialise some field attributes.
    $section    = 'records';
    $component  = 'com_cajobboard';

		// Get the actions for the asset. Each action is an object with the keys 'name', 'title', and 'description', set in config.xml
    $actions = Access::getActions($component, $section);

		// Get the asset id.
		// Note that for global configuration, com_config injects asset_id = 1 into the form.
    $assetId       = $this->form->getValue('asset_id'); // get the value from the model
    $parentAssetId = null;


    $db = Factory::getDbo();

		// If the asset id is empty (component or new item).
		if (empty($assetId))
		{
			// Get the component asset id as fallback.
			$query = $db->getQuery(true)
				->select($db->quoteName('id'))
				->from($db->quoteName('#__assets'))
        ->where($db->quoteName('name') . ' = ' . $db->quote($component));

      $db->setQuery($query);

			$assetId = (int) $db->loadResult();
			/**
			 * @to do: incorrect info
			 * When creating a new item (not saving) it uses the calculated permissions from the component (item <-> component <-> global config).
			 * But if we have a section too (item <-> section(s) <-> component <-> global config) this is not correct.
			 * Also, currently it uses the component permission, but should use the calculated permissions for a child of the component/section.
			 */
    }

		// If not in global config we need the parent_id asset to calculate permissions.
    // In this case we need to get the component rules too.
    $query = $db->getQuery(true)
      ->select($db->quoteName('parent_id'))
      ->from($db->quoteName('#__assets'))
      ->where($db->quoteName('id') . ' = ' . $assetId);

    $db->setQuery($query);

    $parentAssetId = (int) $db->loadResult();

		// Full width format.
		// Get the rules for just this asset (non-recursive).
    $assetRules = Access::getAssetRules($assetId, false, false);

		// Get the available user groups.
		$groups = $this->getUserGroups();
  }
}
