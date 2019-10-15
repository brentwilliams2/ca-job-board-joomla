<?php
/**
 * FOF model behavior class to backfill the slug field with the
 * 'title' property or its fieldAlias if the slug field is empty.
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */
namespace Calligraphic\Cajobboard\Admin\Model\Behaviour;

use \FOF30\Event\Observer;
use \FOF30\Model\DataModel;
use \Joomla\CMS\Application\ApplicationHelper;

// no direct access
defined( '_JEXEC' ) or die;


/**
 * @TODO: Submit a PR, there is code for this in DataModel's check()
 *        method but it isn't handling field aliases correctly. See
 *        how $item->$slugfield is set below for solution.
 */
class Slug extends Observer
{
	/**
	 * Add the slug field to the fieldsSkipChecks list of the model. It
	 * should be empty so that we can fill them in through this behaviour.
	 *
	 * @param   DataModel  $item
	 */
	public function onBeforeCheck(DataModel $item)
	{
    $slugField = $item->getFieldAlias('slug');

    if ( $item->hasField($slugField) )
    {
      $item->addSkipCheckField($slugField);
    }
	}


	/**
	 * Transform the 'title' model field to a valid 'slug' SEF-friendly URL
	 * field and set it in $data, e.g. lower-cased text and hyphenated
	 *
	 * Slug validation set to 'onBeforeSave' event so that it is set when
	 * the check() method is ran during the 'save' task's method. The TreeModel
	 * uses the slug field during check() to generate a hash for fast indexing.
	 *
	 * @param   DataModel  $item
	 * @param   array  $data
	 */
	public function onBeforeSave(DataModel $item, &$data)
	{
		// The $data parameter can be null if there is no user input to save
		if ( empty($data) )
		{
			return;
		}

		// Create a slug if there is a title and an empty slug
    $slugField  = $item->getFieldAlias('slug');
    $titleField = $item->getFieldAlias('title');

    if (
			// sanity check
			$item->hasField($slugField) &&
			$item->hasField($titleField) &&
			(
				// scenario for saving an item where the slug field has already been set, and is not in user input
				!$item->getFieldValue($slugField) ||
				// scenario where slug field is set in user input
				empty( $data[$slugField] )
			)
		)
    {
      $data[$slugField] = ApplicationHelper::stringURLSafe( $item->getFieldValue($titleField) );
    }
	}
}
